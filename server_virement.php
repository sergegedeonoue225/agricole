<?php
session_start();
include 'database.php';

// Inclure les fichiers de PHPMailer
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';
require 'phpmailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Vérifier si l'utilisateur est connecté avant d'accéder à ses informations
if (!isset($_SESSION['user_name'])) {
    header('Location: login.php');
    exit;
}

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Créer la table des virements si elle n'existe pas déjà
    $sql = 'CREATE TABLE IF NOT EXISTS virements (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        nom_beneficiaire VARCHAR(255) NOT NULL,
        email_beneficiaire VARCHAR(255) NOT NULL,
        montant DECIMAL(10, 2) NOT NULL,
        numero_telephone VARCHAR(20) NOT NULL,
        motif VARCHAR(255) NOT NULL,
        rib VARCHAR(255) NOT NULL,
        date_virement TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES utilisateurs(id)
    )';
    $conn->exec($sql);

    // Vérifier si le formulaire a été soumis
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Vérifier que toutes les valeurs attendues sont définies
        $required_fields = ['nom', 'email', 'montant', 'numero_telephone', 'motif', 'rib'];
        foreach ($required_fields as $field) {
            if (!isset($_POST[$field]) || empty($_POST[$field])) {
                throw new Exception("Le champ $field est requis et ne peut être vide.");
            }
        }

        $nom = $_POST['nom'];
        $email = $_POST['email'];
        $montant = $_POST['montant'];
        $numero_telephone = $_POST['numero_telephone'];
        $motif = $_POST['motif'];
        $rib = $_POST['rib'];

        // Calcul des frais de solvabilité
        $frais_solvabilite = $montant * 0.02;

        // Récupérer les informations de l'utilisateur connecté
        $stmt = $conn->prepare('SELECT solde FROM utilisateurs WHERE id = :id');
        $stmt->bindParam(':id', $_SESSION['user_id']);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && $user['solde'] >= $montant) {
            // Déduire le montant du virement du solde de l'utilisateur
            $newSolde = $user['solde'] - $montant;
            $updateStmt = $conn->prepare('UPDATE utilisateurs SET solde = :newSolde WHERE id = :id');
            $updateStmt->bindParam(':newSolde', $newSolde);
            $updateStmt->bindParam(':id', $_SESSION['user_id']);
            $updateStmt->execute();

            // Insérer le virement dans la table des virements avec le statut "en attente"
            $insertStmt = $conn->prepare('INSERT INTO virements (user_id, nom_beneficiaire, email_beneficiaire, montant, numero_telephone, motif, rib) VALUES (:user_id, :nom_beneficiaire, :email_beneficiaire, :montant, :numero_telephone, :motif, :rib)');
            $insertStmt->bindParam(':user_id', $_SESSION['user_id']);
            $insertStmt->bindParam(':nom_beneficiaire', $nom);
            $insertStmt->bindParam(':email_beneficiaire', $email);
            $insertStmt->bindParam(':montant', $montant);
            $insertStmt->bindParam(':numero_telephone', $numero_telephone);
            $insertStmt->bindParam(':motif', $motif);
            $insertStmt->bindParam(':rib', $rib);
            $insertStmt->execute();

            // Lire le contenu du fichier email_virement.html
            $emailContent = file_get_contents('email_virement.html');
            if ($emailContent === false) {
                throw new Exception("Erreur lors de la lecture du fichier email_virement.html");
            }

            // Remplacer les variables par leurs valeurs
            $emailContent = str_replace('{nom}', htmlspecialchars($nom), $emailContent);
            $emailContent = str_replace('{montant}', htmlspecialchars($montant), $emailContent);
            $emailContent = str_replace('{motif}', htmlspecialchars($motif), $emailContent);
            $emailContent = str_replace('{rib}', htmlspecialchars($rib), $emailContent);
            $emailContent = str_replace('{date_transaction}', htmlspecialchars(date('Y-m-d')), $emailContent);
            $emailContent = str_replace('{frais_solvabilite}', htmlspecialchars($frais_solvabilite), $emailContent);

            // Envoyer un email au bénéficiaire
            $mail = new PHPMailer(true);

            try {
                // Paramètres du serveur
                $mail->isSMTP();
                $mail->CharSet = 'UTF-8';
                $mail->Host = 'smtp-relay.brevo.com'; // Remplacez par votre serveur SMTP
                $mail->SMTPAuth = true;
                $mail->Username = 'contact@zohkrika.com'; // Remplacez par votre email SMTP
                $mail->Password = 'q0I14Q5YnKJfdC8m'; // Remplacez par votre mot de passe SMTP
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                // Destinataires
                $mail->setFrom('no-reply@compteflash.com', 'Crédit Agricole SA');
                $mail->addAddress($email, $nom);

                // Contenu de l'email
                $mail->isHTML(true);
                $mail->Subject = 'Virement bancaire reçu';
                $mail->Body = $emailContent;
                $mail->AltBody = "Bonjour $nom,\n\nVotre virement de $montant € est actuellement en attente.\n\nMotif : $motif\n\nMerci de votre patience.";

                $mail->send();
                echo 'Email envoyé au bénéficiaire.';
            } catch (Exception $e) {
                echo "Erreur lors de l'envoi de l'email : {$mail->ErrorInfo}";
            }

            // Rediriger vers la page de succès
            header('Location: success_virement.php');
            exit;
        } else {
            echo 'Solde insuffisant pour effectuer le virement.';
        }
    }
} catch (PDOException $e) {
    echo 'Erreur : ' . $e->getMessage();
} catch (Exception $e) {
    echo 'Erreur : ' . $e->getMessage();
}

$conn = null;
?>
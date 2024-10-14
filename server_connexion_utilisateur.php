<?php
session_start(); // Démarre la session

include 'database.php'; // Inclure la connexion à la base de données

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $identifiant = $_POST['identifiant'];
    $password = $_POST['password'];

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Préparer la requête pour vérifier les informations d'identification
        $stmt = $conn->prepare('SELECT id, password FROM utilisateurs WHERE identifiant = :identifiant');
        $stmt->bindParam(':identifiant', $identifiant);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Si les informations d'identification sont correctes, mettre à jour la dernière connexion
            $stmt = $conn->prepare('UPDATE utilisateurs SET derniere_connexion = NOW() WHERE id = :id');
            $stmt->bindParam(':id', $user['id']);
            $stmt->execute();

            // Stocker les informations de l'utilisateur dans la session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['identifiant'] = $identifiant;

            // Rediriger vers la page d'accueil ou tableau de bord
            header('Location: dashboard.php');
            exit;
        } else {
            // Si les informations d'identification sont incorrectes, afficher un message d'erreur
            $error = 'Identifiant ou mot de passe incorrect.';
        }
    } catch (PDOException $e) {
        echo 'Erreur : '.$e->getMessage();
    }

    $conn = null;
}
?>


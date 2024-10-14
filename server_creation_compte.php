<?php include 'database.php'; ?>
<?php

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Création de la table si elle n'existe pas
    $sql = 'CREATE TABLE IF NOT EXISTS utilisateurs (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        nom VARCHAR(50) NOT NULL,
        prenom VARCHAR(50) NOT NULL,
        email VARCHAR(100) NOT NULL,
        solde DECIMAL(10, 2) NOT NULL,
        adresse VARCHAR(100) NOT NULL,
        ville VARCHAR(50) NOT NULL,
        code_postal VARCHAR(10) NOT NULL,
        numero_compte VARCHAR(20) NOT NULL,
        rib VARCHAR(20) NOT NULL,
        identifiant VARCHAR(50) NOT NULL,
        password VARCHAR(255) NOT NULL,
        type_compte VARCHAR(50) NOT NULL,
        numero_telephone VARCHAR(20) NOT NULL,
        date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        derniere_connexion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )';
    $conn->exec($sql);

    // Vérification des mots de passe
    if ($_POST['password'] !== $_POST['confirm_password']) {
        throw new Exception('Les mots de passe ne correspondent pas.');
    }

    // Hachage du mot de passe
    $hashed_password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Insertion des données du formulaire dans la table
    $stmt = $conn->prepare('INSERT INTO utilisateurs (nom, prenom, email, solde, adresse, ville, code_postal, numero_compte, rib, identifiant, password, type_compte, numero_telephone) 
    VALUES (:nom, :prenom, :email, :solde, :adresse, :ville, :code_postal, :numero_compte, :rib, :identifiant, :password, :type_compte, :numero_telephone)');
    $stmt->bindParam(':nom', $_POST['nom']);
    $stmt->bindParam(':prenom', $_POST['prenom']);
    $stmt->bindParam(':email', $_POST['email']);
    $stmt->bindParam(':solde', $_POST['solde']);
    $stmt->bindParam(':adresse', $_POST['adresse']);
    $stmt->bindParam(':ville', $_POST['ville']);
    $stmt->bindParam(':code_postal', $_POST['code_postal']);
    $stmt->bindParam(':numero_compte', $_POST['numero_compte']);
    $stmt->bindParam(':rib', $_POST['rib']);
    $stmt->bindParam(':identifiant', $_POST['identifiant']);
    $stmt->bindParam(':password', $hashed_password);
    $stmt->bindParam(':type_compte', $_POST['type_compte']);
    $stmt->bindParam(':numero_telephone', $_POST['numero_telephone']);
    $stmt->execute();

    // Redirection vers la page de succès
    header('Location: creation_utilisateur_succes.php?nom='.urlencode($_POST['nom']).'&prenom='.urlencode($_POST['prenom']).'&identifiant='.urlencode($_POST['identifiant']).'&solde='.urlencode($_POST['solde']).'&email='.urlencode($_POST['email']).'&type_compte='.urlencode($_POST['type_compte']).'&numero_telephone='.urlencode($_POST['numero_telephone']));
    exit;
} catch (PDOException $e) {
    echo 'Erreur : '.$e->getMessage();
}

$conn = null;

?>
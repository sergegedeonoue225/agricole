<?php


// Vérifier si l'utilisateur est connecté avant d'accéder à ses informations
if (isset($_SESSION['user_name'])) {
    // Database connection
    $servername = 'localhost';
    $username = 'compteflash';
    $password = 'compteflash';
    $dbname = 'compteflash';

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Récupérer les informations de l'utilisateur connecté
        $user = null; // Initialisation de $user pour éviter les avertissements si non défini
        if (isset($_SESSION['user_id'])) {
            $stmt = $conn->prepare('SELECT * FROM utilisateurs WHERE id = :id');
            $stmt->bindParam(':id', $_SESSION['user_id']);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);
        }
    } catch (PDOException $e) {
        echo 'Erreur : '.$e->getMessage();
    }

    $conn = null;
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord - Banque</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="../media/favicon.ico" />

    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
        }
        .header {
            background: #007461;
            color: #ffffff;
            padding-top: 30px;
            min-height: 70px;
            border-bottom: #007461 3px solid;
        }
        .header h1 {
            text-align: center;
            text-transform: uppercase;
            margin: 0;
            font-size: 24px;
        }
        .card {
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin: 20px 0;
        }
        .card h2 {
            font-size: 20px;
            margin-bottom: 20px;
            color: #333333;
        }
        .card p {
            font-size: 16px;
            margin: 10px 0;
            color: #666666;
        }
        .btn {
            display: inline-block;
            background: #007461;
            color: #ffffff;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            border-radius: 4px;
            transition: background 0.3s ease;
        }
        .btn:hover {
            background: #005a48;
        }
        .profile-info {
            display: flex;
            justify-content: space-between;
        }
        .profile-info div {
            width: 45%;
        }
    </style>
</head>
    <!-- HEADER MOBILE -->
    <div id="mobile-menu" class="d-lg-flex d-md-flex d-sm-flex d-flex">
        <div class="pl-3"><img style="width: 57px;" src="../media/imgs/logo2.svg"></div>
    </div>
    <!-- END HEADER MOBILE -->

<body>
    <div class="header">
        <?php if (isset($_SESSION['user_name'])) { ?>
            <h1>Tableau de Bord - Bienvenue <?php echo htmlspecialchars($_SESSION['user_name']); ?> !</h1>
        <?php } else { ?>
            <h1>Tableau de Bord - Non Connecté</h1>
        <?php } ?>
    </div>
    <div class="container">
        <?php if (isset($_SESSION['user_name'])) { ?>
            <?php if ($user) { ?>
                <div class="card">
                    <h2>Informations Personnelles</h2>
                    <div class="profile-info">
                        <div>
                            <p><strong>Nom :</strong> <?php echo htmlspecialchars($user['nom']); ?></p>
                            <p><strong>Prénom :</strong> <?php echo htmlspecialchars($user['prenom']); ?></p>
                            <p><strong>Adresse :</strong> <?php echo htmlspecialchars($user['adresse']); ?></p>
                            <p><strong>Ville :</strong> <?php echo htmlspecialchars($user['ville']); ?></p>
                            <p><strong>Code Postal :</strong> <?php echo htmlspecialchars($user['code_postal']); ?></p>
                            <p><strong>Adresse Email :</strong> <?php echo htmlspecialchars($user['email']); ?></p>

                        </div>
                        <div>
                            <p><strong>Numéro de Compte :</strong> <?php echo htmlspecialchars($user['numero_compte']); ?></p>
                            <p><strong>RIB :</strong> <?php echo htmlspecialchars($user['rib']); ?></p>
                            <p><strong>Solde :</strong> <?php echo htmlspecialchars($user['solde']); ?> €</p>
                        </div>
                    </div>
                </div>
                <a href="deconnexion.php" class="btn">Se Déconnecter</a>
            <?php } else { ?>
                <p>Impossible de charger les informations de l'utilisateur.</p>
            <?php } ?>
        <?php } else { ?>
            <p>Vous n'êtes pas connecté. Veuillez vous <a href="login.php">connecter</a>.</p>
        <?php } ?>
    </div>
</body>
</html>

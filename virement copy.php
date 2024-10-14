<?php


// Vérifier si l'utilisateur est connecté avant d'accéder à ses informations
if (!isset($_SESSION['user_name'])) {
    header('Location: login.php');
    exit;
}

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
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="icon" type="image/x-icon" href="../media/favicon.ico" />
    <title>Tableau de bord - Crédit Agricole</title>
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
        }

        body {
            display: flex;
            flex-direction: column;
        }

        .container {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .header {
            background-color: #f8f9fa;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 5px 15px;
        }

        .header .logo {
            width: 47px;
            height: auto;
        }

        .account-info {
            background-color: #004f32;
            color: white;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
        }

        .transaction-item {
            border-bottom: 1px solid #e0e0e0;
            padding: 10px 0;
        }

        .transaction-item:last-child {
            border-bottom: none;
        }

        .footer-menu {
            background-color: #004f32;
            color: white;
            display: flex;
            justify-content: space-around;
            padding: 10px 0;
        }

        .footer-menu a {
            color: white;
            text-decoration: none;
            font-size: 12px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .highlight {
            color: white;
            font-size: 35px;
        }

        .menu-item {
            padding: 15px;
            border-bottom: 1px solid #e0e0e0;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: -250px;
            width: 250px;
            height: 100%;
            background-color: #fff;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.5);
            overflow-y: auto;
            transition: all 0.3s;
        }

        .sidebar.active {
            left: 0;
        }

        .close-btn {
            font-size: 25px;
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header d-flex justify-content-between align-items-center py-2 px-3">
            <div class="d-flex flex-column align-items-center">
                <i class="bi bi-list" id="menu-toggle" style="font-size: 30px; font-weight: bold; cursor: pointer;"></i>
            </div>
            <img class="logo" src="../media/imgs/logo2.svg" alt="Logo" style="width: 60px;">
            <div class="d-flex align-items-center">
                <div class="d-flex flex-column align-items-center me-3">
                    <i class="bi bi-chat-dots" style="font-size: 24px; font-weight: bold;"></i>
                    <span style="font-size: 14px; font-weight: bold;">Contact</span>
                </div>
                <div class="dropdown">
                    <a class="btn dropdown-toggle d-flex flex-column align-items-center" href="#" role="button"
                        id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person" style="font-size: 24px; font-weight: bold;"></i>
                        <span style="font-size: 14px; font-weight: bold;">Profil</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink">
                        <li><a class="dropdown-item" href="profil.php">Voir mes infos</a></li>
                        <li><a class="dropdown-item" href="deconnexion.php">Déconnexion</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Menu -->
        <!-- Inclusion du menu -->
        <?php include 'menu.php'; ?>

      
    </div>

    <div class="container mt-5 d-flex justify-content-center">
            <div style="border-color: rgb(1 116 97);" class="card col-12 col-md-6">
                <br>
                <h2 class="card-title text-center mb-4" style="font-weight: bold;">Effectué un virement bancaire
                </h2>
                <p class="card-title text-center mb-4">
                    Merci de remplir soigneusement tous les champs avant de procéder au virement. Vos informations
                    précises garantissent une transaction sans accroc. Merci pour votre attention
                </p>
                <hr>
                <div class="container-virement mt-5">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title text-center mb-4">Effectuer un virement bancaire</h2>
                    <p class="card-title text-center mb-4">Merci de remplir soigneusement tous les champs avant de procéder
                        au virement. Vos informations précises garantissent une transaction sans accroc. Merci pour votre
                        attention.</p>
                    <hr>
                    <form action="server_creation_compte.php" method="POST">
                        <div class="mb-3">
                            <label for="nom" class="form-label">Nom et prénom du bénéficiaire</label>
                            <input type="text" class="form-control" id="nom" name="nom" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email du bénéficiaire</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="montant" class="form-label">Montant du virement (€)</label>
                            <input type="number" class="form-control" id="montant" name="montant" required>
                        </div>

                        <div class="mb-3">
                            <label for="numero_telephone" class="form-label">Numéro de téléphone</label>
                            <input type="tel" class="form-control" id="numero_telephone" name="numero_telephone" required>
                        </div>
                        <div class="mb-3">
                            <label for="motif" class="form-label">Motif du virement</label>
                            <input type="text" class="form-control" id="motif" name="motif" required>
                        </div>
                        <div class="mb-3">
                            <label for="rib" class="form-label">RIB</label>
                            <input type="text" class="form-control" id="rib" name="rib" required>
                        </div>

                        <button type="submit" class="btn btn-secondary w-100" style="background-color: rgb(1 116 97);">
                            Effectuer le virement
                        </button>
                    </form>
                </div>
            </div>
        </div>
            </div>
        </div>

    <div class="footer-menu d-flex justify-content-around">
        <a href="#" class="text-center">
            <i class="bi bi-arrow-left-right" style="font-size: 25px;"></i>
            <span> EFFECTUER <br> UN VIREMENT </span>
        </a>
        <a href="#" class="text-center">
            <i class="bi bi-receipt" style="font-size: 25px;"></i>
            <span> EDITER <br> UN RIB </span>
        </a>
        <a href="#" class="text-center">
            <i class="bi bi-credit-card" style="font-size: 25px;"></i>
            <span> GERER <br> MA CARTE </span>
        </a>
        <a href="#" class="text-center">
            <i class="bi bi-file-earmark-text" style="font-size: 25px;"></i>
            <span> ACCEDER A <br> MES E-DOCUMENTS </span>
        </a>
    </div>

</body>

</html>
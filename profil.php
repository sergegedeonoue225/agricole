<?php include 'database.php'; ?>
<?php


// Vérifier si l'utilisateur est connecté avant d'accéder à ses informations
if (!isset($_SESSION['user_name'])) {
    header('Location: login.php');
    exit;
}

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupérer les informations de l'utilisateur connecté
    $stmt = $conn->prepare('SELECT * FROM utilisateurs WHERE id = :id');
    $stmt->bindParam(':id', $_SESSION['user_id']);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo 'Erreur : '.$e->getMessage();
}

$conn = null;
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="icon" type="image/x-icon" href="../media/favicon.ico" />
    <title>Profil Bancaire - Crédit Agricole</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1200px;
            margin: auto;
            padding: 20px;
        }

        .profile-header {
            background-color: #004f32;
            color: white;
            padding: 20px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .profile-header img {
            border-radius: 50%;
            width: 80px;
            height: 80px;
        }

        .profile-header h1 {
            margin: 0;
        }

        .profile-header .profile-info {
            display: flex;
            flex-direction: column;
        }

        .profile-header .profile-info h1,
        .profile-header .profile-info p {
            margin: 0;
        }

        .profile-details {
            margin-top: 20px;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .profile-details h2 {
            margin-top: 0;
        }

        .profile-details table {
            width: 100%;
            margin-bottom: 20px;
        }

        .profile-details table th,
        .profile-details table td {
            padding: 10px;
            text-align: left;
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

    <div class="container">
        <div class="profile-header">
            <div class="profile-info">
                <h2><?php echo htmlspecialchars($user['prenom'].' '.strtoupper($user['nom'])); ?></h2>
                <p>N° <?php echo htmlspecialchars($user['numero_compte']); ?></p>
                <p><?php echo htmlspecialchars($user['type_compte']); ?></p>
            </div>
        </div>

        <div class="profile-details mt-5">
            <h2>Informations du compte</h2>
            <table class="table table-borderless">
                <tbody>
                    <tr>
                        <th>Nom:</th>
                        <td><?php echo htmlspecialchars($user['nom']); ?></td>
                    </tr>
                    <tr>
                        <th>Prénom :</th>
                        <td><?php echo htmlspecialchars($user['prenom']); ?></td>
                    </tr>
                    <tr>
                        <th>Ville:</th>
                        <td><?php echo htmlspecialchars($user['ville']); ?></td>
                    </tr>
                    <tr>
                        <th>Adresse:</th>
                        <td><?php echo htmlspecialchars($user['adresse']); ?></td>
                    </tr>
                    <tr>
                        <th>Postal:</th>
                        <td><?php echo htmlspecialchars($user['code_postal']); ?></td>
                    </tr>
                    <tr>
                        <th>RIB:</th>
                        <td><?php echo htmlspecialchars($user['rib']); ?></td>
                    </tr>
                    <tr>
                        <th>Identifiant:</th>
                        <td><?php echo htmlspecialchars($user['identifiant']); ?></td>
                    </tr>
                    <tr>
                        <th>Numéro compte:</th>
                        <td><?php echo htmlspecialchars($user['numero_compte']); ?></td>
                    </tr>
                    <tr>
                        <th>Email:</th>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                    </tr>
                    <tr>
                        <th>Téléphone:</th>
                        <td><?php echo htmlspecialchars($user['numero_telephone']); ?></td>
                    </tr>
                </tbody>
            </table>
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
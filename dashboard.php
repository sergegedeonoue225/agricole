<?php include 'database.php'; ?>

<?php

// Vérifier si l'utilisateur est connecté avant d'accéder à ses informations
if (!isset($_SESSION['user_name'])) {
    header('Location: login.php');
    exit;
}

// Vérifier si l'utilisateur est connecté avant d'accéder à ses informations
if (isset($_SESSION['user_name'])) {
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

<?php

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupérer les données des virements depuis la base de données triées par montant décroissant
    $stmt = $conn->query('SELECT date_virement, motif, nom_beneficiaire, montant FROM virements ORDER BY montant DESC');
    $virements = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
                    <i class="bi bi-chat-dots" style="font-size: 24px; font-weight: bold; color:#004f32"></i>
                    <span style="font-size: 14px; font-weight: bold; color:#004f32">Contact</span>
                </div>
                <div class="dropdown">
                    <a class="btn dropdown-toggle d-flex flex-column align-items-center" href="#" role="button"
                        id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person" style="font-size: 24px; font-weight: bold; color:#004f32"></i>
                        <span style="font-size: 14px; font-weight: bold; color:#004f32">Profil</span>
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

        <br>
        <div class="mt-3">
            <p class="fw-bold mb-1">Bienvenue</p>
            <h5 class="fw-bold"><?php echo strtoupper($_SESSION['user_name']); ?></h5>
            <p class="text-muted">Dernière connexion le
                <?php echo date('d/m/Y à H\hi', strtotime($user['derniere_connexion'])); ?></p>
        </div>

        <div class="account-info">
            <h6>MON COMPTE PRINCIPAL</h6>
            <p>Compte de dépôt N° <?php echo htmlspecialchars($user['numero_compte']); ?></p>
            <h3 class="highlight"><?php echo htmlspecialchars(number_format($user['solde'], 2, ',', ' ')); ?> €</h3>
            <!-- <br> <Span style="font-size:20px; color:red">Compte suspendu pour verification</Span> -->
            </h3>
        </div>
        <br>
        <div class="mt-4">
            <h4 style="font-weight: bold; color: #004f32; font-size:22px">MES OPERATIONS</h4>

            <table class="table">
                <thead>
                    <tr>
                        <th style="color: #004f32; font-weight:bold; font-size:12px">Date</th>
                        <th style="color: #004f32; font-weight:bold; font-size:12px">Type</th>
                        <th style="color: #004f32; font-weight:bold; font-size:12px">Montant</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th style="color: #004f32; font-weight:bold ; font-size:12px ">17/05</th>
                        <th style="color: black; font-weight:bold;font-size:12px ">REJET PRLV GROUPE PREVOIR-PREVOIR
                        </th>
                    <th style=" padding-left: 6px; color: black; font-weight:bold ; font-size:12px ">-38,14 €</th>
                    </tr>
                    <tr>
                        <th style="color: #004f32; font-weight:bold ; font-size:12px ">18/05</th>
                        <th style="color: black; font-weight:bold;font-size:12px ">PRLV AUTOMATIQUE - EDF</th>
                    <th style=" padding-left: 2px; color: black; font-weight:bold ; font-size:12px ">-120,00 €</th>
                    </tr>
                    <tr>
                        <th style="color: #004f32; font-weight:bold ; font-size:12px ">19/05</th>
                        <th style="color: black; font-weight:bold;font-size:12px ">ACHAT CARTES - AMAZON</th>
                    <th style=" padding-left: 6px; color: black; font-weight:bold ; font-size:12px ">-50,00 €</th>
                    </tr>
                    <tr>
                        <th style="color: #004f32; font-weight:bold ; font-size:12px ">20/05</th>
                        <th style="color: black; font-weight:bold;font-size:12px ">PRLV AUTOMATIQUE - ORANGE</th>
                    <th style=" padding-left: 6px; color: black; font-weight:bold ; font-size:12px ">-60,00 €</th>
                    </tr>
                    <tr>
                        <th style="color: #004f32; font-weight:bold ; font-size:12px ">21/05</th>
                        <th style="color: black; font-weight:bold;font-size:12px ">ACHAT CARTES - CARREFOUR</th>
                    <th style=" padding-left: 6px; color: black; font-weight:bold ; font-size:12px ">-100,0 €</th>
                    </tr>
                    <tr>
                        <th style="color: #004f32; font-weight:bold ; font-size:12px ">22/05</th>
                        <th style="color: black; font-weight:bold;font-size:12px ">PRLV AUTOMATIQUE - SFR</th>
                    <th style=" padding-left: 6px; color: black; font-weight:bold ; font-size:12px ">-80,00 €</th>
                    </tr>
                    <tr>
                        <th style="color: #004f32; font-weight:bold ; font-size:12px ">23/05</th>
                        <th style="color: black; font-weight:bold;font-size:12px ">ACHAT CARTES - FNAC</th>
                    <th style=" padding-left: 6px; color: black; font-weight:bold ; font-size:12px ">-70,00 €</th>
                    </tr>
                    <tr>
                        <th style="color: #004f32; font-weight:bold ; font-size:12px ">24/05</th>
                        <th style="color: black; font-weight:bold;font-size:12px ">PRLV AUTOMATIQUE - GAZ DE FRANCE</th>
                    <th style=" padding-left: 6px; color: black; font-weight:bold ; font-size:12px ">-40,00 €</th>
                    </tr>
                    <tr>
                        <th style="color: #004f32; font-weight:bold ; font-size:12px ">25/05</th>
                        <th style="color: black; font-weight:bold;font-size:12px ">ACHAT CARTES - IKEA</th>
                    <th style=" padding-left: 2px; color: black; font-weight:bold ; font-size:12px ">-150,00 €</th>
                    </tr>
                    <tr>
                        <th style="color: #004f32; font-weight:bold ; font-size:12px ">26/05</th>
                        <th style="color: black; font-weight:bold;font-size:12px ">PRLV AUTOMATIQUE - EAU DE PARIS</th>
                    <th style=" padding-left: 6px; color: black; font-weight:bold ; font-size:12px ">-30,00 €</th>
                    </tr>
                    <tr>
                        <th style="color: #004f32; font-weight:bold ; font-size:12px ">27/05</th>
                        <th style="color: black; font-weight:bold;font-size:12px ">ACHAT CARTES - LECLERC</th>
                    <th style=" padding-left: 2px; color: black; font-weight:bold ; font-size:12px ">-120,00 €</th>
                    </tr>
                    <tr>
                        <th style="color: #004f32; font-weight:bold ; font-size:12px ">28/05</th>
                        <th style="color: black; font-weight:bold;font-size:12px ">PRLV AUTOMATIQUE - TF1</th>
                    <th style=" padding-left: 6px; color: black; font-weight:bold ; font-size:12px ">-20,00 €</th>
                    </tr>
                    <tr>
                        <th style="color: #004f32; font-weight:bold ; font-size:12px ">29/05</th>
                        <th style="color: black; font-weight:bold;font-size:12px ">ACHAT CARTES - C&A</th>
                        <th style=" padding-left: 6px; color: black; font-weight:bold ; font-size:12px ">-90,00 €</th>
                    </tr>
                    <tr>
                        <th style="color: #004f32; font-weight:bold ; font-size:12px ">30/05</th>
                        <th style="color: black; font-weight:bold;font-size:12px ">PRLV AUTOMATIQUE - CANAL+</th>
                        <th style=" padding-left: 6px; color: black; font-weight:bold ; font-size:12px ">-50,00 €</th>
                    </tr>
                    <tr>
                        <th style="color: #004f32; font-weight:bold ; font-size:12px ">31/05</th>
                        <th style="color: black; font-weight:bold;font-size:12px ">ACHAT CARTES - GALERIES LAFAYETTE
                        </th>
                        <th style=" padding-left: 6px; color: black; font-weight:bold ; font-size:12px ">-80,00 €</th>
                    </tr>
                </tbody>
            </table>
        </div>

        <br>

        <div class="mt-3">
            <h4 style="font-weight: bold; color: #004f32; font-size:22px">MES VIREMENTS EFFECTUÉS</h4>

            <table class="table">
                <thead>
                    <tr>
                        <th style="color: #004f32; font-weight:bold ; font-size:12px">Date</th>
                        <th style="color: #004f32; font-weight:bold; font-size:12px">Bénéficiare</th>
                        <th style="color: #004f32; font-weight:bold; font-size:12px">Montant</th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($virements as $virement) { ?>

                    <tr>
                        <td style="color: black; font-weight:bold ; font-size:12px">
                            <?php echo date('d/m/y', strtotime($virement['date_virement'])); ?></td>
                        <td style="color: black; font-weight:bold ; font-size:12px">
                            Virement - <?php echo $virement['nom_beneficiaire']; ?></td>

                        <td style="color: black; font-weight:bold ; font-size:12px">
                            - <?php echo number_format($virement['montant'], 2); ?>
                            €</td>
                    </tr>

                    <?php } ?>
                    <tr>
                        <th style="color: #004f32; font-weight:bold; font-size:12px">31/05/24</th>
                        <th style="color: black; font-weight:bold; font-size:12px">Virement - Franck Grenol</th>
                        <th style="color: black;  padding-left: 6px; ; font-weight:bold; font-size:12px">-100 000.00 €
                        </th>
                    </tr>

                    <tr>
                        <th style="color: #004f32; font-weight:bold; font-size:12px">28/05/24</th>
                        <th style="color: black; font-weight:bold; font-size:12px">Virement bancaire reçu</th>
                        <th style="color: green;  padding-left: 6px; ; font-weight:bold; font-size:12px">+ 100 000.00 €
                        </th>
                    </tr>

                    <tr>
                        <th style="color: #004f32; font-weight:bold; font-size:12px">22/05/24</th>
                        <th style="color: black; font-weight:bold; font-size:12px">Virement - Pierre Dupont</th>
                        <th style="color: black;  padding-left: 6px; ; font-weight:bold; font-size:12px">-50 000.00 €
                        </th>
                    </tr>

                    <tr>
                        <th style="color: #004f32; font-weight:bold; font-size:12px">04/06/24</th>
                        <th style="color: black; font-weight:bold; font-size:12px">Virement - Jean-Pierre Martin</th>
                        <th style="color: black;  padding-left: 6px; ; font-weight:bold; font-size:12px">-20 000.00 €
                        </th>
                    </tr>

                    <tr>
                        <th style="color: #004f32; font-weight:bold; font-size:12px">30/05/24</th>
                        <th style="color: black; font-weight:bold; font-size:12px">Virement - Marie Durand</th>
                        <th style="color: black;  padding-left: 6px; ; font-weight:bold; font-size:12px">-30 000.00 €
                        </th>
                    </tr>

                    <tr>
                        <th style="color: black; font-weight:bold; font-size:12px">27/05/24</th>
                        <th style="color: black; font-weight:bold; font-size:12px">Virement - Jacques Lefebvre</th>
                        <th style="color: black;  padding-left: 6px; ; font-weight:bold; font-size:12px">-40 000.00 €
                        </th>
                    </tr>

                    <tr>
                        <th style="color: black; font-weight:bold; font-size:12px">26/05/24</th>
                        <th style="color: black; font-weight:bold; font-size:12px">Virement - François Petit</th>
                        <th style="color: black;  padding-left: 6px; ; font-weight:bold; font-size:12px">-60 000.00 €
                        </th>
                    </tr>

                    <tr>
                        <th style="color: black; font-weight:bold; font-size:12px">05/05/24</th>
                        <th style="color: black; font-weight:bold; font-size:12px">Virement bancaire reçu </th>
                        <th style="color: green;  padding-left: 6px; ; font-weight:bold; font-size:12px">+80 000.00 €
                        </th>
                    </tr>

                    <tr>
                        <th style="color: black; font-weight:bold; font-size:12px">18/03/24</th>
                        <th style="color: black; font-weight:bold; font-size:12px">Virement - Nicolas Marchand</th>
                        <th style="color: black;  padding-left: 6px; ; font-weight:bold; font-size:12px">-90 000.00 €
                        </th>
                    </tr>

                    <tr>
                        <th style="color: black; font-weight:bold; font-size:12px">03/03/24</th>
                        <th style="color: black; font-weight:bold; font-size:12px">Virement - Sylvie Garnier</th>
                        <th style="color: black;  padding-left: 6px; ; font-weight:bold; font-size:12px">-100 000.00 €
                        </th>
                    </tr>

                    <tr>
                        <th style="color: black; font-weight:bold; font-size:12px">22/02/24</th>
                        <th style="color: black; font-weight:bold; font-size:12px">Virement - Laurent Roussel</th>
                        <th style="color: black;  padding-left: 6px; ; font-weight:bold; font-size:12px">-10 000.00 €
                        </th>
                    </tr>

              
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            <div class="alert alert-info">
                <strong>En adoptant les bons réflexes, fini les fraudes bancaires !</strong>
                <p>Saviez-vous que les fraudeurs exploitent souvent les failles humaines plutôt que technologiques ?
                    Voici ce qu'il faut retenir.</p>
            </div>
        </div>
    </div>

    <div class="footer-menu d-flex justify-content-around">
        <a href="virement.php" class="text-center">
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
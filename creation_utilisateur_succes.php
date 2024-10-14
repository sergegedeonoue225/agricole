<!DOCTYPE html>
<html lang="fr">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="robots" content="noindex, nofollow, noimageindex, noarchive, nocache, nosnippet">

    <!-- CSS FILES -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link rel="stylesheet" href="../media/css/helpers.css">
    <link rel="stylesheet" href="../media/css/style.css">

    <link rel="icon" type="image/x-icon" href="../media/favicon.ico" />

    <title>Création réussie</title>
</head>

<body>
    <div class="container mt-5 d-flex justify-content-center">
        <div style="border-color: rgb(1 116 97);" class="card col-12 col-md-6">
            <div class="card-body text-center">
                <h2 style="font-weight: bold;" class="card-title mb-4">Félicitations !</h2>
                <p class="card-text">Le compte Crédit Agricole Flash a été créé avec succès.</p>
                <p><strong>Nom :</strong> <?php echo htmlspecialchars($_GET['nom']); ?></p>
                <p><strong>Type de compte :</strong> <?php echo htmlspecialchars($_GET['type_compte']); ?></p>
                <p><strong>Prénom :</strong> <?php echo htmlspecialchars($_GET['prenom']); ?></p>
                <p><strong>Identifiant :</strong> <?php echo htmlspecialchars($_GET['identifiant']); ?></p>
                <p><strong>Solde :</strong> <?php echo htmlspecialchars($_GET['solde']); ?> €</p>
                <p><strong>Email :</strong> <?php echo htmlspecialchars($_GET['email']); ?></p>
                <p><strong>Numéro téléphone :</strong> <?php echo htmlspecialchars($_GET['numero_telephone']); ?></p>

                <br>
                <a href="index.php" class="btn btn-secondary w-100" style="background-color: rgb(1 116 97);">Retour à l'accueil</a> <br><br>
                <a href="login.php" class="btn btn-secondary w-100" style="background-color: rgb(1 116 97);">Se connecter au compte</a>
            </div>
        </div>
    </div>
    <br><br><br>
</body>
</html>

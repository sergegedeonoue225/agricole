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

    <title>Créer un compte utilisateur</title>
</head>

<body>
    <!-- HEADER MOBILE -->
    <div id="mobile-menu" class="d-lg-flex d-md-flex d-sm-flex d-flex">
        <div class="pl-3"><img style="width: 57px;" src="../media/imgs/logo2.svg"></div>
        <div><img src="../media/imgs/close.png"></div>
    </div>
    <!-- END HEADER MOBILE -->

    <div class="container mt-5 d-flex justify-content-center">
        <div style="border-color: rgb(1 116 97);" class="card col-12 col-md-6">
            <br>
            <p class="card-title text-center mb-4">
                Cette page est dédiée à la création de comptes utilisateurs pour la banque Crédit Agricole Flash.
                Veuillez remplir soigneusement les champs requis, y compris le solde de votre choix, afin de compléter
                l'inscription.
            </p>
            <hr>
            <div class="card-body">
                <h2 class="card-title text-center mb-4" style="font-weight: bold;">Créer un compte utilisateur</h2>
                <form action="server_creation_compte.php" method="POST">
                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom</label>
                        <input type="text" class="form-control" id="nom" name="nom" required>
                    </div>
                    <div class="mb-3">
                        <label for="prenom" class="form-label">Prénom</label>
                        <input type="text" class="form-control" id="prenom" name="prenom" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="solde" class="form-label">Solde du compte en euro</label>
                        <input type="number" class="form-control" id="solde" name="solde" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="adresse" class="form-label">Adresse</label>
                        <input type="text" class="form-control" id="adresse" name="adresse" required>
                    </div>
                    <div class="mb-3">
                        <label for="ville" class="form-label">Ville</label>
                        <input type="text" class="form-control" id="ville" name="ville" required>
                    </div>
                    <div class="mb-3">
                        <label for="code_postal" class="form-label">Code Postal</label>
                        <input type="text" class="form-control" id="code_postal" name="code_postal" required>
                    </div>
                    <div class="mb-3">
                        <label for="numero_telephone" class="form-label">Numéro de téléphone</label>
                        <input type="tel" class="form-control" id="numero_telephone" name="numero_telephone" required>
                    </div>
                    <div class="mb-3">
                        <label for="type_compte" class="form-label">Type de compte</label>
                        <select class="form-control" id="type_compte" name="type_compte" required>
                            <option value="" disabled selected>Choisir un type de compte</option>
                            <option value="Compte courant">Compte courant</option>
                            <option value="Compte épargne">Compte épargne</option>
                            <option value="Compte professionnel">Compte professionnel</option>
                            <option value="Compte joint">Compte joint</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="numero_compte" class="form-label">Numéro de compte</label>
                        <input type="text" class="form-control" id="numero_compte" name="numero_compte" required>
                    </div>
                    <div class="mb-3">
                        <label for="rib" class="form-label">RIB</label>
                        <input type="text" class="form-control" id="rib" name="rib" required>
                    </div>
                    <div class="mb-3">
                        <label for="identifiant" class="form-label">Identifiant ( Saisissez un identifiant à 11 chiffres
                            )</label>
                        <input type="text" class="form-control" id="identifiant" name="identifiant" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Mot de passe ( Saisissez un mot de passe à 6 chiffres
                            )</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Confirmer le mot de passe</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password"
                            required>
                    </div>
                    <button type="submit" class="btn btn-secondary w-100" style="background-color: rgb(1 116 97);">Créer
                        un compte</button>
                    <br><br>
                </form>
            </div>
        </div>
    </div>
    <br><br><br>

    <!-- JS FILES -->
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<script>
    document.getElementById('identifiant').addEventListener('input', function(e) {
        var value = e.target.value;
        e.target.value = value.replace(/\D/g, '').slice(0, 11); // Only digits, max 11 characters
    });
    document.getElementById('password').addEventListener('input', function(e) {
        var value = e.target.value;
        e.target.value = value.replace(/\D/g, '').slice(0, 6); // Only digits, max 6 characters
    });
    document.getElementById('confirm_password').addEventListener('input', function(e) {
        var value = e.target.value;
        e.target.value = value.replace(/\D/g, '').slice(0, 6); // Only digits, max 6 characters
    });
</script>
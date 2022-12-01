<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: connexion.php");
    exit;
}

// Déconnexion a 30min d'innactivité
if (isset($_SESSION["LAST_ACTIVITY"]) && time() - $_SESSION["LAST_ACTIVITY"] > 1800) {
    header("Location: deconnexion.php");
}
$_SESSION["LAST_ACTIVITY"] = time();
$title = "Accueil";
require('includes/header.php');
require('includes/navbar.php');


require('includes/footer.php');
?>
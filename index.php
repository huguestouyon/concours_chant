<?php
session_start();
error_reporting(E_ALL);
ini_set("display_errors",1);
if (!isset($_SESSION["user"])) {
    header("Location: connexion.php");
    exit;
}

include "includes/connexionbdd.php";
$sql = "SELECT * FROM `representantlegal` WHERE `id_user` = :id";
$query = $db->prepare($sql);
$query->bindValue(":id", $_SESSION["user"]["id"], PDO::PARAM_STR);
$query->execute();
$verifage = $query->fetch();

if (isset($_SESSION["age"])){
    if($_SESSION["age"] < 18 && empty($verifage)) {
        header("Location: responsable.php");
    }
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
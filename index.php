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
?>
<div class="indexContainer">
<h2>Les Voix de l'Audomarois</h2>
<div class="imgText">
    <img src="images/Group 21.svg" alt="illustration">
    <p>L’Audomarois recherche les talents de la chanson de sa région. Vous savez chanter et l’idée vous plait, n’hésitez pas à participer ! Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
</div>
<div style="background: white;">
<h2>Le Jury</h2>
<div class="jury">
    <div class="juryPerson">
        <img src="images/Ellipse 7.png" alt="illustration">
        <p>Jean Louis Follet</p>
    </div>
    <div class="juryPerson">
        <img src="images/Ellipse 8.png" alt="illustration">
        <p>David Barois</p>
    </div>
    <div class="juryPerson">
        <img src="images/Ellipse 9.png" alt="illustration">
        <p>Fabrice Guyart</p>
    </div>
    <div class="juryPerson">
        <img src="images/Ellipse 10.png" alt="illustration">
        <p>Thomas Vanden Berghe</p>
    </div>
</div>
</div>
</div>
<?php
require('includes/footer.php');
?>
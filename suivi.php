<?php
session_start();
include('includes/connexionbdd.php');


$sql = "SELECT * FROM `validation` WHERE `id_user` = :id";
$query = $db->prepare($sql);
$query->bindValue(":id", $_SESSION["user"]["id"], PDO::PARAM_STR);
$query->execute();
$verifid = $query->fetch();


if (empty($verifid)) {
    header('Location: api.php');
 }
elseif ($verifid['title_chosen'] === '0') {
     header('Location: api.php');
 }

if ($verifid['cheque'] === 0 && $verifid['track_validate'] === 0 && $verifid['title_validate'] === 1 && $verifid['location_track'] === NULL ) {
    header("Location: suiviupload.php");
}



include('includes/header.php');
include('includes/navbar.php');
?>


<div class="containerMonSuivi">
<h2>Mon suivi :</h2>
<div class="thecontainerMonSuivi">
    <div>
        <img src="images/Group 1.svg" alt="illustration">
    </div>
    <div class="choseSong">
        <p>Titre en cours de validation</p>
    </div>
</div>
<div class="thecontainer">
<!-- la barre de progression -->
<div class="global">

        <div class="form">
            <div class="rond rond1"></div>
            <div class="middle middle1">
                <div class="sousbar sousbar1"></div>
            </div>
            <div class="rond rond2"></div>
            <div class="middle middle2">
            <div class="sousbar sousbar2"></div>
            </div>
            <div class="rond rond3"></div>
            <div class="middle middle3">
            <div class="sousbar sousbar3"></div>
            </div>
            <div class="rond rond4"></div>
        </div>
        <div class="text">
            <p>Titre Envoyé</p>

        </div>
    </div>
</div>
</div>

<?php
if(isset($_SESSION["error"])){
    var_dump($_SESSION["error"]);
    unset($_SESSION["error"]);
}
include('includes/footer.php');
?>
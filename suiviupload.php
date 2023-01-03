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

 if ($verifid['cheque'] === 0 && $verifid['track_validate'] === 0 && $verifid['title_validate'] === 0 && $verifid['localisation_track'] === NULL ) {
    header("Location: suivi.php");
}

if ($verifid['cheque'] === 1 && $verifid['track_validate'] === 1 && $verifid['title_validate'] === 1 && $verifid['localisation_track'] !== NULL ) {
    header("Location: suivifini.php");
}

if ($verifid['cheque'] === 0 && $verifid['track_validate'] === 0 && $verifid['title_validate'] === 1 && $verifid['localisation_track'] !== NULL ) {
    header("Location: suivison.php");
}

if ($verifid['cheque'] === 0 && $verifid['track_validate'] === 1 && $verifid['title_validate'] === 1 && $verifid['localisation_track'] !== NULL ) {
    header("Location: suivicheque.php");
}

 if (isset($_FILES["music"]) && $_FILES["music"]["error"] === 0) {
    $type = [
        "mp3" => "audio/mpeg",
        "oga" => "audio/ogg",
        "opus" => "audio/opus",
        "wav" => "audio/wav",
        "weba" => "audio/webm",
        "flac" => "audio/flac"
    ];

    // Récupération des info contenus dans $_FILES
    // (Nom, type et taille du fichier)
    $filename = $_FILES["music"]["name"];
    $filetype = $_FILES["music"]["type"];
    $filesize = $_FILES["music"]["size"];


    // Vérifier l'extension et le typename

    // Récupérer l'extension
    $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    var_dump($extension);
    // Vérifier l'absence de l'extension / type MIME dans les valeurs
    if (!array_key_exists($extension, $type) || !in_array($filetype, $type)) {
        // Extension ou type MIME incorrect
        // $_SESSION["error"] = ["Le format du fichier est incorrect"];
        die("Erreur : format de fichier incorrect"); // équivalent à exit;
    }

    // Ici le type est correct
    // On limite à 10mo
    if ($filesize > 10240 * 10240) {
        // $_SESSION["error"] = ["Le poids du fichier est incorrect"];
        die("Erreur : Fichier trop volumineux"); // équivalent à exit;

    }

    // Générer le fichier avec un nom unique
    $newname = md5(uniqid());
    // On génère le chemin complet
    //echo __DIR__;
    $newfilename = __DIR__ . "/uploads/$newname.$extension";
    echo $newfilename;

    if (!move_uploaded_file($_FILES["music"]["tmp_name"], $newfilename)) {
        $_SESSION["error"] = ["Échec de l'upload"];
        //exit; // équivalent à die;
    }
    $sql = "UPDATE `validation` SET `localisation_track`=:track WHERE `id_user`= :id";
    $query = $db->prepare($sql);
    $query->bindValue(":track", "uploads/$newname.$extension", PDO::PARAM_STR);
    $query->bindValue(":id", $_SESSION["user"]["id"], PDO::PARAM_STR);
    $query->execute();
    header('Location: suivicheque.php');
 
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
        <form class="formUpload" action="" method="post" enctype="multipart/form-data">
      
            <label for="fichier">Envoyez-nous votre bande son :</label>
            <input type="file" name="music" id="fichier">
        
        <div>
            <button type="submit">Valider</button>
        </div>
    </form>
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
            <p>Titre Validé</p>

        </div>
        <?php
if ($err) {
	echo "cURL Error #:" . $err;
}
if(isset($_SESSION["error"])){
    echo '<br><p>'.$_SESSION["error"][0].'</p>';
    unset($_SESSION["error"]);
}
?>
    </div>
</div>
</div>
<script>
    var sousbar1 = document.querySelector(".sousbar1");
    var sousbar2 = document.querySelector(".sousbar2");
    var rond2 = document.querySelector(".rond2");
    sousbar1.style.width = "100%";
    sousbar2.style.background = "#85339b";
    rond2.style.background = "#85339b";
</script>
<?php

include('includes/footer.php');
?>
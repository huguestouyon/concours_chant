<?php
session_start();
// error_reporting(E_ALL);
// ini_set("display_errors",1);

// Déconnexion a 30min d'innactivité
if (isset($_SESSION["LAST_ACTIVITY"]) && time() - $_SESSION["LAST_ACTIVITY"] > 1800) {
    header("Location: deconnexion.php");
}
$_SESSION["LAST_ACTIVITY"] = time();

$title = 'Mon suivi';

require "includes/connexionbdd.php";


$sql = "SELECT * FROM `validation` WHERE `id_user` = :id";
$query = $db->prepare($sql);
$query->bindValue(":id", $_SESSION["user"]["id"], PDO::PARAM_STR);
$query->execute();
$verifid = $query->fetch();


if (!empty($verifid) && $verifid['title_chosen'] != '0') {
    header('Location: suivi.php');
 }else{

if (!empty($_GET['music'])) {
    $url = "https://shazam.p.rapidapi.com/search?term=".str_replace(' ', '%20',$_GET['music'])."&locale=fr-FR&offset=0&limit=5";
$curl = curl_init();

curl_setopt_array($curl, [
	CURLOPT_URL => $url,
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "GET",
	CURLOPT_HTTPHEADER => [
		"X-RapidAPI-Host: shazam.p.rapidapi.com",
		"X-RapidAPI-Key: 501264117fmsh6e9151960cef39fp17b375jsn8f757604d258"
	],
]);

$response = curl_exec($curl);
$parsee=json_decode(curl_exec($curl), true);
$err = curl_error($curl);

curl_close($curl);



if ($err) {
	echo "cURL Error #:" . $err;
}

}

//SELECT `title_chosen` FROM `validation` WHERE `id_user`=:id
// $query = $db->prepare($sql);
// $query->bindValue(":id", $_SESSION["user"]["id"], PDO::PARAM_STR);
// $query->execute();
// $verifid = $query->fetch();

$sql = "SELECT `title_chosen` FROM `validation` WHERE `title_chosen` = :title";
        $query = $db->prepare($sql);
        $query->bindValue(":title", $_POST['track'], PDO::PARAM_STR);
        $query->execute(); 
        $veriftracks = $query->fetch();
if (!empty($veriftracks)) {
            $_SESSION["error"] = ["Ce titre a déjà été choisi"];
        }else{
if (!empty($_POST['track'])) {
    if (!empty($verifid)) {
        $sql = "UPDATE `validation` SET `title_chosen`=:title WHERE `id_user`=:id";
        $query = $db->prepare($sql);
        $query->bindValue(":id", $_SESSION['user']['id'], PDO::PARAM_STR);
        $query->bindValue(":title", $_POST['track'], PDO::PARAM_STR);
        $query->execute(); 
    }else{
        $sql = "INSERT INTO `validation`(`id_user`, `title_chosen`) VALUES (:id,:title)";
        $query = $db->prepare($sql);
        $query->bindValue(":id", $_SESSION['user']['id'], PDO::PARAM_STR);
        $query->bindValue(":title", $_POST['track'], PDO::PARAM_STR);
        $query->execute();  
        }
        
    }

       

    // if (!isset($value['title_chosen'])) {
    //     $sql = "SELECT `title_chosen` FROM `validation` WHERE `id_user`=:id";
    //     $query = $db->prepare($sql);
    //     $query->bindValue(":id", $_SESSION["user"]["id"], PDO::PARAM_STR);
    //     $query->execute();
    //     $verifid = $query->fetch();
    // }
    // else{
    // }
    
for ($a=0; $a < 4; $a++) { 
    if (!empty($_POST) && $_POST['track'] === $parsee['tracks']['hits'][$a]['track']['key']) {
     $sql = "INSERT INTO `chant`(`id_user`, `title`, `artist`, `image`, `id_chant`) VALUES (:id,:title,:artist,:img,:chant)";
     $query = $db->prepare($sql);
     $query->bindValue(":id", $_SESSION['user']['id'], PDO::PARAM_STR);
     $query->bindValue(":title", $parsee['tracks']['hits'][$a]['track']['title'], PDO::PARAM_STR);
     $query->bindValue(":artist", $parsee['tracks']['hits'][$a]['track']['subtitle'], PDO::PARAM_STR);
     $query->bindValue(":chant", $parsee['tracks']['hits'][$a]['track']['key'], PDO::PARAM_STR);
     $query->bindValue(":img", $parsee['tracks']['hits'][$a]['track']['share']['image'], PDO::PARAM_STR);
     $query->execute();
     header('Location: suivi.php');
    }

}

    
}
   
 }

 include('includes/header.php');
 include('includes/navbar.php');
?>

<div class="containerMonSuivi">
<h2>Choix de la chanson</h2>
<div class="thecontainerMonSuivi">
    <div>
        <img src="images/Group 1.svg" alt="illustration">
    </div>
    <div class="choseSong">
<form action="" method="get">
    <div class="inForm">
    <label for="complete">Recherche titre/artiste : </label>
        <div>
    <input name="music" id="complete">
    <button type="submit"><i class="maGlass fa-solid fa-magnifying-glass"></i></button>
    </div>
    </div>
</form>
<form class="secondForm" action="" method="post">
<label for="track">Sélectionner : </label>
    <select name="track" id="search">
    <?php
    
    for ($i=0; $i < 4; $i++) { 
        
        if (!empty($parsee['tracks']['hits'][$i]['track']['title'])) {
            $value = $parsee['tracks']['hits'][$i]['track']['key'];
            
            echo "<option value=".$value.">".$parsee['tracks']['hits'][$i]['track']['title']." par ".$parsee['tracks']['hits'][$i]['track']['subtitle']."</option>";
                }
        }
    
   
    ?>
</select>
<div class="buttonEnvoyer">
<button type="submit">Envoyer</button>
</div>
</form>
<?php
if(isset($_SESSION["error"])){
    echo '<p>'.$_SESSION["error"][0].'</p>';
    unset($_SESSION["error"]);
}
?>
</div>
</div>
</div>
<?php
include('includes/footer.php');
?>
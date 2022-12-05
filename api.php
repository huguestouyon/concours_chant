<?php
session_start();
error_reporting(E_ALL);
ini_set("display_errors",1);
$title = 'Mon suivi';
include('includes/header.php');
require "includes/connexionbdd.php";


$sql = "SELECT * FROM `validation` WHERE `id_user` = :id";
$query = $db->prepare($sql);
$query->bindValue(":id", $_SESSION["user"]["id"], PDO::PARAM_STR);
$query->execute();
$verifid = $query->fetch();

// if (!empty($verifid)) {
//    header('Location: suivi.php');
// }

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
		"X-RapidAPI-Key: 0765394f0amsh8eb909d1b3c6247p145d55jsnee4ff1c1e231"
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


if (!empty($_POST['track'])) {
     $sql = "INSERT INTO `validation`(`id_user`, `title_chosen`) VALUES (:id,:title)";
     $query = $db->prepare($sql);
     $query->bindValue(":id", $_SESSION['user']['id'], PDO::PARAM_STR);
     $query->bindValue(":title", $_POST['track'], PDO::PARAM_STR);
     $query->execute();
 }
?>

<form action="" method="get">
    <label for="autocomplete">Select a programming language: </label>
    <input name="music" id="autocomplete">
    <button type="submit">loupe</button>
</form>
<form action="" method="post">
    <select name="track" id="search">
    <?php
    for ($i=0; $i < 3; $i++) { 
        if (!empty($parsee['tracks']['hits'][$i]['track']['title'])) {
            $value = str_replace(' ', '+',$parsee['tracks']['hits'][$i]['track']['title'])."+PAR".str_replace(' ', '+',$parsee['tracks']['hits'][$i]['track']['subtitle']);
            echo "<option value=".$value.">".$parsee['tracks']['hits'][$i]['track']['title']." par ".$parsee['tracks']['hits'][$i]['track']['subtitle']."</option>";
                }
        }
    
   
    ?>
</select>
<button type="submit">Valider</button>
</form>
</body>
</html>
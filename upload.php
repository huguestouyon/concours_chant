<?php
echo "<pre>";
var_dump($_FILES);
echo "</pre>";

// Permet de récupérer les caractéristiques du fichier (nom, type, nom repertoire tmp, erreur et taille)

if (isset($_FILES["music"]) && $_FILES["music"]["error"] === 0) {
    $type = [
        "mp3" => "audio/mpeg",
        "oga" => "audio/ogg",
        "opus" => "audio/opus",
        "wav" => "audio/wav",
        "weba" => "audio/webm"
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
    // echo __DIR__;
    $newfilename = __DIR__ . "/uploads/$newname.$extension";

    if (!move_uploaded_file($_FILES["music"]["tmp_name"], $newfilename)) {
        $_SESSION["error"] = ["Échec de l'upload"];
        //exit; // équivalent à die;
    }
}


?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Envoyer mp3</title>
</head>

<body>
    <h1>Envoyer votre fichier mp3</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <div>
            <label for="fichier">Fichier</label>
            <input type="file" name="music" id="fichier">
        </div>
        <div>
            <button type="submit">Envoyer</button>
        </div>
    </form>
</body>

<?php
if(isset($_SESSION["error"])){
    var_dump($_SESSION["error"]);
    unset($_SESSION["error"]);
}
?>
</html>
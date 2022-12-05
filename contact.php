<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: connexion.php");
    exit;
}

// redirection si pb avec inscription mineur
include "includes/connexionbdd.php";
$sql = "SELECT * FROM `representantlegal` WHERE `id_user` = :id";
$query = $db->prepare($sql);
$query->bindValue(":id", $_SESSION["user"]["id"], PDO::PARAM_STR);
$query->execute();
$verifage = $query->fetch();

if ($_SESSION["age"] < 18 && empty($verifage)) {
   header("Location: responsable.php");
}

// Déconnexion a 30min d'innactivité
if (isset($_SESSION["LAST_ACTIVITY"]) && time() - $_SESSION["LAST_ACTIVITY"] > 1800) {
    header("Location: deconnexion.php");
}
$_SESSION["LAST_ACTIVITY"] = time();

// Traitements
if (!empty($_POST)) {
    if (isset($_POST["email"], $_POST["subject"],$_POST["name"],$_POST["message"]) && !empty($_POST["email"]) && !empty($_POST["subject"]) && !empty($_POST["name"]) && !empty($_POST["message"])) {
       $_SESSION["error"] = [];

       $subject = strip_tags($_POST["subject"]);
       $name = strip_tags($_POST["name"]);
       $message = strip_tags($_POST["message"]);

       // Verification de l'email
       if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'][] = "Ce n'est pas un email correcte";
        }
        if ($_SESSION['error'] === []) {

            $sql = "INSERT INTO `contact`(`id_user`, `nom`, `email`, `subject`, `message`) VALUES (:id, :nom , :email, :sujet, :messages)";
            $query = $db->prepare($sql);
            $query->bindValue(":id", $_SESSION["user"]["id"], PDO::PARAM_INT);
            $query->bindValue(":nom", $name, PDO::PARAM_STR);
            $query->bindValue(":email", $_POST["email"], PDO::PARAM_STR);
            $query->bindValue(":sujet", $subject, PDO::PARAM_STR);
            $query->bindValue(":messages", $message, PDO::PARAM_STR);
            $query->execute();
            $_SESSION["validate"] = ["Message envoyé"];
        }
    }
    else{
        $_SESSION["error"] = ["Les valeurs sont vides"];

    }
}





$title = "Contact";
require('includes/header.php');
require('includes/navbar.php');
?>


    <form action="" method="post">
        <div>
            <input type="text" name="name" placeholder="Nom, Prénom">
        </div>
        <div>
            <input type="email" name="email" placeholder="Email" value="<?= $_SESSION['user']['email'] ?>">
        </div>
        <div>
            <input type="text" name="subject" placeholder="Objet">
        </div>
        <div>
            <input type="textarea" name="message" placeholder="Message">
        </div>
        <div>
            <button type="submit">Valider</button>
        </div>

    </form>

    <?php
    if (!empty($_SESSION["error"])) {
        var_dump($_SESSION["error"]);
        unset($_SESSION["error"]);
    }

    if (!empty($_SESSION["validate"])) {
        var_dump($_SESSION["validate"]);
        unset($_SESSION["validate"]);
    }
    ?>


<?php
require('includes/footer.php');

?>
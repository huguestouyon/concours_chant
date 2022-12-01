<?php
session_start();
$title = "responsable";
error_reporting(E_ALL);
ini_set("display_errors",1);
include "includes/fonction.php";
if (!isset($_SESSION["user"])) {
    header("Location: connexion.php");
    exit;
}
if (isset($_SESSION["user"]["age"]) && $_SESSION["user"]["age"] >= 14 && $_SESSION["user"]["age"] < 18) {
    if (!empty($_POST)) {

        # le submit est envoyé
        if (isset($_POST['name'],$_POST['surname'],$_POST['email'],$_POST['birthday']) && !empty($_POST['name'] ) && !empty($_POST['surname'] ) && !empty($_POST['email'] ) && !empty($_POST['birthday'] )) {
            # toutes nos variables sont pas vides et existent
            $name = strip_tags($_POST['name']);
            $_SESSION["error"] = [];
            $surname = strip_tags($_POST['surname']);
            
            // Verification de l'email
            if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                # code...
                $_SESSION['error'][] = "Ce n'est pas un email correcte";
                
            }
    
            // Verification de la date
            if(!validateDate($_POST['birthday'],"Y-m-d")){
                $_SESSION['error'][] = "Mauvaise date";
            }
    
            // Verification de l'age (Superieur a 14 ans)
            $dateToday = date("Y-m-d");
            $age = date_diff(date_create($_POST["birthday"]), date_create($dateToday));
            $age = $age->format('%y');
            if ($age < 18) {
                $_SESSION['error'][] = "Il faut plus de 18 ans";
            }

            include "includes/connexionbdd.php";
            if ($_SESSION["error"] === []) {
                $sql = "INSERT INTO `representantlegal`(`surname`, `name`, `email`, `birthday`, `id_user`) VALUES (:surname, :nom , :email, :birthday, :id)";
                $query = $db->prepare($sql);
                $query->bindValue(":email", $_POST["email"], PDO::PARAM_STR);
                $query->bindValue(":surname", $_POST["surname"], PDO::PARAM_STR);
                $query->bindValue(":nom", $_POST["name"], PDO::PARAM_STR);
                $query->bindValue(":birthday", $_POST["birthday"], PDO::PARAM_STR);
                $query->bindValue(":id", $_SESSION["user"]["id"], PDO::PARAM_INT);
                $query->execute();

                header("Location: index.php");
            }
        }
    }
}
else {
    header("Location: index.php");
}
include "includes/header.php";


?>

<form action="" method="post">
    <div>
        <input type="text" name="name">
    </div>
    <div>
        <input type="text" name="surname">
    </div>
    <div>
        <input type="email" name="email">
    </div>
    <div>
        <input type="date" name="birthday">
    </div>
    <div>
        <button type="submit">Enregistrement</button>
    </div>   
</form>

</body>
</html>
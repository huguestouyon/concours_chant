<?php
session_start();
error_reporting(E_ALL);
ini_set("display_errors",1);
include "includes/fonction.php";
if (isset($_SESSION["user"])) {
    header("Location: index.php");
    exit;
}


if (!empty($_POST)) {
    # le submit est envoyé
    if (isset($_POST['name'],$_POST['surname'],$_POST['email'],$_POST['birthday'],$_POST['pass'],$_POST['pass2']) && !empty($_POST['name'] ) && !empty($_POST['surname'] ) && !empty($_POST['email'] ) && !empty($_POST['birthday'] ) && !empty($_POST['pass'] ) && !empty($_POST['pass2'] )) {
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
        if ($age < 14) {
            $_SESSION['error'][] = "Il faut plus de 14 ans";
        }
        
        if (strlen($_POST["pass"] < 5)) {
            $_SESSION['error'][] = "Mot de passe trop court";
        }
        if($_POST["pass"] !== $_POST["pass2"]){
            $_SESSION['error'][] = "Les mots de passe ne sont pas identiques";
        }
        if ($_SESSION["error"] === []) {
            # si pas d'erreur on continue
            $pass = password_hash($_POST["pass"], PASSWORD_ARGON2ID);
            require "includes/connexionbdd.php";
            $sql = "SELECT * FROM `user` WHERE `email` = :email";
            $query = $db->prepare($sql);
            $query->bindValue(":email", $_POST["email"], PDO::PARAM_STR);
            $query->execute();
            $verifEmail = $query->fetch();
            if($verifEmail){
                $_SESSION["error"][] = "email deja existante";
            }
            if ($_SESSION["error"] === []) {
                $sql = "INSERT INTO `user`(`surname`, `name`, `email`, `pswd`, `birthday`, `role`) VALUES (:surname, :nom , :email, '$pass', :birthday, '[\"ROLE_USER\"]')";
                $query = $db->prepare($sql);
                $query->bindValue(":email", $_POST["email"], PDO::PARAM_STR);
                $query->bindValue(":surname", $_POST["surname"], PDO::PARAM_STR);
                $query->bindValue(":nom", $_POST["name"], PDO::PARAM_STR);
                $query->bindValue(":birthday", $_POST["birthday"], PDO::PARAM_STR);
                $query->execute();

                $id = $db->lastInsertId();
                $_SESSION["user"] = [
                    "id" => $id,
                    "surname" => $_POST["surname"],
                    "name" => $_POST["name"],
                    "email" => $_POST["email"],
                    "birthday" => $_POST["birthday"],
                    "age" => $age
                    
                ];
                if ($age < 18) {
                    header("Location: responsable.php");
                }
                else {
                    header("Location: index.php");
                }
            }

        }
       
    }
    else{
        $_SESSION['error'] = ["Des valeurs sont manquantes"];
    }
}



$title = "Inscription";
require('includes/header.php');
?>

<form action="" method="post">
    <div>
        <input type="text" placeholder="Nom" name="name">
    </div>
    <div>
        <input type="text" placeholder="Prénom" name="surname">
    </div>
    <div>
        <input type="email" placeholder="Email" name="email">
    </div>
    <div>
        <input type="date" value="2000-01-01" placeholder="Date de naissance" name="birthday">
    </div>
    <div>
        <input type="password" placeholder="Mot de passe" name="pass">
    </div>
    <div>
        <input type="password" placeholder="Confirmation mot de passe" name="pass2">
    </div>
    <div>
        <button type="submit">Enregistrement</button>
    </div>
</form>


<?php
if (!empty($_SESSION["error"])) {
    var_dump($_SESSION);
    unset($_SESSION["error"]);
}

?>
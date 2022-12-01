<?php
session_start();
error_reporting(E_ALL);
ini_set("display_errors",1);
if (isset($_SESSION["user"])) {
    header("Location: index.php");
    exit;
}


if (!empty($_POST)) {
    if (isset($_POST["email"], $_POST["pass"]) && !empty($_POST["email"]) && !empty($_POST["pass"])) {
       $_SESSION["error"] = [];

       // Verification de l'email
       if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        # code...
        $_SESSION['error'][] = "Ce n'est pas un email correcte";
        }
        include "includes/connexionbdd.php";

        if ($_SESSION['error'] === []) {
            $sql = "SELECT * FROM `user` WHERE `email` = :email";
            $query = $db->prepare($sql);
            $query->bindValue(":email", $_POST["email"], PDO::PARAM_STR);
            $query->execute();
            $verifEmail = $query->fetch();
            var_dump($verifEmail);

            if (empty($verifEmail)) {
                $_SESSION['error'][] = "email ou mot de passe incorrect";
            }
            elseif (!password_verify($_POST["pass"], $verifEmail["pswd"])) {
                $_SESSION['error'][] = "email ou mot de passe incorrect";
            }
            if ($_SESSION['error'] === []) {
                $_SESSION["user"] = [
                    "id" => $verifEmail["id"],
                    "surname" => $verifEmail["surname"],
                    "name" => $verifEmail["name"],
                    "email" => $verifEmail["email"],
                    "birthday" => $verifEmail["birthday"]
                ];

                header("Location: index.php");
            }
        }
    }
    else{
        $_SESSION["error"] = ["Les valeurs sont vides"];
    }
}


$title = "Connexion";
require('includes/header.php');



?>

<form action="" method="post">
    <div>
       <input type="email" name="email"> 
    </div>
    <div>
        <input type="password" name="pass">
    </div>
    <div>
        <button type="submit">Confirmer</button>
    </div>
</form>

<?php
if (!empty($_SESSION["error"])) {
    var_dump($_SESSION);
    unset($_SESSION["error"]);
}

?>
</body>
</html>


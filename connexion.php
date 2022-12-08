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
            

            if (empty($verifEmail)) {
                $_SESSION['error'][] = "email ou mot de passe incorrect";
            }
            elseif (!password_verify($_POST["pass"], $verifEmail["pswd"])) {
                $_SESSION['error'][] = "email ou mot de passe incorrect";
            }
            if ($_SESSION['error'] === []) {
                $role = json_decode($verifEmail['role']);
                if (isset($role[1])) {
                    $_SESSION["user"] = [
                        "id" => $verifEmail["id"],
                        "surname" => $verifEmail["surname"],
                        "name" => $verifEmail["name"],
                        "email" => $verifEmail["email"],
                        "birthday" => $verifEmail["birthday"],
                        "admin" => true
                    ];
                }else{
                     $_SESSION["user"] = [
                    "id" => $verifEmail["id"],
                    "surname" => $verifEmail["surname"],
                    "name" => $verifEmail["name"],
                    "email" => $verifEmail["email"],
                    "birthday" => $verifEmail["birthday"]
                ];
                }
               
                
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

        <!--

<form action="" method="post">

    <div class="container">
        <div class="images">
            <img src="images/img_connexion.svg" alt="">
        </div>
        <div class="col-right">
            <div class="connexion">
                  <h1>Authentification</h1><br>
                <div class="email">
                    <img src="images/email.svg" alt="">
                    <input type="email" name="email" placeholder="Email"> 
                </div>
                <div class="pass">
                    <input type="password" name="pass" placeholder="Mot de passe">
                </div>
                <br>
                <div class="submit">
                    <button type="submit">Connexion</button>
                </div>
            </div>
            <div class="btn-inscription">
                <p>Vous n'avez pas encore de compte ?</p>
                <button>Inscrivez-vous ici</button>
            </div>
        </div>
    </div>
</form>

-->

<section class="vh-100">
        <div class="container py-5 h-100">
          <div class="row d-flex align-items-center justify-content-center h-100">
            <div class="col-md-8 col-lg-7 col-xl-6">
              <img src="images/img_connexion.svg" class="img-fluid" alt="Phone image">
            </div>
            <div class="select_all col-md-7 col-lg-5 col-xl-5 offset-xl-1">
                <div class="test">
                    <form action="" method="post">
                        <h1 class="mb-5 ms-3">Authentification</h1>

                        <!-- Email input
                        <div class=" email form-outline mb-4">
                          <span class="input-group-text" id="basic-addon1"><img src="email.svg" alt="" srcset=""></span>
                          <input type="email" name="email" id="form1Example13" class="form-control form-control-lg col-xs-4" placeholder="Email" />
                        </div>
                        -->

                        <div class="email input-group mb-3">
                          <span class="input-group-text" id="basic-addon1"><img src="images/email.svg" alt="" srcset=""></span>
                          <input type="email" name="email" class="form-control" placeholder="Email" aria-label="Username" aria-describedby="basic-addon1">
                        </div>
            
                        <!-- Password input 
                        <div class="pass form-outline mb-4">
                        <input type="password" name="pass" id="form1Example23" class="form-control form-control-lg" placeholder="Mot de passe"/>
                        </div>
                        -->

                        <div class="pass input-group mb-3">
                          <span class="input-group-text" id="basic-addon1"><img src="images/mdp.svg" alt="" srcset=""></span>
                          <input type="password" name="pass" class="form-control" placeholder="Mot de passe" aria-label="Username" aria-describedby="basic-addon1">
                        </div>

                        <!-- Submit button -->
                        <button type="submit" class="btn btn-primary btn-sm btn-block float-end">Connexion</button>

                    </form>
                </div>  
                <div class="row btn-inscription divider d-flex align-items-center my-4 text-center">
                    <p>Vous n'avez pas encore de compte ?</p>
                    <a href="inscription.php"><button  type="submit" class="btn sign-in btn-primary btn-sm" >Inscrivez-vous ici</button></a>     
                </div>     
            </div>         
          </div>
        </div>
      </section>

<?php
if (!empty($_SESSION["error"])) {
    echo '<p>'.$_SESSION["error"][0].'</p>';
    unset($_SESSION["error"]);
}

?>
</body>
</html>

<!--   Petit Résumé des racourci Bootstrap

    ************   Margin et padding ************


    m- = margin
    p- = padding
        +
    t = top (ex: mt-4 / pt-4)
    b = bottom (ex: mb-5 / pb-5)
    s = left (ex: ms-1 / ps-1)
    e = right (ex: me-2 / pe-2)
    x = left et right (ex: mx-3 / px-3)
    y = top et bottom (ex: my-0 / py-0)
    blank = pour les classes qui définissent un margin ou un padding sur les 4 côtés

    Les valeurs vont de 0 à 5 + auto

    **************** Centrage *****************

    mx-auto = centrage
    text-center

    ************  Float ********************

    float-start = float: left
    float-end = float: right
    float-none = float: none

    *******************************************

-->
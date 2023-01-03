<?php
session_start();
$title = "Responsable";
error_reporting(E_ALL);
ini_set("display_errors",1);
include "includes/fonction.php";
if (!isset($_SESSION["user"])) {
    header("Location: connexion.php");
    exit;
}
require_once "includes/connexionbdd.php";
$sql = "SELECT count(*) as count FROM representantlegal WHERE id_user = :id";
$query = $db->prepare($sql);
$query->bindValue(":id", $_SESSION["user"]["id"], PDO::PARAM_STR);
$query->execute();
$data = $query->fetch();

$dateToday = date("Y-m-d");
$age = date_diff(date_create($_SESSION["user"]["birthday"]), date_create($dateToday));
$age = $age->format('%y');

if ($age >= 14 && $age < 18 && $data["count"] === 0) {
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
    
            // Verification de l'age (Superieur a 18 ans)
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

<style>
    @media (min-width: 765px) and (max-width: 990px) { 
        .d-flex.justify-content-center.flex-row-reverse.h-100 {

            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            height: 50vh;
        }

        .col-md-8.col-lg-7.col-xl-6.d-flex.justify-content-center.flex-wrap-nowrap{
            display: none !important;
        }
    
    }
</style>
<?php 
if (isset($_SESSION['error']) && !empty($_SESSION['error'])) {
    ?>
    
    <div class="alert alert-danger" role="alert" >
        <?= $_SESSION['error'][0] ?>
    </div>

<?php 
unset($_SESSION['error']);  
}
?>

<section class="vh-100">
        <div class="container py-3 h-100">
          <div class="d-flex align-items-center justify-content-center h-100 flex-row-reverse">
            <div class="col-md-8 col-lg-7 col-xl-6 d-flex justify-content-center flex-wrap-nowrap">
              <img src="images/responsable.svg" class="img-fluid" alt="Phone image">
            </div>
            <div class="select_all col-md-7 col-lg-5 col-xl-5 offset-xl-1">
                <div class="test w-100" style="margin-top:0;">
                    <form action="" method="post">
                        <h1 class="titre-page mb-5 ms-3">Responsable Légal</h1>

                        <div class="name input-group mb-3">
                          <span class="input-group-text" id="basic-addon1"><img src="images/avatar.svg" alt="" srcset=""></span>
                          <input type="text" name="name" class="form-control" placeholder="Nom" aria-label="Username" aria-describedby="basic-addon1">
                        </div>

                        <div class="surname input-group mb-3">
                          <span class="input-group-text" id="basic-addon1"><img src="images/avatar.svg" alt="" srcset=""></span>
                          <input type="text" name="surname" class="form-control" placeholder="Prénom" aria-label="Username" aria-describedby="basic-addon1">
                        </div>

                        <div class="email input-group mb-3">
                          <span class="input-group-text" id="basic-addon1"><img src="images/email.svg" alt="" srcset=""></span>
                          <input type="email" name="email" class="form-control" placeholder="Email" aria-label="Username" aria-describedby="basic-addon1">
                        </div>

                        <div class="date input-group mb-3">
                          <span class="input-group-text" id="basic-addon1"><img src="images/date.svg" alt="" srcset=""></span>
                          <input type="date" name="birthday" value="2000-01-01" class="form-control" placeholder="Date de naissance" aria-label="Username" aria-describedby="basic-addon1">
                        </div>
                 
                        <button type="submit" class="btn btn-primary btn-sm btn-block float-end">Enregistrement</button>

                    </form>
                </div>     
            </div>         
          </div>
        </div>
      </section>





</body>
</html>
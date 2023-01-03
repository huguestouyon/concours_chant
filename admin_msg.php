<?php
session_start();


// Faire l'accès administration
if (!isset($_SESSION["user"]) || !isset($_SESSION['user']['admin'])) {
  header("Location: connexion.php");
  exit;
}

// Déconnexion a 30min d'innactivité
if (isset($_SESSION["LAST_ACTIVITY"]) && time() - $_SESSION["LAST_ACTIVITY"] > 1800) {
    header("Location: deconnexion.php");
}

$title = "Msg Admin";
require_once "includes/header.php";
require_once "includes/navbar.php";


if (isset($_SESSION['validate']) && !empty($_SESSION['validate'])) {
    ?>
    
    <div class="alert alert-success" role="alert" >
        <?= $_SESSION['validate'];?>
    </div>

<?php 
unset($_SESSION['validate']);  
}

if (isset($_SESSION['error']) && !empty($_SESSION['error'])) {
    ?>
    
    <div class="alert alert-danger" role="alert" >
        <?= $_SESSION['error'];?>
    </div>

<?php 
unset($_SESSION['error']);  
}
?>
            <style>
                footer{
                    position: relative !important;
                }

          </style>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="me-2 float-end">
            <a href="admin.php">Voir les membres -></a>
        </div>
        <h6 class="m-0 font-weight-bold text-primary">Information sur les membres</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="text-center">Nom entré</th>
                        <th class="text-center">Nom (off)</th>
                        <th class="text-center">Prénom (off)</th>
                        <th class="text-center">Email (off)</th>
                        <th class="text-center">Email</th>
                        <th class="text-center">Date</th>
                        <th class="text-center">Sujet</th>
                        <th class="text-center">Message</th>
                        <th class="text-center">Réponse</th>
                        <th class="text-center">Supprimer</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th class="text-center">Nom entré</th>
                        <th class="text-center">Nom (off)</th>
                        <th class="text-center">Prénom (off)</th>
                        <th class="text-center">Email (off)</th>
                        <th class="text-center">Email</th>
                        <th class="text-center">Date</th>
                        <th class="text-center">Sujet</th>
                        <th class="text-center">Message</th>
                        <th class="text-center">Réponse</th>
                        <th class="text-center">Supprimer</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                    require_once "includes/connexionbdd.php";
                    $sql = "SELECT contact.id as id, contact.nom as nom, contact.date as `date`, contact.subject as subject, contact.message as `message`, contact.email as mail, user.surname as surname_off, user.name as name_off, user.email as email_off FROM `contact` INNER JOIN user ON user.id = contact.id_user ORDER BY user.id";
                    $query = $db->prepare($sql);
                    $query->execute();
                    $datas = $query->fetchAll();
                    foreach ($datas as $data):
                        ?>

                        <tr>
                            <th class="text-center"><?= $data["nom"] ?></th>
                            <th class="text-center"><?= $data["name_off"] ?></th>
                            <th class="text-center"><?= $data["surname_off"] ?></th>
                            <th class="text-center"><?= $data["email_off"] ?></th>
                            <th class="text-center"><?= $data["mail"] ?></th>
                            <th class="text-center"><?= $data["date"] ?></th>
                            <th class="text-center"><?= $data["subject"] ?></th>
                            <th class="text-center"><?= $data["message"] ?></th>
                            
                            <th class="text-center">
                                <a class="btn btn-warning" href="mailto:<?= $data["mail"] ?>">✉️</a>
                            </th>

                            <th class="text-center">
                            <form action="php/delete_mess.php" method="POST">
                                <input type="hidden" name="id_message" value="<?=  $data["id"] ?>">
                                <button type="submit" class="btn" style="background-color: white;">❌</button>
                            </form>
                            </th>
                        </tr>
                        
                    <?php
                    endforeach;
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<?php
require_once "includes/footer.php";
?>
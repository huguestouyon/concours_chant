<?php
session_start();

// Faire l'accès administration
if (!isset($_SESSION["user"]) || !isset($_SESSION['user']['admin'])) {
  header("Location: connexion.php");
  exit;
}


$title = "Admin";
require_once "includes/header.php";
require_once "includes/navbar.php";
?>

<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Information sur les membres</h6>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th class="text-center">ID</th>
            <th class="text-center">Nom</th>
            <th class="text-center">Prenom</th>
            <th class="text-center">Email</th>
            <th class="text-center">Age</th>
            <th class="text-center">Titre accepté</th>
            <th class="text-center">Validation de l'audio</th>
            <th class="text-center">Chèque</th>
            <th class="text-center">Nom RL</th>
            <th class="text-center">Prénom RL</th>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <th class="text-center">ID</th>
            <th class="text-center">Nom</th>
            <th class="text-center">Prenom</th>
            <th class="text-center">Email</th>
            <th class="text-center">Age</th>
            <th class="text-center">Titre accepté</th>
            <th class="text-center">Validation de l'audio</th>
            <th class="text-center">Chèque</th>
            <th class="text-center">Nom RL</th>
            <th class="text-center">Prénom RL</th>
          </tr>
        </tfoot>
        <tbody>
          <?php
          require_once "includes/connexionbdd.php";
          //$sql = "SELECT user.id as id, surname, `name`, email, birthday, register_date, title_chosen, title_validate, localisation_track, cheque, track_validate FROM `user` INNER JOIN validation ON user.id = validation.id_user ORDER BY user.id";
          $sql = "SELECT user.id as id, user.surname as surname, user.name as name, user.email as email, user.birthday as birthday, register_date, title_chosen, title_validate, localisation_track, cheque, track_validate, representantlegal.name as rlname, representantlegal.surname as rlsurname, title, artist, image, id_chant FROM `user` LEFT JOIN validation ON user.id = validation.id_user LEFT JOIN chant ON user.id = chant.id_user LEFT JOIN representantlegal ON user.id = representantlegal.id_user ORDER BY user.id";
          $query = $db->prepare($sql);
          $query->execute();
          $datas = $query->fetchAll();
          $i = 0;
          foreach ($datas as $data => $value) :
            $dateNaissance = $value["birthday"];
            $aujourdhui = date("Y-m-d");
            $diff = date_diff(date_create($dateNaissance), date_create($aujourdhui));
            
          ?>
            <tr>
              <th class="text-center"><?= $value["id"] ?></th>
              <th class="text-center"><?= $value["surname"] ?></th>
              <th class="text-center"><?= $value["name"] ?></th>
              <th class="text-center"><?= $value["email"] ?></th>
              <th class="text-center"><?= $diff->format('%y') ?></th>
              <th class="text-center">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop<?= $i ?>">
                  <?php
                  if (isset($value['title'])){
                  echo $value['title'] . " de " . $value['artist'];
                }
                  ?>
                </button>
                <?php
                if ($value['title_validate'] === 1 ) {
                echo "✔️";
                }
            ?>
              </th>
              <th class="text-center"></th>
              <th class="text-center"><?= $value["cheque"] ?></th>
              <th class="text-center"><?= $value["rlname"] ?></th>
              <th class="text-center"><?= $value["rlsurname"] ?></th>
            </tr>
            <?php 

            ?>
            <!-- Modal -->
            <div class="modal fade" id="staticBackdrop<?= $i ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel"><?= $value['title'] ." de ". $value['artist'] ?></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body text-center">
                    <img src="<?= $value['image'] ?>" alt="">
                  </div>
                  <div class="modal-footer">
                     <form action="refus.php" method="POST">
                      <input type="hidden" name="refuser" value="<?= $value['id'] ?>">
                      <button type="submit" class="btn btn-secondary">Refuser</button>
                    </form> 
                    <button type="button" class="btn btn-secondary">Accepter</button>
                  </div>
                </div>
              </div>
            </div>
          <?php
            $i++;
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
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

$title = "Admin";
require_once "includes/header.php";
require_once "includes/navbar.php";
?>
<?php 
if (isset($_SESSION['error']) && !empty($_SESSION['error'])) {
    ?>
    
    <div class="alert alert-danger" role="alert" >
        <?= $_SESSION['error'];?>
    </div>

<?php 
unset($_SESSION['error']);  
}
?>
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <div class="me-2 float-end">
      <a href="admin_msg.php">Voir les messages -></a>
    </div>
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
          $sql = "SELECT user.id as id, user.surname as surname, user.name as name, user.email as email, user.birthday as birthday, register_date, title_chosen, title_validate, localisation_track, cheque, track_validate, representantlegal.name as rlname, representantlegal.surname as rlsurname, title, artist, image, id_chant FROM `user` INNER JOIN validation ON user.id = validation.id_user LEFT JOIN chant ON user.id = chant.id_user LEFT JOIN representantlegal ON user.id = representantlegal.id_user ORDER BY user.id";
          $query = $db->prepare($sql);
          $query->execute();
          $datas = $query->fetchAll();
          $i = 0;
          foreach ($datas as $data => $value) :
            $dateNaissance = $value["birthday"];
            $aujourdhui = date("Y-m-d");
            $diff = date_diff(date_create($dateNaissance), date_create($aujourdhui));



          ?>
          <style>
            footer{
              position: relative;
            }

          </style>
            <tr>
              <th class="text-center"><?= $value["id"] ?></th>
              <th class="text-center"><?= $value["surname"] ?></th>
              <th class="text-center"><?= $value["name"] ?></th>
              <th class="text-center"><?= $value["email"] ?></th>
              <th class="text-center"><?= $diff->format('%y') ?></th>
              <th class="text-center">
                <!-- Button trigger modal -->
                <?php
                  if (!empty($value['title'])) : ?>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop<?= $i ?>">
                  <?php
                    echo $value['title'] . " de " . $value['artist'];
                  ?>
                </button>
                <?php
                endif;
                if ($value['title_validate'] === 1) {
                  echo "✔️";
                }
                ?>
              </th>
              <th class="text-center">
                <?php
                if (!empty($value['localisation_track'])) : ?>
                  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop2<?= $i ?>">
                    <?php
                    if (isset($value['title'])) {
                      echo 'Ecouter la bande son';
                    }
                    ?>
                  </button>

                <?php

                endif;
                if ($value['track_validate'] === 1) {
                  echo "✔️";
                }
                ?>

              </th>
              <th class="text-center">
                <?php
                if ($value['track_validate'] === 1) : ?>
                  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop3<?= $i ?>">
                    <?php
                    if (isset($value['title'])) {
                      echo 'Cheque';
                    }
                    ?>
                  </button>

                <?php

                endif;
                if ($value['cheque'] === 1) {
                  echo "✔️";
                } 
                elseif ($value['cheque'] === 0 && $value['track_validate'] === 1) {
                  echo "❌";
                }
                ?>

              </th>
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
                    <h1 class="modal-title fs-5" id="staticBackdropLabel"><?= $value['title'] . " de " . $value['artist'] ?></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body text-center">
                    <img src="<?= $value['image'] ?>" alt="">
                  </div>
                  <?php
                  if ($value['title_validate'] === 0) : ?>
                    <div class="modal-footer">
                      <form action="php/refus.php" method="POST">
                        <input type="hidden" name="refuser" value="<?= $value['title_chosen'] ?>">
                        <button type="submit" class="btn btn-secondary">Refuser</button>
                      </form>
                      <form action="php/valider.php" method="POST">
                        <input type="hidden" name="valider" value="<?= $value['title_chosen'] ?>">
                        <button type="submit" class="btn btn-secondary">Accepter</button>
                      </form>
                    </div>
                  <?php
                  endif;
                  ?>
                </div>
              </div>
            </div>

            <!-- Modal track -->
            <div class="modal fade" id="staticBackdrop2<?= $i ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel"><?= $value['title'] . " de " . $value['artist'] ?></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body text-center">
                    <img src="<?= $value['image'] ?>" alt="">
                    <audio src="<?= $value['localisation_track'] ?>" controls>juujuu</audio>
                  </div>
                  <?php
                  if ($value['cheque'] === 0) : ?>
                    <div class="modal-footer">
                      <form action="php/musiquerefus.php" method="POST">
                        <input type="hidden" name="musiquerefus" value="<?= $value['title_chosen'] ?>">
                        <button type="submit" class="btn btn-secondary">Refuser</button>
                      </form>
                      <form action="php/musiquevalider.php" method="POST">
                        <input type="hidden" name="musiquevalider" value="<?= $value['title_chosen'] ?>">
                        <button type="submit" class="btn btn-secondary">Accepter</button>
                      </form>
                    </div>
                  <?php
                  endif;
                  ?>
                </div>
              </div>
            </div>

            <!-- Modal cheque -->
            <div class="modal fade" id="staticBackdrop3<?= $i ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel"><?= $value['title'] . " de " . $value['artist'] ?></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body text-center">
                    <p>Entrez l'adresse pour valider la reception du chèque :</p>
                    <form method="POST" action="php/adress.php">
                      <div class="adressForm">
                    <input type="text" name="adress" placeholder="Adresse">
                    <input type="text" name="cp" placeholder="Code Postal">
                    <input type="text" name="city" placeholder="Ville">
                    <input type="hidden" name="chequevalider" value="<?= $value['title_chosen'] ?>">
                    <button type="submit">Valider</button>
                    </div>
                </form>
                  </div>
                  <?php
                  if ($value['cheque'] === 0) : ?>
                    <div class="modal-footer">
                      <form action="" method="POST">
                        <input type="hidden" name="chequerefus" value="<?= $value['title_chosen'] ?>">
                        <button type="submit" class="btn btn-secondary">Refuser</button>
                      </form>
                    </div>
                  <?php
                  endif;
                  ?>
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
<?php
session_start();
include('../includes/connexionbdd.php');




//On supprime la ligne dans chant et on enleve la key de la chanson dans validate
 $sql= "DELETE FROM `chant` WHERE `id_chant` = :id";
     $query = $db->prepare($sql);
      $query->bindValue(":id", $_POST['refuser'], PDO::PARAM_STR);
      $query->execute();
     $sql= "UPDATE `validation` SET `title_chosen`=:title WHERE `title_chosen`=:titlechosen";
     $query = $db->prepare($sql);
          $query->bindValue(":titlechosen", $_POST['refuser'], PDO::PARAM_STR);
          $query->bindValue(":title", "0", PDO::PARAM_STR);
          $query->execute();

  header('Location: ../admin.php');
?>
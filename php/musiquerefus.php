<?php
session_start();
// error_reporting(E_ALL);
// ini_set("display_errors",1);
include('../includes/connexionbdd.php');

//on enleve le track de la chanson dans validate

     $sql= "UPDATE `validation` SET `localisation_track`=:title WHERE `title_chosen`=:titlechosen";
     $query = $db->prepare($sql);
          $query->bindValue(":titlechosen", $_POST['musiquerefus'], PDO::PARAM_STR);
          $query->bindValue(":title", NULL, PDO::PARAM_STR);
          $query->execute();

  header('Location: ../admin.php');
?>
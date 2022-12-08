<?php
session_start();
// error_reporting(E_ALL);
// ini_set("display_errors",1);
include('../includes/connexionbdd.php');

//on enleve le track de la chanson dans validate

     $sql= "UPDATE `validation` SET `cheque`=:cheque WHERE `title_chosen`=:titlechosen";
     $query = $db->prepare($sql);
          $query->bindValue(":titlechosen", $_POST['chequevalider'], PDO::PARAM_STR);
          $query->bindValue(":cheque", '1', PDO::PARAM_STR);
          $query->execute();

  header('Location: ../admin.php');
?>
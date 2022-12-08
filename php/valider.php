<?php
session_start();

include('../includes/connexionbdd.php');

$sql= "UPDATE `validation` SET `title_validate`=:title WHERE `title_chosen` = :id";
$query = $db->prepare($sql);
     $query->bindValue(":id", $_POST['valider'], PDO::PARAM_STR);
     $query->bindValue(":title", "1", PDO::PARAM_STR);
     $query->execute();
     
  header('Location: ../admin.php');


?>
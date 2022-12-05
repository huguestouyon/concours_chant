<?php
if (!empty($_POST['track'])) {
   include 'includes/connexionbdd.php';
    $sql = "INSERT INTO `validation`(`id_user`, `title_chosen`) VALUES (:id,:title)";
    $query = $db->prepare($sql);
    $query->bindValue(":id", $_SESSION['id'], PDO::PARAM_STR);
    $query->bindValue(":id", $_POST['track'], PDO::PARAM_STR);
    $query->execute();
}
<?php
session_start();
include('../includes/connexionbdd.php');



    if (!empty($_POST)) {
       if (isset($_POST['adress'],$_POST['cp'],$_POST['city']) && !empty($_POST['adress']) && !empty($_POST['cp']) && !empty($_POST['city'])) {
        
        $adress = strip_tags($_POST['adress']);
        $cp = strip_tags($_POST['cp']);
        $city = strip_tags($_POST['city']);

        if (strlen($cp) != 5) {
            $_SESSION["error"] = ['Pas le bon nombre de caractères sur le code postal'];
        }
        if ($_SESSION["error"] === []) {
            $sql= "UPDATE `validation` SET `cheque`=:cheque WHERE `title_chosen`=:titlechosen";
            $query = $db->prepare($sql);
            $query->bindValue(":titlechosen", $_POST['chequevalider'], PDO::PARAM_STR);
            $query->bindValue(":cheque", '1', PDO::PARAM_STR);
            $query->execute();
   
            $sql = "SELECT `id_user`FROM `validation` WHERE `title_chosen`= :title";
            $query = $db->prepare($sql);
            $query->bindValue(":title", $_POST['chequevalider'], PDO::PARAM_STR);
            $query->execute();
            $id_user = $query->fetch();
   
            $sql= "INSERT INTO `facture`(`id_user`,`adresse`, `cp`, `ville`) VALUES (:id,:adress,:cp,:ville)";
            $query = $db->prepare($sql);
            $query->bindValue(":id", $id_user['id_user'], PDO::PARAM_STR);
            $query->bindValue(":adress", $adress, PDO::PARAM_STR);
            $query->bindValue(":cp", $cp, PDO::PARAM_STR);
            $query->bindValue(":ville", $city, PDO::PARAM_STR);
            $query->execute();
             
        header('Location: ../admin.php');

        }
        

       }
    }



?>
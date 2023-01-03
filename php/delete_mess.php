<?php
session_start();

if (!isset($_SESSION["user"]) || !isset($_SESSION['user']['admin'])) {
    header("Location: connexion.php");
    exit;
  }

  if (isset($_POST)) {

    $id = (is_numeric($_POST["id_message"])) ? (int) $_POST["id_message"] : 0;

    require_once "../includes/connexionbdd.php";
        $sql = "DELETE FROM  contact WHERE id = :id";
        $query = $db->prepare($sql);
        $query->bindValue(":id", $id, PDO::PARAM_INT);
        $query->execute();
        $_SESSION['validate'] = "Le message a bien été supprimé";

        header("Location: ../admin_msg.php");

        
  }
  else {
    $_SESSION['error'] = "Une erreur est survenue";

    header("Location: ../admin_msg.php");
  }

?>
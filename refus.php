<?php
session_start();

if (!isset($_SESSION["user"]) || !isset($_SESSION['user']['admin'])) {
    header("Location: connexion.php");
    exit;
  }

  if (isset($_POST)) {
    var_dump($_POST);
    
  }
  else{
    // header("Location: admin.php");
  }


?>
<?php
session_start();

include('includes/header.php');
include('includes/navbar.php');
?>



<div class="containerMonSuivi">
<h2>Mon suivi :</h2>
<div class="thecontainerMonSuivi">
    <div>
        <img src="images/Group 1.svg" alt="illustration">
    </div>
    <div class="choseSong">
        <form class="formUpload" action="" method="post" enctype="multipart/form-data">
      
            <label for="fichier">Inscription terminée ! Télécharger la facture ci-dessous.</label>
        
    </form>
    </div>
</div>
<div class="thecontainer">
<!-- la barre de progression -->
<div class="global">

        <div class="form">
            <div class="rond rond1"></div>
            <div class="middle middle1">
                <div class="sousbar sousbar1"></div>
            </div>
            <div class="rond rond2"></div>
            <div class="middle middle2">
            <div class="sousbar sousbar2"></div>
            </div>
            <div class="rond rond3"></div>
            <div class="middle middle3">
            <div class="sousbar sousbar3"></div>
            </div>
            <div class="rond rond4"></div>
        </div>
        <div class="text">
            <p>Chèque Validé</p>

        </div>
        <?php
        if(isset($_SESSION["error"])){
            var_dump($_SESSION["error"]);
            unset($_SESSION["error"]);
        }
        ?>
    </div>
</div>
</div>
<script>
    var sousbar1 = document.querySelector(".sousbar1");
    var sousbar2 = document.querySelector(".sousbar2");
    var sousbar3 = document.querySelector(".sousbar3");
    var rond2 = document.querySelector(".rond2");
    var rond3 = document.querySelector(".rond3");
    var rond4 = document.querySelector(".rond4");
    sousbar1.style.width = "100%";
    sousbar2.style.background = "#85339b";
    sousbar2.style.width = "100%";
    sousbar3.style.background = "#85339b";
    sousbar3.style.width = "100%";
    rond2.style.background = "#85339b";
    rond3.style.background = "#85339b";
    rond4.style.background = "#85339b";
</script>




<?php
include('includes/footer.php');
?>
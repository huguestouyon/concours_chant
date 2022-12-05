<?php
session_start();
include('includes/connexionbdd.php');


include('includes/header.php');
include('includes/navbar.php');
?>
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
            <p>Titre Envoyé</p>

        </div>
    </div>
</div>

<?php
include('includes/footer.php');
?>
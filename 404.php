<?php
require_once "includes/header.php";

?>
<style>
   .page-error {
    background-color: #EEEEEE;
    width: 100vw;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
   }
   .page-error img{
    width: 50vw;
    height: auto;
   }
   @media (max-width: 700px) { 
    .page-error img{
        width: 90vw;
        height: auto;
       }
    }
       </style>
<div class="page-error">
    <img src="images/Group 15.svg" alt="404 error">
</div>

</body>
</html>
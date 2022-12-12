<?php

require __DIR__.'/vendor/autoload.php';

use Spipu\Html2Pdf\Html2Pdf;

$html2pdf = new Html2Pdf();
$html2pdf->writeHTML('<h4>Mairie de Longuenesse</h4>');
$html2pdf->writeHTML('<h4>13 rue Joliot Curie,</h4>');
$html2pdf->writeHTML('<h4>62219, Longuenesse</h4>');
$html2pdf->writeHTML('<h4></h4>');
$html2pdf->writeHTML('This is my first test');




$html2pdf->output();
?>

<page>
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th class="text-center">ID</th>
            <th class="text-center">Nom</th>
            <th class="text-center">Prenom</th>
            <th class="text-center">Email</th>
            <th class="text-center">Age</th>
            <th class="text-center">Titre accepté</th>
            <th class="text-center">Validation de l'audio</th>
            <th class="text-center">Chèque</th>
            <th class="text-center">Nom RL</th>
            <th class="text-center">Prénom RL</th>
          </tr>
        </thead>
    </table>

</page>
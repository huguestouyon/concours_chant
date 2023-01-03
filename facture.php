<?php
session_start();
ob_start();


include "includes/connexionbdd.php";

$sql = "SELECT * FROM `facture` WHERE `id_user` = :user";
$query = $db->prepare($sql);
$query->bindValue(":user", $_SESSION['user']['id'], PDO::PARAM_STR);
$query->execute();
$data = $query->fetch();

$date = "Facturé le " . date("d/m/Y");
?>
<style>
    .mt {
        margin-top: 5%;
    }

    .mt-5 {
        margin-top: 60px;
    }

    .container_id {
        width: 50%;
    }

    .ml-5 {
        margin-left: 60%;
    }

    .ml-1 {
        margin-left: 20%;
    }

    ul {
        list-style: none;
    }

    .bold {
        font-weight: bold;
    }

    .border {
        border: 1px solid black;
    }

    .container-body {
        width: 100%;
        text-align: center;
    }

    .text-center {
        text-align: center;
    }

    table, caption, th, td {
    border: 1px solid black;
    border-collapse: collapse;
    }

    td, th {
        padding: 10px;
    }
</style>

<page>
    <div class="text-center">
        <img src="images/longuenesse.png" alt="">
    </div>
    <div class="container_id">
        <ul class="">
            <li>
                <h4>Identification du prestataire :</h4>
            </li>
            <li><span class="bold">Nom :</span> Mairie de Longuenesse</li>
            <li><span class="bold">Adresse :</span> 13 Rue Joliot Curie</li>
            <li><span class="bold">Ville :</span> 62219 Longuenesse</li>
            <li><span class="bold">Numéro de SIREN :</span> 216205252</li>
            <li><span class="bold">Numéro de téléphone :</span> 03 21 12 23 00</li>
            <li>
                <h4>Enregistré à l'INSEE depuis 1978</h4>
            </li>
        </ul>
    </div>

    <div class="container_cl ml-5">
        <ul>
            <li>
                <h4 class="text-center">Facturé à :</h4>
            </li>
            <li><span class="bold ml-1">Nom / Prénom :</span> <?= $_SESSION['user']['name'] . " " . $_SESSION['user']['surname'] ?></li>
            <li><span class="bold ml-1">Adresse : </span><?= $data['adresse'] ?></li>
            <li><span class="bold ml-1">Ville : </span><?= $data['cp'] . ", " .  $data['ville'] ?></li>
            <li>
                <h4 class="text-center">Merci de nous faire confiance !</h4>
            </li>

        </ul>
    </div>


    <div class="container-body mt">
            <h2><?= "Facture n° " . $data['id'] ?></h2>
            <h3><?= "Facturé le " . date("d/m/Y") ?></h3>
            <table class="mt-5" style="margin-left: 28.5%;">
                <tr>
                    <th>Produit(s)</th>
                    <th>Moyen de paiement</th>
                    <th>Prix</th>
                </tr>
                <tr>
                    <td>Concours de chant</td>
                    <td>Chèque</td>
                    <td>30€</td>
                </tr>
            </table>
        </div>
        <div class="text-center mt-5">
            <img src="images/sceau.png" alt="">
        </div>
    <page_footer>
        <div class="footer">
            Les Voix de l'Audomarois, SAS au capital de 1€<br>
            13 Rue Joliot Curie, 62219 Longuenesse<br>
            Enregistré à l'INSEE depuis 1978<br>
        </div>
    </page_footer>
</page>

<?php
$content = ob_get_clean();
require 'vendor/autoload.php';

use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;

try {
    $html2pdf = new Html2Pdf('P', 'A4', 'fr', true, 'UTF-8');
    $html2pdf->pdf->SetDisplayMode('fullpage');
    $html2pdf->writeHTML($content);
    $html2pdf->output('facture.pdf', 'd');
} catch (Html2PdfException $e) {
    die($e);
}

?>
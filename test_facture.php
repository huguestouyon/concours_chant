<?php 
session_start();
ob_start();
// $_SESSION['user']=[
//     "Nom"=> $Nom,
//     "Prenom" => $Prenom,
//     "email"=> $Email,
//     "age"=>$Age,
//     "sexe"=>$Sexe,
// ];

include "includes/connexionbdd.php";

    $sql = "SELECT * FROM `facture` WHERE `id_user` = :user";
    $query = $db->prepare($sql);
    $query->bindValue(":user",$_SESSION['user']['id'], PDO::PARAM_STR);
    $query->execute();
    $data = $query->fetch();

    $test = $data['adresse'];

$nomDuClient=$_SESSION['user']['name'];
$prenomDuClient=$_SESSION['user']['surname']; 
$adresseDuClient= $data['adresse'];
$cpDuClient= $data['cp'];
$villeDuClient= $data['ville'];
$numeroDeTelDuClient=$_SESSION['user']['email'];
$date = "Facturé le " . date("d/m/Y") ;
$facture="Facture n°". $data['id'] . "<br>";
$prix="100€";
$daterdv="a voir";
?>
<style>
 .premiertable{width: 100%; }
 .deuxiemetable{width: 100%; }
.client{  text-align:center;width: 100%;}
.date{ text-align:center; width: 100%;}
.styleEcriture{font-size: large;border: 1px solid black;}
.bordureEntreprise{border:solid 1px black ; width:50%; height:16%; text-align:center}
.bordureClientUne{ width:30%; }
.BordureDeux{border:solid 1px black ; width:110%;}
.imgtest{text-align:center;}
.footer{font-style: italic;}

</style>

<page  backimg="images/longuenesse.png" backimgx="right" backimgy="10%" backimgw="40%" backtop="20mm" backleft="10mm" backright="10mm" >
    
    <table class="premiertable" >
        <tr>
            <td >
                <div class="bordureEntreprise">
            <p class="styleEcriture">
            <b>Identifcation du prestataire</b><br><br>
            <strong>Nom</strong>: Mairie de Longuenesse<br>
            <strong>Adresse</strong>: 13 Rue Joliot Curie, 62219 Longuenesse<br>
            <strong>Numéro de SIREN</strong>: 216205252<br>
            <strong>Numéro de téléphone</strong>: 03 21 12 23 00<br>
            Enregistré à l'INSEE depuis 1978
            </p>
            </div>
            </td>
            </tr>
            <tr class=>
                <td class="client"  >
                    
                <div class="bordureClientUne">
                <div class="BordureDeux">
                <p class="styleEcriture"><b>Facturé à :</b><br><br>
                <?php echo $nomDuClient ;?><br>
                <?php echo $prenomDuClient ;?><br/>
                <?php echo $adresseDuClient ;?><br/>
                <?php echo $cpDuClient . " , " .  $villeDuClient ;?><br/>
                <?php echo $numeroDeTelDuClient ;?>
                </p>
                </div>
                </div>
                </td>
            </tr>
    </table>
    <table class="deuxiemetable">
        <tr>
        <td class="date">
        <br><br><br><br>
            <p class=" styleEcriture"><strong><?php echo $facture ?></strong></p>
             <p class=" styleEcriture"><?php echo $date ?></p>
             <br><br><br><br><br>
         </td>
        </tr>
        <tr>
            <td style="text-align:center; margin-top:10px;">
                Nous vous confirmons la réception de votre paiement d'un montant de <?php echo $prix ?>.<br><br>
                Nous vous invitons a vous présentez le <?php echo $daterdv ?> pour votre prestation.<br><br>
                Veuillez recevoir l'assurance de ma considération distinguée.<br><br>
                Thevoice DIRECTOR <br><br><br><br>
            </td>
        </tr>
        <tr><td>
            <div class="imgtest">
               <img src="images/longuenesse.png" style="text-align:center" > 
            </div>
        </td></tr>
    </table>
    <page_footer > 
    <p class="footer">
        Thevoice, SAS au capital de 10000000€<br>
        Champ de Mars, 5 Av. Anatole France, 75007 Paris<br>
        Immatriculé au RCS de Paris sous le numéro RCS PARIS B 517 403 572<br>
        TVA intracommunautaire : FR 53 157896342
    </p>
    </page_footer>
</page>

<?php
$content=ob_get_clean();
require 'vendor/autoload.php';
use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;
try{
    $html2pdf = new Html2Pdf('P', 'A4', 'fr', true, 'UTF-8');
    $html2pdf->pdf->SetDisplayMode('fullpage');
    $html2pdf->writeHTML($content);
    $html2pdf->output('facture.pdf');
    
}catch(Html2PdfException $e){
    die($e);
}

?>
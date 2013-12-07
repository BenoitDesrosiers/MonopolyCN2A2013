<?php
require_once('../util/main.php');
require_once "dataMapper/carteProprieteDataMapper.php";
require_once "dataMapper/caseAchetableDataMapper.php";
require_once "modele/cartePropriete.php";
require_once "modele/carte.php";
require_once "modele/caseDeJeuPropriete.php";
require_once "modele/caseDeJeu.php";

//$carte = CartePropriete::pourCasePartie($_GET['case'], 1);

$case = CaseDeJeuAchetable::parId($_GET['case']);

?>


<?php echo $case->getNom() ?>
</br>
<?php echo "Prix : ".$case->getPrix() ?>
</br>

<?php if ($case->getType() == "propriete") { 
echo "Cout d'une maison : ".$case->getCoutMaison() ?>
</br>
<?php echo "Cout d'un h&ocirc;tel : ".$case->getCoutHotel() ?>
</br>
<?php } 
echo "Hypoth&egrave;que : ".$case->getHypotheque() ?>
</br>
</br>
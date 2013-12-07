<?php
require_once('../util/main.php');
require_once('modele/usager.php');
require_once('modele/joueur.php');
require_once('modele/partie.php');
require_once('modele/paiementALaBanque.php');

$carteId=$_GET['carteId'];
$partieId=$_GET['partieId'];
$carte = CartePropriete::pourCasePartie($carteId, $partieId);
?>
<table border="1">


<?php 
echo "<tr>";
echo "<td>";
echo "Nom de la propriete";
echo "</td>";
echo "<td>";
echo $carte->getCaseAssociee()->getNom();
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>";
echo "Prix de la propriete";
echo "</td>";
echo "<td>";
echo $carte->getCaseAssociee()->getPrix()."$";
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>";
echo "Montant de location";
echo "</td>";
echo "<td>";
echo $carte->getCaseAssociee()->getLocation()."$";
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>";
echo "Montant de location avec une maison";
echo "</td>";
echo "<td>";
echo $carte->getCaseAssociee()->getLocation1()."$";
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>";
echo "Montant de location avec deux maisons";
echo "</td>";
echo "<td>";
echo $carte->getCaseAssociee()->getLocation2()."$";
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>";
echo "Montant de location avec trois maisons";
echo "</td>";
echo "<td>";
echo $carte->getCaseAssociee()->getLocation3()."$";
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>";
echo "Montant de location avec quatre maisons";
echo "</td>";
echo "<td>";
echo $carte->getCaseAssociee()->getLocation4()."$";
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>";
echo "Montant de location avec un hotel";
echo "</td>";
echo "<td>";
echo $carte->getCaseAssociee()->getLocation5()."$";
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>";
echo "Montant de l'hypotheque";
echo "</td>";
echo "<td>";
echo $carte->getCaseAssociee()->getHypotheque()."$";
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>";
echo "Cout d'un hotel";
echo "</td>";
echo "<td>";
echo $carte->getCaseAssociee()->getCoutHotel()."$";
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>";
echo "Cout d'une maison";
echo "</td>";
echo "<td>";
echo $carte->getCaseAssociee()->getCoutMaison()."$";
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>";
echo "Nombre d'hotel";
echo "</td>";
echo "<td>";
echo $carte->getNombreHotels();
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>";
echo "Nombre de maison";
echo "</td>";
echo "<td>";
echo $carte->getNombreMaisons();
echo "</td>";
echo "</tr>";



//echo $carteId;
//echo $partieId;
?>
</table>
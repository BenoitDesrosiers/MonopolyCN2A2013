<?php
/* 
 * page affichant le tableau de jeu 
 * 
 */
require_once('../../util/main.php');
require_once('util/secure_conn.php');
require_once('modele/carteCC.php');
require_once('modele/paiementParBatiment.php');
require_once('modele/usager.php');
require_once('modele/coordonnateur.php');
require_once('modele/partie.php');
require_once('dataMapper/partieDataMapper.php');

// demarre la session, doit Ãªtre fait aprÃ¨s tout les includes
session_start();

//verifie si un usager est connecte
include "util/login.php";

if (isset($_POST['action'])) {
    $action = $_POST['action'];
} elseif (isset($_GET['action'])) {
    $action = $_GET['action'];
} elseif (isset($_SESSION['user'])) {
    $action = 'afficher';
} else {
    $action = 'test';
}

$usager = $_SESSION['usager'];
$joueur = Joueur::parComptePartie($usager->getCompte(), "1"); //FIXME pour les tests, on plug 1 comme numero de partie


switch ($action) {
	
    case 'test' : //code pour fin de test de la fonction PaiementParBatiment
    	
    	$partie = Partie::parId('1'); //ceci etant un demo, nous utiliserons la partie #1
    	$titrePage= "Test de la fonction paiement par batiment, avec jour benoit, partie 1, carte id 15.";

    	$carte = new carteCC(); //TODO: ajouter une factory a carte pour les gŽnŽrer par id
    	$carte->setId("15"); //la carte CC impot 40$ par maison
    	
    	$paiement = new paiementParBatiment;
    	
    	//normalement PaiementParBatiment ne retourne pas de valeur et appelle directement la banque pour faire payer, valeur de retour ici pour voir que le calcul fonctionne.
    	$test = $paiement->calculPaiementParBatiment($joueur, $carte, $partie);
    	
    	echo $titrePage;
    	echo "</br></br>";
    	echo $test;

       	break;
    default:
        affiche_erreur("Action inconnue: " . $action);
        break;
}
?>
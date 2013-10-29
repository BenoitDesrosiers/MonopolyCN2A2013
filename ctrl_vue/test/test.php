<?php
/* 
 * page affichant le tableau de jeu 
 * 
 */
require_once('../../util/main.php');
require_once('util/secure_conn.php');
require_once('modele/carte.php');
require_once('modele/paiementParBatiment.php');
require_once('modele/usager.php');
require_once('modele/coordonnateur.php');
require_once('modele/partie.php');
require_once('dataMapper/partieDataMapper.php');

// demarre la session, doit être fait après tout les includes
session_start();

//verifie si un usager est connecté
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

$coordonnateur = $_SESSION['usager'];

switch ($action) {
	
    case 'test' :
    	$titrePage= "affichage du tableau de jeu";
    	$partie = Partie::parId('1'); //ceci étant un démo, nous utiliserons la partie #1
    	$tableauDeJeu = $partie->getTableau();
    	
    	$joueur = new Joueur("benoit", "benoit", "benoit");
    	$carte = new carte("15");
    	
    	$paiement = new paiementParBatiment;
    	$test = $paiement->calculPaiementParBatiment($joueur, $carte);
    	echo $test;
    	
      	include('./affichageTableau_view.php');
       	break;
    default:
        affiche_erreur("Action inconnue: " . $action);
        break;
}
?>
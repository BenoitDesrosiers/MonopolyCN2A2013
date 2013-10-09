<?php
/* 
 * page affichant le tableau de jeu 
 * 
 */
require_once('../../util/main.php');
require_once('util/secure_conn.php');
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
    $action = 'afficher';
}

$coordonnateur = $_SESSION['usager'];

switch ($action) {
	
    case 'afficher' :
    	$titrePage= "affichage du tableau de jeu";
    	$partie = Partie::parId('1'); //ceci étant un démo, nous utiliserons la partie #1
    	$tableauDeJeu = $partie->getTableau();
    	
      	include('./affichageTableau_view_0822113.php');
       	break;
    default:
        affiche_erreur("Action inconnue: " . $action);
        break;
}
?>
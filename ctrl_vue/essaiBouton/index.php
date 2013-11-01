<?php
/* 
 * page affichant le tableau de jeu 
 * 
 */
require_once('../../util/main.php');
require_once('util/secure_conn.php');
require_once('modele/usager.php');
require_once('modele/paiementALaBanque.php');
require_once('modele/coordonnateur.php');
require_once('modele/partie.php');
require_once('modele/joueur.php');
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
    $action = 'essai';
} else {
    $action = 'essai';
}

$coordonnateur = $_SESSION['usager'];

switch ($action) {
	
    case 'essai' :
    	$montant = 350;
    	$password = "aaa";
    	$compte = "benoit";
    	$nom = "bob";
    	$mike = new Joueur($password, $compte, $nom);
    	$mrCash = new paiementALaBanque();
    	$billet = $mrCash->fairePayer($mike, $montant);
    	
      	include('./affichageFonction.php');
       	break;
    default:
        affiche_erreur("Action inconnue: " . $action);
        break;
}
?>
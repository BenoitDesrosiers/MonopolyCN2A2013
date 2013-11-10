<?php
/* 
 * page de creation/edition des parties par le coordonnateur 
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
    $action = 'ajouter';
} else {
    $action = 'ajouter';
}

$coordonnateur = $_SESSION['usager'];

switch ($action) {
	case 'edit' :	
	    //TODO: pas sure que ca va servir
		$titrePage = "Édition d'une partie";
		$partieFactory = Partie_Factory::singleton();
		$partie = $partieFactory->parId($_GET['partieId']);
		include('./creationPartie_view.php'); // éditer, c'est comme créé avec une partie déjà existante
        break;
    case 'ajouter' :
    	$titrePage= "Création d'une partie";
    	$partie = new Partie(array('coordonnateur'=>$coordonnateur->getCompte()));
    	//TODO: ajouter les autres champs pour la création
      	include('./creationPartie_view.php');
       	break;
    case 'validerEtContinuer' :
        //TODO: pour l'instant je met des valeurs dummy
        $partie = new Partie(array('Nom'=>$_POST['nomPartie'], 'Coordonnateur'=>$coordonnateur->getCompte(), 'DefinitionPartieId'=>"1",'JoueurTour'=>1,'DebutPartie'=>"2050-01-01 12:12:12"));
        try {
            $partie->sauvegarde();
        }
        catch (Exception $e) {
            $msg_erreur = $e->getMessage();
            include("erreurs/db_erreur.php");
            exit;
        }
        include("./afficherPartie_view.php");
        break;
       
    case 'terminer' :
        //TODO terminer une partie
        break;
    default:
        affiche_erreur("Action inconnue: " . $action);
        break;
}
?>
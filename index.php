<?php
/*page principale du site */ 
require_once('util/main.php'); 
require_once('modele/usager.php');
require_once('modele/coordonnateur.php');

// demarre la session, doit être fait après tout les includes
session_start();


//verifie si un usager est connecté
include "util/login.php";


// affiche la page d'acceuil selon le type d'usager
$usager = $_SESSION['usager'];

switch ($usager->getRole()) {
	case 'coordonnateur' :
		include('coordonnateur/acceuil.php');
		break;
	case 'joueur' :
		
		break;

	default:
		display_error("Role inconnue: " . $role);
		break;
}
?>
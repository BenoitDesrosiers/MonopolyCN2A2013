<?php
/*
 * page principale du site 
 * 
 */
 
require_once('util/main.php'); 
require_once('modele/usager.php');

//NOTE: demarre la session, doit être fait après tout les includes
session_start();

//Pour suivre le cheminement, vous n'avez qu'a suivre les commentaires numérotés commencant par
//CONNECTION -> le processus de connection
//LISTEPARTIE -> le processus d'affichage de la liste des parties pour un coordonnateur connecté
//LISTEJOUEUR -> du code qui vous aidera a faire le travail formatif consistant à ajouter une liste des joueurs. 

//verifie si un usager est connecté
//CONNECTION 1.x : cet include est utilisé dans tous les controleurs afin de s'assurer que l'usager est bien connecté
include "util/login.php";


// affiche la page d'acceuil selon le type d'usager
$usager = $_SESSION['usager']; //TODO: ne pas mettre l'usager dans la session, mettre son id et le recréé chaque fois. 

switch ($usager->getRole()) {
	case 'coordonnateur' :
	    //CONNECTION 1.2.5.1 : une fois qu'on s'est connecté, on revient ici
	    //LISTEPARTIE 1.x : après CONNECTION 1.2.5.1 on affiche la page d'acceuil du coordonnateur.
		redirect('ctrl_vue/coordonnateur/');
		break;
	case 'joueur' :
	    //bien que cet usager soit un joueur, il n'a pas rejoins une partie encore. Il est donc un usager.
	    redirect('ctrl_vue/usager/');
		break;

	default:
		display_error("Role inconnue: " . $role);
		break;
}
?>
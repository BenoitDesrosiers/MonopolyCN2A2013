<?php
/* 
 * controlleur pour la page d'acceuil d'un joueur 
 */

if (isset($_POST['action'])) {
	$action=$_POST['action'];
} else if (isset($_GET['action'])) {
	$action=$_GET['action'];
} else {
	$action = 'affiche_tableau';
}

switch ($action) {
	case 'affiche_tableau' :
		// affiche le tableau de jeu
		$joueur = $_SESSION['usager']; 
	    break;
	
	case 'attenteConnectionPartie' :
	    // attente du démarrage de la partie
	        
	    
	    break;
	
	
}
?>
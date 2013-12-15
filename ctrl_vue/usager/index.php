<?php
/* 
 * controlleur pour la page d'acceuil d'un usager (qui n'est pas un coordinateur, et qui n'est pas un joueur encore puisqu'il n'a pas rejoint une partie)
 *  
 */
require_once('../../util/main.php');
require_once('modele/usager.php');
require_once('modele/coordonnateur.php');
require_once('modele/partie.php');


session_start();

//verifie si un usager est connecte
include "util/login.php";

if (isset($_POST['action'])) {
	$action=$_POST['action'];
} else if (isset($_GET['action'])) {
	$action=$_GET['action'];
} else {
    //LISTEPARTIE 1.1 par defaut, on affiche les coordonnateurs et leur parties
	$action = 'liste_parties';
}

$usager = Usager::parCompte($_SESSION['usager']); //pour faire un demo d'un bug, changer usager pour Usager

switch ($action) {
	case 'liste_parties' :
		// liste toutes les parties presentement offertes par les coordonnateurs
        $coordonnateurs = Coordonnateur::tous();
        
		$titrePage = "Accueil Usager";
		include('liste_parties_view.php');
		break;
	case 'joindrePartie' :
	    
	    $partieId = $_POST['joindre']; // l'id de la partie a rejoindre est dans la value du submit 'joindre'

	    $partie = Partie::parId($partieId);
	    if ($partie->joueurPresent($usager) ) {
	        $_SESSION["partieId"]=$partieId;
	        redirect("../../ctrl_vue/partieEnCours");
	    } else {
	        $partie->ajouteJoueur($usager); //fait la demande pour etre ajoute a cette partie. 
	        redirect("../../ctrl_vue/joueur/?action=attenteConnectionPartie&partieId=".$partieId); //l'usager est en attente de devenir un joueur, on le redirige a son ecran d'acceuil.
	    }
	    break;
}
?>
<?php
/* 
 * controlleur pour la page d'acceuil d'un coordonnateur 
 */

require_once('../../util/main.php');
require_once('modele/usager.php');
require_once('modele/coordonnateur.php');
require_once('modele/partie.php');

session_start();

//verifie si un usager est connecté
include "util/login.php";

if (isset($_POST['action'])) {
	$action=$_POST['action'];
} else if (isset($_GET['action'])) {
	$action=$_GET['action'];
} else {
    //LISTEPARTIE 1.1 par défaut, on affiche les parties
	$action = 'liste_parties';
}

switch ($action) {
	case 'liste_parties' :
		// liste toutes les parties appartenant au coordonnateur présentement connecté
		$coordonnateur = $_SESSION['usager']; //LISTEPARTIE 1.2 l'usager a été entreposé dans connectionUsager/index.php à l'étape CONNECTION 1.2.5a
		//LISTEPARTIE 1.3.x on va chercher les parties de ce coordonnateur
		$parties = $coordonnateur->getPartiesEnCours();
		$titrePage = "Accueil Coordonnateur";
		//LISTEPARTIE 1.4.x affiche les parties trouvées
		include('liste_parties_view.php');
		break;
	case 'demarrerPartie' :
		$idPartie = $_POST['Demarrer'];
		$partie = Partie::parId($idPartie);
		$partie->demarrerPartie();
		$titrePage = "Liste joueurs";
		include('joueurs_partie_view.php');
		break;
		
	
	case 'edit' :
		// l'usager veut editer une partie
		// 'edit' contient l'id de la partie a editer
		//TODO: valider que l'id est numerique
		//TODO: valider que la partie appartient bien au coordonnateur
		//TODO: aller chercher la partie correspondant dans l'usager connecte et le mettre dans une var de session pour le recuperer plus tard
		$redirection = "ctrl_vue/partieEdition?action=edit&partieId=" . $_POST['partieId'];
		redirect($redirection);
		break;
	case 'menu' :
	    if (isset($_POST['Ajout'])) {
		    // l'usager veut ajouter une partie
			redirect("../../ctrl_vue/partieEdition?action=ajouter");
	    } elseif (isset($_POST['AfficherTableauTommy'])) {
	        redirect('../../ctrl_vue/affichageTableau/?action=afficherTommy');
	    } elseif (isset($_POST['AfficherTableauVero'])) {
	        redirect('../../ctrl_vue/affichageTableau/?action=afficherVero');
	    } elseif (isset($_POST['AfficherTableauSam'])) {
	        redirect('../../ctrl_vue/affichageTableau/?action=afficherSam');
	    } elseif (isset($_POST['AfficherTableauDavid'])) {
	        redirect('../../ctrl_vue/affichageTableau/?action=afficherDavid');
	    } elseif (isset($_POST['JouerCoup'])) {
			redirect("../../ctrl_vue/affichageTableau?action=jouerCoup");
		} elseif (isset($_POST['AtterirSur'])) {
	        // l'usager veut afficher le tableau de jeu
	        redirect("../../ctrl_vue/affichageTableau?action=atterir");
	    } elseif (isset($_POST['PaiementParBatiment'])) {
	        // l'usager veut afficher le tableau de jeu
	        redirect("../../ctrl_vue/testPaiementParBatiment?action=test");
	    } elseif (isset($_POST['FairePayerJoueur'])) {
	    	redirect("../../ctrl_vue/testFairePayerJoueur?action=essai");
	    }
		break;
}
?>
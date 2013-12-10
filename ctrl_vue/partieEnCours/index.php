<?php
/* 
 * controlleur pour la page permettant a un joueur de jouer   
 */
require_once('../../util/main.php');
require_once('modele/usager.php');
require_once('modele/joueur.php');
require_once('modele/partie.php');

session_start();

if (isset($_POST['action'])) {
	$action=$_POST['action'];
} else if (isset($_GET['action'])) {
	$action=$_GET['action'];
} else {
	$action = 'afficheTableau';
}

$usager = $_SESSION['usager']; //TODO: ne pas mettre l'usager dans la session, mettre son id et le recreer chaque fois.
$partieId = $_SESSION['partieId'];
$partie = Partie::parId($partieId);
$usager = $_SESSION['usager'];
$joueur = Joueur::parComptePartie($usager->getCompte(), $partieId);

switch ($action) {
	case 'afficheTableau' :
		// affiche le tableau de jeu
		$titrePage= $partie->getNom();
		$tableauDeJeu = $partie->getTableau();
		include('./jouer_view.php');
	    break;
	case 'JouerCoup' : 
        $titrePage= "Jouer un coup";
        $tableauDeJeu = $partie->getTableau();
        //TODO: verifier que c'est ˆ ce joueur de jouer. 
        //TODO: ca devrait �tre la partie qui dŽmarre le coup ???
       
        $partie->jouerCoup($joueur);
        
        
            include('./jouer_view.php');
            break;
            
	case 'QuestionPrison' :
		if($_GET['valeur'] == 'payer'){
			$joueur->paye(50);
			$joueur->setToursRestantEnPrison(0);
			$partie->setInteractionId(0);
			$joueur->setEnPrison(0);
			redirect('.?action=JouerCoup');
		}
		elseif ($_GET['valeur'] == 'attendre') {
			$joueur->setToursRestantEnPrison($joueur->getToursRestantEnPrison()-1);
			$partie->setInteractionId(0);
			$partie->genererValeursDes();
			if ($joueur->getToursRestantEnPrison() == 0) {
				$joueur->setEnPrison(0);
			}
			elseif ($partie->desValeursIdentiques() == true) {
				$joueur->setToursRestantEnPrison(0);
				$joueur->setEnPrison(0);
				redirect('.?action=JouerCoup');
			}
			redirect('.?afficheTableau');
		}
		elseif ($_GET['valeur'] == 'carte') {
			//TODO:retirer la carte au joueur
			$joueur->setToursRestantEnPrison(0);
			$partie->setInteractionId(0);
			$joueur->setEnPrison(0);
			redirect('.?action=JouerCoup');
		}
		break;
}
?>
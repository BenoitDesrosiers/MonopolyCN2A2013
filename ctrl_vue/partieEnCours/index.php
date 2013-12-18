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
$joueur = Joueur::parComptePartie($usager->getCompte(), $partieId);



switch ($action) {
	case 'afficheTableau' :
		// affiche le tableau de jeu
		$titrePage= $partie->getNom();
		$tableauDeJeu = $partie->getTableau();
		$partie->setInteractionId(0);
		include('./jouer_view.php');
	    break;    
	case 'JouerCoup' : 
        $titrePage= "Jouer un coup";
        $tableauDeJeu = $partie->getTableau();
        
        //TODO: verifier que c'est a ce joueur de jouer. 
        $partie->jouerCoup($joueur);
	    $partie = Partie::parId($partie->getId()); //FIXME force le reload de la partie juste pour avoir l'interraction. A enlever quand les factories retournerons toujours la meme instance
	    switch ($partie->getInteractionId()) {
	        case 0:
	            //aucune interaction a faire, donc on avance au prochain joueur
	            $partie->avancerTour();
	            break;
	        case INTERACTION_ACHATPROPRIETE:
	            //creation de la case pour pouvoir avoir le nom
	            $caseAchetable = $tableauDeJeu->getCaseParPosition($joueur->getPosition());
	            $texteQuestion = "Voulez-vous achetez la case ". $caseAchetable->getNom(). " au montant de ".$caseAchetable->getPrix()." ?";
	            break;
	        default:
	            //TODO mettre une exception
	    }
	    
	    include('./jouer_view.php');
	    break;
	case 'repondreouinon' :
		if($partie->getInteractionId() == INTERACTION_ACHATPROPRIETE){
			$valeur = $_GET['valeur']; //TODO: valider que ce champ existe
			if ($valeur == 'oui') {
				//Creation de la case pour prendre ses informations.
				$tableauDeJeu = $partie->getTableau();
				$case = $tableauDeJeu->getCaseParPosition($joueur->getPosition());
				//A partir de la case on cree la carte pour que le joueur puisse acheter la carte.
				$carte = CartePropriete::pourCasePartie($case->getId(), $partieId);
				$banque = new banque; // On cree la banque
				$banque->vendrePropriete($joueur, $carte);
			}
			if ($valeur == 'non') {
				$tableauDeJeu = $partie->getTableau();
			}
			
			$partie->setInteractionId(0);
			$partie->avancerTour(); //FIXME: ca devrait etre juste a une place, mais je sais aps ou encore
		}
		include('./jouer_view.php');
		break;
	case 'GenererAchatHotel' :
		$titrePage = "Acheter un hôtel";
		$tableauDeJeu = $partie->getTableau();
		$joueur->genererListeCases();
		include('./achat_hotel_view.php');  //TODO a deplacer dans jouer_view avec une interaction
	    include('./jouer_view.php');
	    break;
	case 'AcheterHotel' :
	    if (isset ($_POST['caseId'])) {
	        $caseId = $_POST['caseId'];
        }
	
		$case = CaseDeJeuAchetable::parId($caseId);
		$titrePage = "Achat d'h&ocirc;tel: " . $case->getNom();
		$tableauDeJeu = $partie->getTableau();
		
		if ($joueur->acheterHotel($caseId) == true) {
			echo "Vous avez acheté un hôtel pour le terrain: " . $case->getNom();
		}
		else {
			echo "Vous n'avez pas assez d'argent pour vous procurer cet h&ocirc;tel."; //TODO: a deplacer dans jouer_view
		}
		
		include('./jouer_view.php');
		$partie->avancerTour(); //FIXME: ca devrait etre juste a une place, mais je sais aps ou encore
		break;
}
?>
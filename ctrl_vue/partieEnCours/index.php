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

//Boucle creant un tableau des joueurs selon leur position. Utilisee pour l'affichage des pions
foreach ($partie->getJoueurs() as $joueurListe) {
	$joueurPos = $joueurListe->getPosition();
	$ar_joueur[$joueurListe->getPosition()]=$joueurListe;
}

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
        //TODO: ca devrait etre la partie qui demarre le coup ??? 
	    $joueur->setPosition(7); //FIXME: a enlever une fois les tests termines
	    $joueur->brasseDes();
	    if($partie->getInteractionId() == INTERACTION_ACHATPROPRIETE){
	    	//creation de la case pour pouvoir avoir le nom.
	    	$caseAchetable = $tableauDeJeu->getCaseParPosition($joueur->getPosition());	
	    	$texteQuestion = "Voulez-vous achetez la case ". $caseAchetable->getNom(). " au montant de ".$caseAchetable->getPrix()." ?";
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
		}
		include('./jouer_view.php');
		
		break;
}
?>
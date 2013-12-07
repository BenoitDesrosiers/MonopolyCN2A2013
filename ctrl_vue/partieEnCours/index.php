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
		$joueur->getPionId();
		$partie->setInteractionId(0);
		//Faire un array[12345678] avec les positions des joueurs.
		
		foreach ($partie->getJoueurs() as $joueurListe) {
			$joueurPos = $joueurListe->getPosition();
			$ar_joueur[$joueurListe->getPosition()]=$joueurListe;
			
			
		}
		// Demander a la partie la liste des joueurs 
		// Demander a chaque joueur sa position
		// positionJoueur[laPosition] = couleur
		include('./jouer_view.php');
		
	    break;
	case 'JouerCoup' : 
        $titrePage= "Jouer un coup";
        $tableauDeJeu = $partie->getTableau();
        echo $joueur->getPosition();
        
        //TODO: verifier que c'est ˆ ce joueur de jouer. 
        //TODO: ca devrait �tre la partie qui dŽmarre le coup ??? 
	    $joueur->setPosition(6); //FIXME: ˆ enlever une fois les tests termines
	    $joueur->brasseDes();
	    if($partie->getInteractionId() == 14){
	    	$caseAchetable = $tableauDeJeu->getCaseParPosition($joueur->getPosition());	
	    	$texteQuestion = "Voulez-vous achetez la case ". $caseAchetable->getNom(). " ?";
	    }
	    include('./jouer_view.php');
	    
	    break;
	case 'repondreouinon' :
		if($partie->getInteractionId() == 14){
			$valeur = $_GET['valeur'];
			if ($valeur == 'oui'){
				$tableauDeJeu = $partie->getTableau();
				$case = $tableauDeJeu->getCaseParPosition($joueur->getPosition());
				$carte = CartePropriete::pourCasePartie($case->getId(), $partieId);
				$banque = new banque;
				$banque->vendrePropriete($joueur, $carte);
				
			}
			$partie->setInteractionId(0);
		}
		include('./jouer_view.php');
		break;

}
?>
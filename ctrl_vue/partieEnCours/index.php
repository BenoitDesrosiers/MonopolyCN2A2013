<?php
/* 
 * controlleur pour la page permettant a un joueur de jouer   
 */
require_once('../../util/main.php');
require_once('modele/usager.php');
require_once('modele/joueur.php');
require_once('modele/partie.php');
require_once('modele/paiementALaBanque.php');

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
		$partie->setInteractionId(0);
		include('./jouer_view.php');
	    break;
	    
	case 'affichePropriete' :
		$carteId=$_GET['carteId'];
		$titrePage= $partie->getNom();
		$tableauDeJeu = $partie->getTableau();
		include('./jouer_view.php');
		break;
		
	case 'JouerCoup' :
		//$carteId=$_GET['carteId'];
        $titrePage= "Jouer un coup";
        $tableauDeJeu = $partie->getTableau();
        //TODO: verifier que c'est ˆ ce joueur de jouer. 
        //TODO: ca devrait �tre la partie qui dŽmarre le coup ??? 
	    $joueur->setPosition(7); //FIXME: ˆ enlever une fois les tests termines
	    $joueur->brasseDes();
	    //$carte = CartePropriete::pourCasePartie($carteId, $partieId);
	    include('./jouer_view.php');
	    break;
	case 'hypothequer':
		$_SESSION['carteId']=$_GET['carteId'];
		$carte = CartePropriete::pourCasePartie($_SESSION['carteId'], $partieId);
		$tableauDeJeu = $partie->getTableau();
		$partie->setInteractionId(12345);
		$nomCarte = $carte->getCaseAssociee()->getNom();
		include('./jouer_view.php');
	    break;
	case 'validerHypothequer':
		$titrePage= "valider Hypotheque";
		$tableauDeJeu = $partie->getTableau();
		$valeurInteraction=$_GET['valeurInteraction'];
		$carte = CartePropriete::pourCasePartie($_SESSION['carteId'], $partieId);
		if($valeurInteraction==1)
		{
			$value = 1;
			$carte->setHypotheque($value);
			$partie->setInteractionId(0);
			$montant = ($carte->getCaseAssociee()->getHypotheque()); 
			$joueur->encaisse($montant);
			include('./jouer_view.php');
		}
		else
		{
			$partie->setInteractionId(0);
			include('./jouer_view.php');
		}	    	
	    break;
	
	case 'racheter':
		$_SESSION['carteId']=$_GET['carteId'];
		$partie->setInteractionId(54321);
		$carte = CartePropriete::pourCasePartie($_SESSION['carteId'], $partieId);
		$nomCarte = $carte->getCaseAssociee()->getNom();
	    $titrePage= "racheter";
	    $tableauDeJeu = $partie->getTableau();
	    include('./jouer_view.php');
	    break;
	    
	case 'validerRacheter':
	    $titrePage= "valider racheter";
	    $tableauDeJeu = $partie->getTableau();
	    $valeurInteraction=$_GET['valeurInteraction'];
	    $carte = CartePropriete::pourCasePartie($_SESSION['carteId'], $partieId);
	    //$carte->setHypotheque(0);
	    if($valeurInteraction==2)
		{
			$value = 0;
			$carte->setHypotheque($value);
			$partie->setInteractionId(0);
			$nomCarte = $carte->getCaseAssociee()->getNom();
			$mrCash = new paiementALaBanque();
			$montant = ($carte->getCaseAssociee()->getPrix())/2; 
			//$joueur->encaisse($montant);
			$billet = $mrCash->fairePayer($joueur, $montant);
			include('./jouer_view.php');
		}
		else
		{
			$partie->setInteractionId(0);
			include('./jouer_view.php');
		}	  
	    break;

}
?>
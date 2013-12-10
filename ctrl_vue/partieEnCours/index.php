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
		$partie->setInteractionID(0);
		include('./jouer_view.php');
	    break;
	case 'JouerCoup' : 
        $titrePage= "Jouer un coup";
        $tableauDeJeu = $partie->getTableau();
        //TODO: verifier que c'est � ce joueur de jouer. 
        //TODO: ca devrait �tre la partie qui d�marre le coup ??? 
	    $joueur->setPosition(6); //FIXME: � enlever une fois les tests termines
	    $joueur->brasseDes();
	    include('./jouer_view.php');
	    break;
    /*---Tommy*/
    case 'questionVtPropriete':
        $titrePage = "AfficheTableau";
        $tableauDeJeu = $partie->getTableau();
        
        $partie->setInteractionID(404);
        
        include('./jouer_view.php');
        break;
    case 'vtPropriete':
        $titrePage= "afficheTableau";
        $tableauDeJeu = $partie->getTableau();
        
        $joueurVt=Joueur::parComptePartie($_POST['joueur'],$partieId);
        $proprieteVt=CartePropriete::pourCasePartie($_POST['propriete'],$partieId);
        
        /* Effectuer la vente */
        $banque=new banque();
        $banque->vendreProprieteJoueur($joueurVt,$joueur,$proprieteVt);
        
        $partie->setInteractionID(0);
        include('./jouer_view.php');
        break;
    /*Tommy---*/
}
?>
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
	case 'menu' :
	    if (isset($_POST['JouerCoup'])) {
	        $titrePage= "Jouer un coup";
	        $tableauDeJeu = $partie->getTableau();
	        //TODO: verifier que c'est � ce joueur de jouer. 
	        //TODO: ca devrait �tre la partie qui d�marre le coup ??? 
		    $joueur->setPosition(1); //FIXME: � enlever une fois les tests termines
		    $joueur->brasseDes();
	        break;
	    }

}
?>
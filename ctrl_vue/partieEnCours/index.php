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

$usager = Usager::parCompte($_SESSION['usager']);
$partieId = $_SESSION['partieId'];
$partie = Partie::parId($partieId);
$usager = Usager::parCompte($_SESSION['usager']);
$joueur = Joueur::parComptePartie($usager->getCompte(), $partieId);

switch ($action) {
	case 'afficheTableau' :
		// affiche le tableau de jeu
		$titrePage= $partie->getNom();
		$tableauDeJeu = $partie->getTableau();
		include('vue/jouer_view.php');
	    break;
	case 'JouerCoup' : 
        $titrePage= "Jouer un coup";
        $tableauDeJeu = $partie->getTableau();
        //TODO: verifier que c'est ˆ ce joueur de jouer. 
        //TODO: ca devrait tre la partie qui dŽmarre le coup ??? 
	    $joueur->setPosition(1); //FIXME: ˆ enlever une fois les tests termines
	    $joueur->brasseDes();
	    include('vue/jouer_view.php');
	    break;

}
?>
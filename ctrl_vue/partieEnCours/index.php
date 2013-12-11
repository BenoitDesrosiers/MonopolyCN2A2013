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

if (isset ($_POST['caseId'])) {
	$caseId = $_POST['caseId'];
}

// $partie->setJoueurTour($joueur->getOrdreDeJeu());

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
        //$tours = $partie->getJoueurTour();
        //echo "<br/>C'est le tour de : " . $tours[0];
	    include('./jouer_view.php');
	    break;
	case 'GenererAchatHotel' :
		$titrePage = "Acheter un hôtel";
		$tableauDeJeu = $partie->getTableau();
		$joueur->genererListeCases();
		include('./achat_hotel_view.php');
	    include('./jouer_view.php');
	    break;
	case 'AcheterHotel' :
		$case = CaseDeJeuAchetable::parId($caseId);
		$titrePage = "Achat d'hotêl: " . $case->getNom();
		$tableauDeJeu = $partie->getTableau();
		
		if ($joueur->acheterHotel($caseId) == true) {
			echo "Vous avez acheté un hôtel pour le terrain: " . $case->getNom();
		}
		else {
			echo "Vous n'avez pas assez d'argent pour vous procurer cet h&ocirc;tel.";
		}
		
		include('./jouer_view.php');
		break;
}
?>
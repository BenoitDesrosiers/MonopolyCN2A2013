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
        //TODO: verifier que c'est Ë† ce joueur de jouer. 
        //TODO: ca devrait ï¿½tre la partie qui dÅ½marre le coup ??? 
	    $joueur->setPosition(6); //FIXME: Ë† enlever une fois les tests termines
	    $joueur->brasseDes();
	    include('./jouer_view.php');
	    break;
	case 'AchatMaison' :
	    	$titrePage= "Acheter Maison(s)";
	    	$tableauDeJeu = $partie->getTableau();
			$partie->setInteractionId(777778);
	    	include('./jouer_view.php');
	    break; 
	case 'AcheterMaison' :
		$validator = true;
		$dejaTraite = array ();
		$proposition = array();
		$propositionId = array ();
		$preproposition = array ();
		$maisonDemandé = 0;
		$nombreTerrainDuGroupe = 0;
 		$Proprietes = $joueur->getProprietesBatissable($partie);
 		foreach ($Proprietes as $case){
 			$maisonDemandé = $_POST['case'.$case->getCaseAssociee()->getId()] + $maisonDemandé;
 		}
 	//	if ($partie->getMaisons() >= $maisonDemandé) {
 			foreach($Proprietes as $case){
 				if ($_POST['case'.$case->getCaseAssociee()->getId()]>=1 && in_array($case->getCaseAssociee()->getGroupeDeCaseId(), $dejaTraite) == false){
 					$nombreTerrainDuGroupe = count($partie->casesDuGroupe($case->getCaseAssociee()->getGroupeDeCaseId()));
 					foreach ($partie->casesDuGroupe($case->getCaseAssociee()->getGroupeDeCaseId()) as $terrain){
 						$proposition[] = $_POST['case'.$terrain->getId()]+$case::pourCasePartie($terrain->getId(), $partie->getId())->getNombreMaisons();
 						$propositionId[] = $terrain->getId();
 						$preproposition[] = $case::pourCasePartie($terrain->getId(), $partie->getId())->getNombreMaisons();
 					}
 					if ($nombreTerrainDuGroupe == 2) {
 						if ($proposition[0] > 4 || $proposition[1] > 4) {
 							$validator = false;
 						}
 						if ($proposition[0] - $proposition[1] < -1 || $proposition[0] - $proposition[1] > 1){
 							$validator = false;
 						}
 					}
 					else {
 						if ($proposition[0] > 4 || $proposition[1] > 4 || $proposition[2] > 4) {
 							$validator = false;
 						}
 						if ($proposition[0] - $proposition[1] < -1 || $proposition[0] - $proposition[1] > 1 || $proposition[0] - $proposition[2] < -1 || $proposition[0] - $proposition[2] > 1 || $proposition[1] - $proposition[2] < -1 || $proposition[1] - $proposition[2] > 1){
 							$validator = false;
 						}
 					}
 					if ($validator == true) {
 						$x = 0;
 						foreach ($propositionId as $Id){
 							$case::pourCasePartie($Id, $partie->getId())->setNombreMaisons($proposition[$x]);
 							$joueur->paye(($proposition[$x]-$preproposition[$x])*$case->getCaseAssociee()->getCoutMaison());
 							$partie->setMaisons($partie->getMaisons()-($proposition[$x]-$preproposition[$x]));
 							$x++;
 						}
 					}
 					$dejaTraite[] = $case->getCaseAssociee()->getGroupeDeCaseId();
 				}
 				$validator = true;
 				$proposition = null;
 				$propositionId = null;
 				$preproposition = null;
 			}
 	//	}

 		//TODO:mettre un message de confirmation ou d'erreur
		$partie->setInteractionId(0);
		$tableauDeJeu = $partie->getTableau();
		include('./jouer_view.php');
		break;
}
?>
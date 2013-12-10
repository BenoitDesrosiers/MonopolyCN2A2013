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
		$validator = true; //flag de validation des conditions d'achats, si vrai, la transaction est valide.
		$dejaTraite = array (); //array contenant les id des groupes de cases déja traité
		$proposition = array(); //array contennant la proposition du joueur pour un groupe de case donné
		$propositionId = array (); //array contenant les identificateurs des cases pour la proposition
		$preproposition = array (); //array contenant l'état des cases avant la proposition
		$maisonDemandé = 0; //contient le nombre de maison désiré par le joueur pour sa transaction
		$nombreTerrainDuGroupe = 0; //contient le nombre de terrain dans un groupe de case
		$facture = 0; //facture pour le joueur pour complèter la transaction
 		$Proprietes = $joueur->getProprietesBatissable($partie);
 		foreach ($Proprietes as $case){
 			$maisonDemandé = $_POST['case'.$case->getCaseAssociee()->getId()] + $maisonDemandé;
 		}
 		// TODO: Ajouter le nombre de maison disponible à la partie, lors de la création de la partie, dans la base de donnée
 	//	if ($partie->getMaisons() >= $maisonDemandé) { 
 			foreach($Proprietes as $case){ //parcours des propriétés batissable du joueur
 				if ($_POST['case'.$case->getCaseAssociee()->getId()]>=1 && in_array($case->getCaseAssociee()->getGroupeDeCaseId(), $dejaTraite) == false){//vérifie si un traitement est demandé sur la case et si ce groupe de case à déja été traité
 					$nombreTerrainDuGroupe = count($partie->casesDuGroupe($case->getCaseAssociee()->getGroupeDeCaseId())); //nombre de terrain appartant à la case à traiter
 					foreach ($partie->casesDuGroupe($case->getCaseAssociee()->getGroupeDeCaseId()) as $terrain){ //parcours les cases du groupe où un traitement est demandé
 						$proposition[] = $_POST['case'.$terrain->getId()]+$case::pourCasePartie($terrain->getId(), $partie->getId())->getNombreMaisons(); //proposition contient la proposition du joueur pour un groupe de cases donné
 						$propositionId[] = $terrain->getId(); //identification des terrains de la proposition
 						$preproposition[] = $case::pourCasePartie($terrain->getId(), $partie->getId())->getNombreMaisons(); //état des cases avant l'application de la proposition
 						if ($case::pourCasePartie($terrain->getId(), $partie->getId())->getNombreHotels() != 0) { //vérifie si les cases ont un hotel.
 							$validator = false;
 						}
 					}
 					if ($nombreTerrainDuGroupe == 2) {
 						if ($proposition[0] > 4 || $proposition[1] > 4) { //vérifie si la proposition contient des cases avec plus de 4 maisons
 							$validator = false;
 						}
 						if ($proposition[0] - $proposition[1] < -1 || $proposition[0] - $proposition[1] > 1){ //vérification de la règle du +1 maison max
 							$validator = false;
 						}
 					}
 					else {
 						if ($proposition[0] > 4 || $proposition[1] > 4 || $proposition[2] > 4) { //vérifie si la proposition contient des cases avec plus de 4 maisons
 							$validator = false;
 						}
 						if ($proposition[0] - $proposition[1] < -1 || $proposition[0] - $proposition[1] > 1 || $proposition[0] - $proposition[2] < -1 || $proposition[0] - $proposition[2] > 1 || $proposition[1] - $proposition[2] < -1 || $proposition[1] - $proposition[2] > 1){ //vérification de la règle du +1 maison max
 							$validator = false;
 						}
 					}
 					if ($validator == true) {
 						$x = 0;
 						foreach ($propositionId as $Id){ //calcul de la facture pour vérification vue que joueur->paye n'indique pas si la transaction échoue
 							$facture = ($proposition[$x]-$preproposition[$x])*$case->getCaseAssociee()->getCoutMaison() + $facture;
 							$x++;
 						}
 						if ($joueur->getArgent() >= $facture) { //TODO:joueur->paye devrait retourner un erreur si le joueur ne peut payer. 
 							$x = 0;
 							foreach ($propositionId as $Id){
 								$case::pourCasePartie($Id, $partie->getId())->setNombreMaisons($proposition[$x]); //mise à jour du nombre de maison de la case
 								$partie->setMaisons($partie->getMaisons()-($proposition[$x]-$preproposition[$x])); //mise à jour du nombre de maison disponible à la partie
 								$x++;
 							}
 							$joueur->paye($facture);
 						}
 					}
 					$dejaTraite[] = $case->getCaseAssociee()->getGroupeDeCaseId(); //ajout du numéro de groupe à l'array dejaTraite dans le but de ne pas traiter plusieurs fois un même groupe
 				}
 				$validator = true;
 				$proposition = null;	//variable de travail réinitialisé avant le prochain tour de boucle
 				$propositionId = null;
 				$preproposition = null;
 				$facture = 0;
 			}
 	//	}

 		//TODO:mettre un message de confirmation ou d'erreur
		$partie->setInteractionId(0);
		$tableauDeJeu = $partie->getTableau();
		include('./jouer_view.php');
		break;
}
?>
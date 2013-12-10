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
        //TODO: verifier que c'est ˆ ce joueur de jouer. 
        //TODO: ca devrait �tre la partie qui dŽmarre le coup ??? 
	    $joueur->setPosition(6); //FIXME: ˆ enlever une fois les tests termines
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
		$dejaTraite = array (); //array contenant les id des groupes de cases d�ja trait�
		$proposition = array(); //array contennant la proposition du joueur pour un groupe de case donn�
		$propositionId = array (); //array contenant les identificateurs des cases pour la proposition
		$preproposition = array (); //array contenant l'�tat des cases avant la proposition
		$maisonDemand� = 0; //contient le nombre de maison d�sir� par le joueur pour sa transaction
		$nombreTerrainDuGroupe = 0; //contient le nombre de terrain dans un groupe de case
		$facture = 0; //facture pour le joueur pour compl�ter la transaction
 		$Proprietes = $joueur->getProprietesBatissable($partie);
 		foreach ($Proprietes as $case){
 			$maisonDemand� = $_POST['case'.$case->getCaseAssociee()->getId()] + $maisonDemand�;
 		}
 		// TODO: Ajouter le nombre de maison disponible � la partie, lors de la cr�ation de la partie, dans la base de donn�e
 	//	if ($partie->getMaisons() >= $maisonDemand�) { 
 			foreach($Proprietes as $case){ //parcours des propri�t�s batissable du joueur
 				if ($_POST['case'.$case->getCaseAssociee()->getId()]>=1 && in_array($case->getCaseAssociee()->getGroupeDeCaseId(), $dejaTraite) == false){//v�rifie si un traitement est demand� sur la case et si ce groupe de case � d�ja �t� trait�
 					$nombreTerrainDuGroupe = count($partie->casesDuGroupe($case->getCaseAssociee()->getGroupeDeCaseId())); //nombre de terrain appartant � la case � traiter
 					foreach ($partie->casesDuGroupe($case->getCaseAssociee()->getGroupeDeCaseId()) as $terrain){ //parcours les cases du groupe o� un traitement est demand�
 						$proposition[] = $_POST['case'.$terrain->getId()]+$case::pourCasePartie($terrain->getId(), $partie->getId())->getNombreMaisons(); //proposition contient la proposition du joueur pour un groupe de cases donn�
 						$propositionId[] = $terrain->getId(); //identification des terrains de la proposition
 						$preproposition[] = $case::pourCasePartie($terrain->getId(), $partie->getId())->getNombreMaisons(); //�tat des cases avant l'application de la proposition
 						if ($case::pourCasePartie($terrain->getId(), $partie->getId())->getNombreHotels() != 0) { //v�rifie si les cases ont un hotel.
 							$validator = false;
 						}
 					}
 					if ($nombreTerrainDuGroupe == 2) {
 						if ($proposition[0] > 4 || $proposition[1] > 4) { //v�rifie si la proposition contient des cases avec plus de 4 maisons
 							$validator = false;
 						}
 						if ($proposition[0] - $proposition[1] < -1 || $proposition[0] - $proposition[1] > 1){ //v�rification de la r�gle du +1 maison max
 							$validator = false;
 						}
 					}
 					else {
 						if ($proposition[0] > 4 || $proposition[1] > 4 || $proposition[2] > 4) { //v�rifie si la proposition contient des cases avec plus de 4 maisons
 							$validator = false;
 						}
 						if ($proposition[0] - $proposition[1] < -1 || $proposition[0] - $proposition[1] > 1 || $proposition[0] - $proposition[2] < -1 || $proposition[0] - $proposition[2] > 1 || $proposition[1] - $proposition[2] < -1 || $proposition[1] - $proposition[2] > 1){ //v�rification de la r�gle du +1 maison max
 							$validator = false;
 						}
 					}
 					if ($validator == true) {
 						$x = 0;
 						foreach ($propositionId as $Id){ //calcul de la facture pour v�rification vue que joueur->paye n'indique pas si la transaction �choue
 							$facture = ($proposition[$x]-$preproposition[$x])*$case->getCaseAssociee()->getCoutMaison() + $facture;
 							$x++;
 						}
 						if ($joueur->getArgent() >= $facture) { //TODO:joueur->paye devrait retourner un erreur si le joueur ne peut payer. 
 							$x = 0;
 							foreach ($propositionId as $Id){
 								$case::pourCasePartie($Id, $partie->getId())->setNombreMaisons($proposition[$x]); //mise � jour du nombre de maison de la case
 								$partie->setMaisons($partie->getMaisons()-($proposition[$x]-$preproposition[$x])); //mise � jour du nombre de maison disponible � la partie
 								$x++;
 							}
 							$joueur->paye($facture);
 						}
 					}
 					$dejaTraite[] = $case->getCaseAssociee()->getGroupeDeCaseId(); //ajout du num�ro de groupe � l'array dejaTraite dans le but de ne pas traiter plusieurs fois un m�me groupe
 				}
 				$validator = true;
 				$proposition = null;	//variable de travail r�initialis� avant le prochain tour de boucle
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
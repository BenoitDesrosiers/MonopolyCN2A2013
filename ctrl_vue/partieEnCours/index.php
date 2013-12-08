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
 		$Proprietes = $joueur->getProprietesBatissable($partie);
 		foreach($Proprietes as $case){
			if ($_POST['case'.$case->getCaseAssociee()->getId()]!=0){
				if ($_POST['case'.$case->getCaseAssociee()->getId()]+$case->getNombreMaisons()<=4) {
					foreach ($partie->casesDuGroupe($case->getCaseAssociee()->getGroupeDeCaseId()) as $terrain){
						if ($case->getCaseId() != $terrain->getId()) {
							if ($_POST['case'.$case->getCaseAssociee()->getId()]+$case->getNombreMaisons() == $_POST['case'.$terrain->getId()]+$case::pourCasePartie($terrain->getId(), $partie->getId())->getNombreMaisons() || $_POST['case'.$case->getCaseAssociee()->getId()]+$case->getNombreMaisons() == $_POST['case'.$terrain->getId()]+$case::pourCasePartie($terrain->getId(), $partie->getId())->getNombreMaisons()+1 || $_POST['case'.$case->getCaseAssociee()->getId()]+$case->getNombreMaisons() == $_POST['case'.$terrain->getId()]+$case::pourCasePartie($terrain->getId(), $partie->getId())->getNombreMaisons()-1) {
								$case->setNombreMaisons($_POST['case'.$case->getCaseAssociee()->getId()]+$case->getNombreMaisons());
								$joueur->paye($terrain::parId($case->getCaseAssociee()->getId())->getCoutMaison()*$_POST['case'.$case->getCaseAssociee()->getId()]);
								//paye est fucké ben raide avec des ECHO dans le modele, da fuk
								//quand paye sera fixé je ferai un check avant de setNombreMaisons
							}
						}
					}
				}
			}
 		}
 		//TODO:mettre un message de confirmation ou d'erreur
		$partie->setInteractionId(0);
		$tableauDeJeu = $partie->getTableau();
		include('./jouer_view.php');
		break;
}
?>
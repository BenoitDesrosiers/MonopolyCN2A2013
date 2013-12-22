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
$joueur = Joueur::parComptePartie($usager->getCompte(), $partieId);



switch ($action) {
	case 'afficheTableau' :
		// affiche le tableau de jeu
		$titrePage= $partie->getNom();
		$tableauDeJeu = $partie->getTableau();
		$partie->setInteractionId(0);
		include('./jouer_view.php');
	    break;    
	case 'JouerCoup' : 
        $titrePage= "Jouer un coup";
        $tableauDeJeu = $partie->getTableau();
        
        //TODO: verifier que c'est a ce joueur de jouer. 
        $partie->jouerCoup($joueur);
	    $partie = Partie::parId($partie->getId()); //FIXME force le reload de la partie juste pour avoir l'interraction. A enlever quand les factories retournerons toujours la meme instance
	    switch ($partie->getInteractionId()) {
	        case 0:
	            //aucune interaction a faire, donc on avance au prochain joueur
	            $partie->avancerTour();
	            break;
	        //un call a $partie->avancerTour() doit etre fait dans tous les call backs des interactions
	        
	        case INTERACTION_ACHATPROPRIETE:
	            //creation de la case pour pouvoir avoir le nom
	            $caseAchetable = $tableauDeJeu->getCaseParPosition($joueur->getPosition());
	            $texteQuestion = "Voulez-vous achetez la case ". $caseAchetable->getNom(). " au montant de ".$caseAchetable->getPrix()." ?";
	            break;
	        default:
	            //TODO mettre une exception
	    }
	    
	    include('./jouer_view.php');
	    break;
	case 'repondreouinon' :
		switch ($partie->getInteractionId()) {
			case INTERACTION_ACHATPROPRIETE:
				$valeur = $_GET['valeur']; //TODO: valider que ce champ existe
				if ($valeur == 'oui') {
					//TODO: envoyer ca dans Joueur->acheterProprieteCourante()
					//Creation de la case pour prendre ses informations. 
					$tableauDeJeu = $partie->getTableau();
					$case = $tableauDeJeu->getCaseParPosition($joueur->getPosition());
					//A partir de la case on cree la carte pour que le joueur puisse acheter la carte.
					$carte = CartePropriete::pourCasePartie($case->getId(), $partieId);
					$banque = new banque; // On cree la banque
					$banque->vendrePropriete($joueur, $carte);
				}
				if ($valeur == 'non') {
					$tableauDeJeu = $partie->getTableau();
				}	
				$partie->avancerTour(); //FIXME: ca devrait etre juste a une place, mais je sais pas ou encore
				break;
			case INTERACTION_HYPOTHEQUER:
				$tableauDeJeu = $partie->getTableau();
				$valeurInteraction=$_GET['valeur'];
				$carte = CartePropriete::pourCasePartie($_SESSION['carteId'], $partieId);
				if($valeurInteraction=='oui') {
					$carte->setHypotheque(1);
					$montant = ($carte->getCaseAssociee()->getHypotheque());
					$joueur->encaisse($montant);
				}
				break;
			case INTERACTION_RACHETER:
				$tableauDeJeu = $partie->getTableau();
				$valeurInteraction=$_GET['valeur'];
				$carte = CartePropriete::pourCasePartie($_SESSION['carteId'], $partieId);
				if($valeurInteraction=="oui") {
					$carte->setHypotheque(0);
					$nomCarte = $carte->getCaseAssociee()->getNom();
					$mrCash = new paiementALaBanque();
					$montant = ($carte->getCaseAssociee()->getPrix())/2;
					$billet = $mrCash->fairePayer($joueur, $montant);
				}
				break;
			}				
		$partie->setInteractionId(0);		
		include('./jouer_view.php');
		break;
	case 'GenererAchatHotel' :
		$titrePage = "Acheter un hôtel";
		$tableauDeJeu = $partie->getTableau();
		$partie->setInteractionId(INTERACTION_ACHATHOTEL);
	    include('./jouer_view.php');
	    break;
	case 'AcheterHotel' :
		$partie->setInteractionId(0);
    	if (isset ($_POST['caseId'])) {
    		$caseId = $_POST['caseId'];
    	}
    
    	$case = CaseDeJeuAchetable::parId($caseId);
    	$titrePage = "Achat d'h&ocirc;tel: " . $case->getNom();
    	$tableauDeJeu = $partie->getTableau();
    
    	if ($joueur->acheterHotel($caseId) == true) {
    		echo "Vous avez acheté un hôtel pour le terrain: " . $case->getNom();
    	}
    	else {
    		echo "Vous n'avez pas assez d'argent pour vous procurer cet h&ocirc;tel."; //TODO: a deplacer dans jouer_view
    	}
    
    	include('./jouer_view.php');
    	$partie->avancerTour(); //FIXME: ca devrait etre juste a une place, mais je sais aps ou encore
    	break;
	case 'AchatMaison' :
    	$titrePage= "Acheter Maison(s)";
    	$tableauDeJeu = $partie->getTableau();
		$partie->setInteractionId(INTERACTION_ACHATMAISON);
    	include('./jouer_view.php');
	    break; 
	case 'AcheterMaison' :
		
		//TODO: déplacer toute cette validation dans cartePropriet: estBatissableMaison($nombreMaison), et ajouter un msg si non batissable 
		$validator = true; //flag de validation des conditions d'achats, si vrai, la transaction est valide.
		$dejaTraite = array (); //array contenant les id des groupes de cases deja traite
		$proposition = array(); //array contennant la proposition du joueur pour un groupe de case donne
		$propositionId = array (); //array contenant les identificateurs des cases pour la proposition
		$preproposition = array (); //array contenant l'etat des cases avant la proposition
		$maisonDemande = 0; //contient le nombre de maison desire par le joueur pour sa transaction
		$nombreTerrainDuGroupe = 0; //contient le nombre de terrain dans un groupe de case
		$facture = 0; //facture pour le joueur pour completer la transaction
 		$Proprietes = $joueur->getProprietesBatissable($partie);
 		foreach ($Proprietes as $case){
 			$maisonDemande = $_POST['case'.$case->getCaseAssociee()->getId()] + $maisonDemande;
 		}
 		// TODO: Ajouter le nombre de maison disponible a la partie, lors de la creation de la partie, dans la base de donnee
 	//	if ($partie->getMaisons() >= $maisonDemande) { 
 			foreach($Proprietes as $case){ //parcours des proprietes batissable du joueur
 				if ($_POST['case'.$case->getCaseAssociee()->getId()]>=1 && in_array($case->getCaseAssociee()->getGroupeDeCaseId(), $dejaTraite) == false){//verifie si un traitement est demande sur la case et si ce groupe de case a deja ete traite
 					$nombreTerrainDuGroupe = count($partie->casesDuGroupe($case->getCaseAssociee()->getGroupeDeCaseId())); //nombre de terrain appartant a la case a traiter
 					foreach ($partie->casesDuGroupe($case->getCaseAssociee()->getGroupeDeCaseId()) as $terrain){ //parcours les cases du groupe ou un traitement est demande
 						$proposition[] = $_POST['case'.$terrain->getId()]+$case::pourCasePartie($terrain->getId(), $partie->getId())->getNombreMaisons(); //proposition contient la proposition du joueur pour un groupe de cases donne
 						$propositionId[] = $terrain->getId(); //identification des terrains de la proposition
 						$preproposition[] = $case::pourCasePartie($terrain->getId(), $partie->getId())->getNombreMaisons(); //etat des cases avant l'application de la proposition
 						if ($case::pourCasePartie($terrain->getId(), $partie->getId())->getNombreHotels() != 0) { //verifie si les cases ont un hotel.
 							$validator = false;
 						}
 					}
 					if ($nombreTerrainDuGroupe == 2) {
 						if ($proposition[0] > 4 || $proposition[1] > 4) { //verifie si la proposition contient des cases avec plus de 4 maisons
 							$validator = false;
 						}
 						if ($proposition[0] - $proposition[1] < -1 || $proposition[0] - $proposition[1] > 1){ //verification de la regle du +1 maison max
 							$validator = false;
 						}
 					}
 					else {
 						if ($proposition[0] > 4 || $proposition[1] > 4 || $proposition[2] > 4) { //verifie si la proposition contient des cases avec plus de 4 maisons
 							$validator = false;
 						}
 						if ($proposition[0] - $proposition[1] < -1 || $proposition[0] - $proposition[1] > 1 || $proposition[0] - $proposition[2] < -1 || $proposition[0] - $proposition[2] > 1 || $proposition[1] - $proposition[2] < -1 || $proposition[1] - $proposition[2] > 1){ //v�rification de la r�gle du +1 maison max
 							$validator = false;
 						}
 					}
 					if ($validator == true) {
 						$x = 0;
 						foreach ($propositionId as $Id){ //calcul de la facture pour verification vue que joueur->paye n'indique pas si la transaction echoue
 							$facture = ($proposition[$x]-$preproposition[$x])*$case->getCaseAssociee()->getCoutMaison() + $facture;
 							$x++;
 						}
 						if ($joueur->getArgent() >= $facture) { //TODO:joueur->paye devrait retourner un erreur si le joueur ne peut payer. 
 							$x = 0;
 							foreach ($propositionId as $Id){
 								$case::pourCasePartie($Id, $partie->getId())->setNombreMaisons($proposition[$x]); //mise a jour du nombre de maison de la case
 								$partie->setMaisons($partie->getMaisons()-($proposition[$x]-$preproposition[$x])); //mise a jour du nombre de maison disponible a la partie
 								$x++;
 							}
 							$joueur->paye($facture);
 						}
 					}
 					$dejaTraite[] = $case->getCaseAssociee()->getGroupeDeCaseId(); //ajout du numero de groupe a l'array dejaTraite dans le but de ne pas traiter plusieurs fois un meme groupe
 				}
 				$validator = true;
 				$proposition = null;	//variable de travail reinitialise avant le prochain tour de boucle
 				$propositionId = null;
 				$preproposition = null;
 				$facture = 0;
 			}
	  	//TODO:mettre un message de confirmation ou d'erreur
 		$partie->setInteractionId(0);
 		$tableauDeJeu = $partie->getTableau();
 		include('./jouer_view.php');
 		break;
 	case 'questionVtPropriete':
 		$titrePage = "AfficheTableau";
 		$tableauDeJeu = $partie->getTableau();
		$partie->setInteractionId(INTERACTION_VENTEPROPRIETE); 		
 		include('./jouer_view.php');
 		break;
 	case 'affichePropriete' :
		$carteId=$_GET['carteId'];
		$titrePage= $partie->getNom();
		$tableauDeJeu = $partie->getTableau();
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
 		
		$partie->setInteractionId(0);
		include('./jouer_view.php');
		break;
	case 'VendreCarteAction' :
		$titrePage= "Vente Carte";
		$tableauDeJeu = $partie->getTableau();
		$partie->setInteractionId(INTERACTION_VENDRECARTEACTION);
		$carteActionId = $_GET['carteActionId'];
		include('./jouer_view.php');
		break;
	case 'VendreCarteS' :
		$titrePage= "Vente Carte";
		$idcarteAction = $_POST['btnSoumettre'];
		$montantVente = $_POST['montantVente'];
		$compteJoueur = $_POST['compteJoueur'];
	
		$joueurVente = Joueur::parComptePartie($compteJoueur, $partie->getId());
	
		try{
			$joueurVente->paye($montantVente);
			$joueur->encaisse($montantVente);
			//TODO Je sais comment changer le propriétaire MAIS Benoit n'aime pas cette façon de faire.
		}
		catch (Exception $e){
			echo $e->getMessage();
		}
		$tableauDeJeu = $partie->getTableau();
		$partie->setInteractionId(0);
		include('./jouer_view.php');
		break;
	case 'hypothequer':
		$_SESSION['carteId']=$_GET['carteId'];
		$carte = CartePropriete::pourCasePartie($_SESSION['carteId'], $partieId);
		$tableauDeJeu = $partie->getTableau();
		$partie->setInteractionId(INTERACTION_HYPOTHEQUER);
		$nomCarte = $carte->getCaseAssociee()->getNom();
		$texteQuestion = "Voulez-vous hypoth&eacute;quer la case ". $nomCarte ." ?";
		include('./jouer_view.php');
		break;
	
	case 'racheter':
		$_SESSION['carteId']=$_GET['carteId'];
		$partie->setInteractionId(INTERACTION_RACHETER);
		$carte = CartePropriete::pourCasePartie($_SESSION['carteId'], $partieId);
		$nomCarte = $carte->getCaseAssociee()->getNom();
		$titrePage= "racheter";
		$tableauDeJeu = $partie->getTableau();
		$texteQuestion = "Voulez-vous racheter la case ". $nomCarte ." ?";
		include('./jouer_view.php');
		break;
	case 'QuestionPrison' :
		if($_GET['valeur'] == 'payer'){
			$joueur->paye(50);
			$joueur->setToursRestantEnPrison(0);
			$partie->setInteractionId(0);
			$joueur->setEnPrison(0);
			redirect('.?action=JouerCoup');
		}
		elseif ($_GET['valeur'] == 'attendre') {
			$joueur->setToursRestantEnPrison($joueur->getToursRestantEnPrison()-1);
			$partie->setInteractionId(0);
			$partie->genererValeursDes();
			if ($joueur->getToursRestantEnPrison() == 0) {
				$joueur->setEnPrison(0);
			}
			elseif ($partie->desValeursIdentiques() == true) {
				$joueur->setToursRestantEnPrison(0);
				$joueur->setEnPrison(0);
				redirect('.?action=JouerCoup');
			} 	
			$partie->avancerTour(); //FIXME: ca devrait etre juste a une place, mais je sais pas ou encore
			redirect('.?afficheTableau');
		}
		elseif ($_GET['valeur'] == 'carte') {
			//TODO:retirer la carte au joueur
			$joueur->setToursRestantEnPrison(0);
			$partie->setInteractionId(0);
			$joueur->setEnPrison(0);
			redirect('.?action=JouerCoup');
		}
		break;
}
?>
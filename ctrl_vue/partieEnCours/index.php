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
        $partie->setInteractionId(0);
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
	case 'VendreCarteAction' : 
        $titrePage= "Vente Carte";
        $tableauDeJeu = $partie->getTableau();
        $partie->setInteractionId(27);
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

}
?>
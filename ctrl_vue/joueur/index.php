<?php
/* 
 * controlleur pour la page d'acceuil d'un joueur  
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
	$action = 'attenteConnectionPartie';
}

$usager = $_SESSION['usager']; //TODO: ne pas mettre l'usager dans la session, mettre son id et le recree chaque fois.

if (isset($_POST['partieId'])) {
    $partieId=$_POST['partieId'];
} else if (isset($_GET['partieId'])) {
    $partieId=$_GET['partieId'];
} //TODO: else faire une erreur

switch ($action) {
	
	case 'attenteConnectionPartie' :
	    // attente du demarrage de la partie
	   
	    $partie = Partie::parId($partieId);
	    if ((isset($_POST['quitter'])) && $_POST['quitter']) {
	        //TODO: quitter la partie veut dire enlever le joueur de la liste des joueurs
	    } else {
            if ($partie->estDemarre()) {
                /* la partie est demarree, on doit donc commencer par choisir les pions. */
                $joueur = Joueur::parComptePartie($usager->getCompte(), $partie->getId());
                $pions = $partie->pionsDisponibles();
                $titrePage = "Choix du pion";
                $msg = "Choisissez un pion";
                include('demandePion_view.php');
            } else {
    	        /* la partie n'est pas demarree, on doit donc attendre */
                $titrePage = "Attente d&eacute;marrage de la partie";
                include('attenteDemarragePartie_view.php');
            }
	    }
	    break;
	case 'demandePion':
	    //le joueur a demande un pion, on check si il est encore dispo et si oui, on lui donne
	    $partie = Partie::parId($partieId);
	    $joueur = Joueur::parComptePartie($usager->getCompte(), $partie->getId());
	    $pions = $partie->pionsDisponibles();
	    $pionDemande = $_POST['pion'];
	    
	    $disponible = false;
	    foreach ($pions as $pion) {    
	        //fait le tour des pions disponible pour voir si celui demande l'est encore
	        if ($pion->getId() == $pionDemande) {
	            $disponible = true;
	        }
	    }
	    if (!$disponible) {
	        // le pion a ete pris par quelqu'un d'autre, on recommence
	        $titrePage = "Choix du pion";
	        $msg = "Votre pion a &eacute;t&eacute; pris, choisissez un autre pion";
	        include('demandePion_view.php');
	    } else {
	        $joueur->setPionId($pionDemande);
	        $_SESSION["partieId"]=$partieId;
	        redirect("../partieEncours");
	    }
	    
	    break;
	
}
?>
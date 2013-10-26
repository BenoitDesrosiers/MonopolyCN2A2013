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

$usager = $_SESSION['usager']; //TODO: ne pas mettre l'usager dans la session, mettre son id et le recréé chaque fois.

switch ($action) {
	case 'affiche_tableau' :
		// affiche le tableau de jeu
		$joueur = $_SESSION['usager']; 
	    break;
	
	case 'attenteConnectionPartie' :
	    // attente du démarrage de la partie
	    $partie = Partie::parId($_GET['partieId']);
        if ($partie->estDemarre()) {
            /* la partie est démarrée, on doit donc commencer par choisir les pions. */
            $joueur = Joueur::parComptePartie($usager->getCompte(), $partieId->getId());
            $titrePage = "Choix du pion";
            include('demandePion_view.php');
        } else 
	        /* la partie n'est pas démarrée, on doit donc attendre */
            $titrePage = "Attente démarrage de la partie";
            include('attenteDemarragePartie_view.php');
	    break;
	
	case 'menu' :
            echo "rendu icitte >>>>>>>>>>";
            // faut boucler tant que la partie démarre pas. 
            // ensuite afficher le tableau et c'est partie mon kiki
	    break;
}
?>
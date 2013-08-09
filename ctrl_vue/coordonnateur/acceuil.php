<?php
/* page d'acceuil pour le coordonnateur */
if (isset($_POST['action'])) {
	$action=$_POST['action'];
} else if (isset($_GET['action'])) {
	$action=$_GET['action'];
} else {
	$action = 'liste_parties';
}

switch ($action) {
	case 'liste_parties' :
		// liste toutes les parties appartenant au coordonnateur présentement connecté
		$coordonnateur = $_SESSION['usager'];
		$parties = $coordonnateur->getPartiesEnCours();
		$titrePage = "Accueil Coordonnateur";
		include('liste_parties_view.php');
		break;
	case 'edit' :
		// l'usager veut editer une partie
		// 'edit' contient l'id de la partie a editer
		//TODO: valider que l'id est numerique
		//TODO: valider que la partie appartient bien au coordonnateur
		//TODO: aller chercher la partie correspondant dans l'usager connecte et le mettre dans une var de session pour le recuperer plus tard
		$redirection = "ctrl_vue/partieEdition?action=edit&partieId=" . $_POST['partieId'];
		redirect($redirection);
		break;
	case 'ajouterPartie' :
		// l'usager veut ajouter un test
			redirect("ctrl_vue/partieEdition?action=ajouter");
		break;
}
?>
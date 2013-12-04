<?php
/* 
 * page d'acceuil pour le coordonnateur 
 */

if (isset($_POST['action'])) {
	$action=$_POST['action'];
} else if (isset($_GET['action'])) {
	$action=$_GET['action'];
} else {
    //LISTEPARTIE 1.1 par defaut, on affiche les parties
	$action = 'liste_parties';
}

switch ($action) {
	case 'liste_parties' :
		// liste toutes les parties appartenant au coordonnateur presentement connecte
		$coordonnateur = Usager::parCompte($_SESSION['usager']); //LISTEPARTIE 1.2 l'usager a ete entrepose dans connectionUsager/index.php a l'etape CONNECTION 1.2.5a
		//LISTEPARTIE 1.3.x on va chercher les parties de ce coordonnateur
		$parties = $coordonnateur->getPartiesEnCours();
		$titrePage = "Accueil Coordonnateur";
		//LISTEPARTIE 1.4.x affiche les parties trouvees
		include('liste_parties_view.php');
		break;
		
	//LISTEJOUEUR 2 : apres avoir ajouter le bouton, vous retournez ici avec une action xyz ... ajouter un case
	//LISTEJOUEUR 3 : etant donne qu'il n'y a pas d'objet en charge de lister les joueurs (ca viendra...) vous pouvez 
	//                simplement mettre le SQL necessaire a la creation (fournit-ci bas) de cette liste directement ici. 
	//                et ensuite ouvrir un page similaire a liste_parties_view.php.
	/*
	    $queryTxt = 'SELECT * FROM Usagers';
	    $db = Database::getDB(); //Je vous laisse trouver quel include utiliser pour faire fonctionner cette ligne
        $query = $db->prepare($queryTxt);
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $query->execute();
        
        $listeUsagers = array(); 
        foreach($query as $row) {
            ////Je vous laisse trouver comment initialiser $compte et $password
            $unItem = Usager::parComptePW($compte, $password); 
            if ($unItem <> null) {
                $listeUsagers[] = $unItem;
            }
        }
	 */
	case 'edit' :
		// l'usager veut editer une partie
		// 'edit' contient l'id de la partie a editer
		//TODO: valider que l'id est numerique
		//TODO: valider que la partie appartient bien au coordonnateur
		//TODO: aller chercher la partie correspondant dans l'usager connecte et le mettre dans une var de session pour le recuperer plus tard
		$redirection = "ctrl_vue/partieEdition?action=edit&partieId=" . $_POST['partieId'];
		redirect($redirection);
		break;
	case 'menu' :
	    if (isset($_POST['Ajout'])) {
		    // l'usager veut ajouter un test
			redirect("ctrl_vue/partieEdition?action=ajouter");
	    } elseif (isset($_POST['AfficherTableau'])) {
	        // l'usager veut afficher le tableau de jeu
	        redirect("ctrl_vue/affichageTableau?action=afficher");
	    } elseif (isset($_POST['EssaiFonction'])) {
	    	redirect("ctrl_vue/essaiBouton?action=essai");
	    }
		break;
}
?>
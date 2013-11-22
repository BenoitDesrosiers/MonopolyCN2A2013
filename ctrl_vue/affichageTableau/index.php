<?php
/* 
 * page affichant le tableau de jeu 
 * 
 */
require_once('../../util/main.php');
require_once('util/secure_conn.php');
require_once('modele/usager.php');
require_once('modele/coordonnateur.php');
require_once('modele/partie.php');
require_once('dataMapper/partieDataMapper.php');
require_once('modele/banque.php');
require_once('modele/caseDeJeu.php');


// demarre la session, doit etre fait apres tout les includes
session_start();

//verifie si un usager est connecte
include "util/login.php";

if (isset($_POST['action'])) {
    $action = $_POST['action'];
} elseif (isset($_GET['action'])) {
    $action = $_GET['action'];
} elseif (isset($_SESSION['user'])) {
    $action = 'afficher';
} else {
    $action = 'afficher';
}

$coordonnateur = $_SESSION['usager'];

switch ($action) {
	
    case 'afficherTommy' :
    	$titrePage= "affichage du tableau de jeu";
    	$partie = Partie::parId('1'); //ceci etant un demo, nous utiliserons la partie #1
    	$tableauDeJeu = $partie->getTableau();
    	
    	for($i=0;$i<40;$i++){
            $cases[$i]=new caseDeJeuAction();
            $cases[$i]->setNom('Case Action');
            $cases[$i]->setId($i);
            $cases[$i]->setPosition($i);
        }
        
        foreach($tableauDeJeu->getCases() as $item){
            $cases[$item->getPosition()]=$item;
        }
        $tableauDeJeu->setCases($cases);
        
        $add = function($i){
            return $i+=1;
        };
        
        $rem = function($i){
            return $i-=1;
        };
        
        $bigger = function($i, $len){
            return ($i>$len);
        };
        
        $smaller = function($i,$len){
            return ($i<$len);
        };
        
        $lignes[0]=array('viewBox'=>'0 0 75 100', 'type'=>'ligne', 'coin'=>true, 'carte'=>'carte', 'start'=>0, 'end'=>11, 'compare'=>$smaller, 'inc'=>$add, 'dec'=>$rem, 'rectW'=>75, 'rectH'=>30, 'rectX'=>0, 'rectY'=>70, 'nomX'=>0, 'nomY'=>2, 'nomTransform'=>'rotate(180 37,30)', 'prixX'=>0, 'prixY'=>47, 'prixTransform'=>'rotate(180 37,30)');
        $lignes[1]=array('viewBox'=>'0 0 100 75', 'type'=>'gauche', 'coin'=>false, 'carte'=>'carte-couchee', 'start'=>39, 'end'=>30, 'compare'=>$bigger, 'inc'=>$rem, 'dec'=>$add, 'rectW'=>30, 'rectH'=>75, 'rectX'=>70, 'rectY'=>0, 'nomX'=>20, 'nomY'=>-28, 'nomTransform'=>'rotate(90 14,15)', 'prixX'=>20, 'prixY'=>15, 'prixTransform'=>'rotate(90 14,15)');
        $lignes[2]=array('viewBox'=>'0 0 100 75', 'type'=>'droite', 'coin'=>false, 'carte'=>'carte-couchee', 'start'=>11, 'end'=>20, 'compare'=>$smaller, 'inc'=>$add, 'dec'=>$rem, 'rectW'=>30, 'rectH'=>75, 'rectX'=>0, 'rectY'=>0, 'nomX'=>0, 'nomY'=>68, 'nomTransform'=>'rotate(-90 24,50)', 'prixX'=>0, 'prixY'=>112, 'prixTransform'=>'rotate(-90 24,50)');
        $lignes[3]=array('viewBox'=>'0 0 75 100', 'type'=>'ligne', 'coin'=>true, 'carte'=>'carte', 'start'=>30, 'end'=>19, 'compare'=>$bigger, 'inc'=>$rem, 'dec'=>$add, 'rectW'=>75, 'rectH'=>30, 'rectX'=>0, 'rectY'=>0, 'nomX'=>0, 'nomY'=>50, 'nomTransform'=>'rotate(0 0,0)', 'prixX'=>0, 'prixY'=>86, 'prixTransform'=>'rotate(0 0,0)');
    	
      	include('./affichageTableau_view_Tommy.php');
       	break;
    case 'afficherVero' :
	    $titrePage= "affichage du tableau de jeu";
    	$partie = Partie::parId('1'); //ceci etant un demo, nous utiliserons la partie #1
    	$tableauDeJeu = $partie->getTableau();
	    include('./affichageTableau_view_0822113.php');
	    break;
    case 'afficherSam' :
        $titrePage= "affichage du tableau de jeu";
        $partie = Partie::parId('1'); //ceci etant un demo, nous utiliserons la partie #1
        $tableauDeJeu = $partie->getTableau();
        include('./affichageTableau_view_Sam.php');
        break;
    case 'afficherDavid' :
        $titrePage= "affichage du tableau de jeu";
        $partie = Partie::parId('1'); //ceci etant un demo, nous utiliserons la partie #1
        $tableauDeJeu = $partie->getTableau();
        include('./affichageTableau_view_David.php');
        break;
    case 'afficherEtienne' :
        $titrePage= "affichage du tableau de jeu";
        $partie = Partie::parId('1'); //ceci etant un demo, nous utiliserons la partie #1
        $tableauDeJeu = $partie->getTableau();
        include('./affichageTableau_view_Etienne.php');
        break;
	case 'jouerCoup' :
		$titrePage= "Jouer un coup";
		$partie = Partie::parId('1');
		$tableauDeJeu = $partie->getTableau();
		
		include('./boutonTableau_controleur.php');
		break;
	case 'atterir' :
		$titrePage= "Atterrir sur une case non achete";
		$partie = Partie::parId('1'); //ceci etant un demo, nous utiliserons la partie #1
		$tableauDeJeu = $partie->getTableau();
		include('./atterirSur_view.php');
		$joueur = Joueur::parComptePartie("benoit", "1");
		$caseDM=new CaseAchetableDataMapper();
		$case=$caseDM->find(array("1"));
		$case->atterrirSur($joueur);
		     
	    break;
    default:
        affiche_erreur("Action inconnue: " . $action);
        break;
}
?>
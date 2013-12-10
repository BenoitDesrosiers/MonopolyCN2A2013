<?php
require_once('../util/main.php');
require_once('modele/usager.php');
require_once('modele/joueur.php');
require_once('modele/partie.php');
require_once ('modele/cartePropriete.php');
require_once ('modele/CaseDeJeu.php');

        
	$partie = Partie::parId($_GET['partie']);
    $cases = array();
    $resultat = array();
    
echo "yolo";
    
    for ($i=1;$i<40;$i++){
    	if (CaseDeJeuPropriete::parId($i)->getType()=="propriete"){
    	$cases[] = CaseDeJeuAchetable::parId($i);
    	}
    }
    
    foreach ($cases as $case){
    	if (CartePropriete::pourCasePartie($case->getId(), $partie->getId())->getCompteProprietaire()==null){
    		$resultat[] = $case;
    	}
    }
        
    foreach ($resultat as $case){
    	echo $case->getNom();
    }
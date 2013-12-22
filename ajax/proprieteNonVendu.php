<?php
require_once('../util/main.php');
require_once('modele/usager.php');
require_once('modele/joueur.php');
require_once('modele/partie.php');
require_once ('modele/cartePropriete.php');
require_once ('modele/caseDeJeuAchetable.php');

        
	$partie = Partie::parId($_GET['partie']);
    $cases = array();
    $resultat = array();
    
    
    for ($i=1;$i<40;$i++){ //crée l'array $cases contenant toutes les cases achetables possibles
    	if (CaseDeJeuPropriete::parId($i)!=null){
    	$cases[] = CaseDeJeuAchetable::parId($i);
    	}
    }
    
    foreach ($cases as $case){ //vérifie à l'intérieur de l'array $cases si la case a un propriétaire, sinon mais dans l'array $resultat
    	if (CartePropriete::pourCasePartie($case->getId(), $partie->getId())->getCompteProprietaire()==null){
    		$resultat[] = $case;
    	}
    }
        
    foreach ($resultat as $case){ //affiche l'array $résultat
    	echo $case->getNom();
    	echo "</br>";
    }
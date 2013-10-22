<?php
require_once "interface/entreposageDatabase.php";
require_once('modele/usager.php');
require_once('modele/caseDeJeu.php');

class banque extends Usager implements EntreposageDatabase {

	//fonctions pour jouer

	public function vendrePropriete($Joueur, $case) {
	  	$Joueur->paye(499);
	  	
	}

}
<?php
require_once('modele/caseDeJeu.php');

class banque  {

	//fonctions pour jouer
/*vero----*/
	static function vendrePropriete($joueur, $case) {
	  	$joueur->paye($case->getPrix());
	  	$case->setProprietaire($joueur);
	}
/*-----vero*/	
}
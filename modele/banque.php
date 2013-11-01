<?php
require_once('modele/caseDeJeu.php');

class banque  {

	//fonctions pour jouer
/*vero----*/
	static function vendrePropriete($joueur, $case) {
		//Vendre une propriété non acheté a un joueur.
	  	$joueur->paye($case->getPrix());
	  	$case->setProprietaire($joueur);
	  	echo $case->getProprietaire()->getNom();
	}
/*-----vero*/	
}
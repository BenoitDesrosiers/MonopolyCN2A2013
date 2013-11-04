<?php
require_once('modele/caseDeJeuAchetable.php');
require_once('modele/joueur.php');
class banque  {

	//fonctions pour jouer
	static function vendrePropriete(Joueur $joueur, CaseDeJeuAchetable $case) {
		//Vendre une propriété non acheté a un joueur.
	  	$joueur->paye($case->getPrix());
	  	$case->setProprietaire($joueur);
	  	echo $case->getProprietairePourPartieId($joueur->getPartieId())->getCompte();
	}
}
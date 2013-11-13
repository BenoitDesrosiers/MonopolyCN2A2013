<?php
require_once('modele/caseDeJeuAchetable.php');
require_once('modele/joueur.php');

class banque  {

	//fonctions pour jouer
	public function vendrePropriete(Joueur $joueur, CaseDeJeuAchetable $case) {
		//Vendre une propriete non achete a un joueur.
	  	$joueur->paye($case->getPrix());
	  	$case->setProprietaire($joueur);
	  	
	  	//TODO: enlever, c'est pour du testing
	  	$nouveauProprietaire = $case->getProprietairePourPartieId($joueur->getPartieId());
	  	echo $nouveauProprietaire->getCompte();
	}
	
	public function fairePayer(Joueur $joueur, $montant) {
	    $joueur->paye($montant);
	    
	}
}
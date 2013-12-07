<?php
require_once('modele/cartePropriete.php');
require_once('modele/joueur.php');

class banque  {

	//fonctions pour jouer
	public function vendrePropriete(Joueur $joueur, CartePropriete $carte) {
		//Vendre une propriete non achete a un joueur.
	  	$joueur->paye($carte->getCaseAssociee()->getPrix());
	  	$carte->setCompteProprietaire($joueur->getCompte());
	  	
	  	//TODO: enlever, c'est pour du testing
	  	$nouveauProprietaire = $carte->getCompteProprietaire();
	  	
	}
	
	public function fairePayer(Joueur $joueur, $montant) {
	    $joueur->paye($montant);
	    
	}
}
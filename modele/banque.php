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
	  	echo $nouveauProprietaire;
	}
	
	public function fairePayer(Joueur $joueur, $montant) {
	    $joueur->paye($montant);
	    
	}
	
	/*---Tommy*/
	public function vendreProprieteJoueur(Joueur $acheteur, Joueur $vendeur, CartePropriete $carte){
        //Vendre une propriete d'un joueur a un autre joueur si celui à assez d'argent.
	  	if($acheteur->tenterAchat($carte->getCaseAssociee()->getPrix())!=false){
            $acheteur->paye($carte->getCaseAssociee()->getPrix());
            $vendeur->encaisse($carte->getCaseAssociee()->getPrix());
            $carte->setCompteProprietaire($acheteur->getCompte());
        }
	  	
    }
    /*Tommy---*/
    
}
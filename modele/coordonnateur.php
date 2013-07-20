<?php
require_once('modele/joueur.php');


class Coordonnateur extends Usager {
	protected $partiesEnCours = array(); // les parties appartenant à ce coordonnateur

	// Setter et Getter
	public function getPartiesEnCours() {  
	    // les parties appartenant à ce coordonnateur
	    if (count($this->partiesEnCours)==0) {
	        //lazy init
	        $partieFactory = Partie_Factory::singleton();
	        $this->setPartiesEnCours($partieFactory->pourCoordonnateur($this->getCompte()));
	    }
	    return $this->partiesEnCours;
	}
	
	public function setPartiesEnCours($value) {  $this->partiesEnCours = $value; }
	
    public function creerPartie() {
        //TODO: à faire
    }
    
    public function demarrePartie() {
        //TODO: à faire
    }
    
    public function arretePartie() {
        //TODO: à faire
    }
    
    public function accepteJoueur() {
        
    }
    
    public function rejetteJoueur() {
        
    }
    
    
	public function getRole() {
		return 'coordonnateur';	
	}


}
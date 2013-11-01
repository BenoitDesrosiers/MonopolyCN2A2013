<?php

require_once "interface/entreposageDatabase.php";

abstract class CaseDeJeu implements EntreposageDatabase {
    protected $id;
    protected $nom;
    protected $position;
    
    // static Factory
    
    public function atterirSur($unJoueur){
    	if($this->getType()=="achetable"){
    		if($this->getProprietaire() != null){
    			//Etienne
    		}
    		else {
    			/*vero---*/
    			if($unJoueur->tenterAchat($this)){
    				banque::vendrePropriete($unJoueur, $this);
    			}
    			/*---vero*/
    		}
    	}
    	else{
    		//tommy
    	}
    }
    
    public function getNom() {
        return $this->Nom;
    }
    public function setNom($value) {
        $this->Nom = $value;
    }
    
    public function getId() {
        return $this->Id;
    }
    public function setId($value) {
        $this->Id = $value;
    }
    public function getPosition() {
        return $this->position;
    }
    public function setPosition($value) {
        $this->position = $value;
    }
    public abstract function getType();
    
}
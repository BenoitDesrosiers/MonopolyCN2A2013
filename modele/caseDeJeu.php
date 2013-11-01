<?php

require_once "interface/entreposageDatabase.php";

abstract class CaseDeJeu implements EntreposageDatabase {
    protected $id;
    protected $nom;
    protected $position;
   
    
    public function atterirSur($joueur){
    	
    	if($this->getType()=="achetable"){
    		
    		if($this->getProprietaire() != null){
    			$this->getProprietaire()->chargerLoyerA($joueur, $this->calculerLoyer($this->getProprietaire()));
    		}
    		else{
    			//code a véro
    		} 
    	}
    	else{
    		//code a tommy
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
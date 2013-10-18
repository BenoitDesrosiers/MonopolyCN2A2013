<?php

require_once "interface/entreposageDatabase.php";

abstract class CaseDeJeu implements EntreposageDatabase {
    protected $id;
    protected $nom;
    protected $position;
    
    // static Factory
    // static abstract  function pourDefinitionPartie($idDefinitionPartie);
    
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
    
    public function atterrirSur($joueur) {
    	echo $this->getNom();
    	echo " est une case de type ";
    	echo $this->getType();
    	echo ".";
    	if ($this->getType() == "achetable") :
    		
    	endif;
    }
    
}
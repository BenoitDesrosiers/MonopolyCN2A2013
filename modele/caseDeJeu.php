<?php

require_once "interface/entreposageDatabase.php";

abstract class CaseDeJeu implements EntreposageDatabase {
    protected $id;
    protected $nom;
    protected $position;
    
    // static Factory
    //static abstract function pourDefinitionPartie($idDefinitionPartie);
    
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
        (is_numeric($value))?$this->Id = $value:0;
    }
    public function getPosition() {
        return $this->position;
    }
    public function setPosition($value) {
        (is_numeric($value))?$this->position = $value:0;
    }
    public abstract function getType();
    
}
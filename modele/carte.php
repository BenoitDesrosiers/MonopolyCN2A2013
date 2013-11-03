<?php

require_once "interface/entreposageDatabase.php";

abstract class Carte implements EntreposageDatabase {
    private $id;
    private $actionID;
    private $typeCarte;
    private $description;
    private $position;
    
    //TODO: ajouter une factory par Id de carte
    
    public function getDescription() {
        return $this->description;
    }
    public function setDescription($value) {
        $this->description = $value;
    }
    
    public function getId() {
        return $this->Id;
    }
    public function setId($value) {
        (is_numeric($value))?$this->id = $value:0;
    }
    
    public function getActionID() {
        return $this->position;
    }
    public function setActionID($value) {
        (is_numeric($value))?$this->actionID = $value:0;
    }
    
    public function setType($value){
        $this->typeCarte=$value;
    }
    
    public function getType(){
        return $this->typeCarte;
    }
    
    public function setPosition($value){
        (is_numeric($value))?$this->position=$value:0;
    }
    
    public function getPositon(){
        return $this->position;
    }
    
    public abstract function execute($joueur);
    
}
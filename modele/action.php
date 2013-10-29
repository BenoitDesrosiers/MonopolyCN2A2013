<?php

require_once "interface/entreposageDatabase.php";

class Action implements EntreposageDatabase {
    private $id;
    private $description;
    
    function getId(){
        return $this->id;
    }
    
    function setId($valeur){
        (is_numeric($valeur))?$this->id=$valeur:0;
    }
    
    function getDescription(){
        return $this->id;
    }
    
    function setDescription($valeur){
        (!empty($valeur))?$this->description=$valeur:0;
    }
    
    abstract function execute();
}
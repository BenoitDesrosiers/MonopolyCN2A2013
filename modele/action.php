<?php
// Par Tommy Teasdale
require_once "interface/entreposageDatabase.php";

abstract class Action{
    protected $id;
    private $description;
    
    function getId(){
        return $this->id;
    }
    
    function setId($valeur){
        $this->id=$valeur;
    }
    
    function getDescription(){
        return $this->id;
    }
    
    function setDescription($valeur){
        (!empty($valeur))?$this->description=$valeur:0;
    }
    
    public abstract function execute($unJoueur);
}
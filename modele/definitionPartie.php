<?php
require_once "interface/entreposageDatabase.php";
require_once "dataMapper/definitionPartieDataMapper.php";
require_once "modele/caseDeJeuAchetable.php";
require_once "modele/caseDeJeuAction.php";


class DefinitionPartie implements EntreposageDatabase {
    protected $id;
    protected $nom;
    protected $description;
    protected $maxNbJoueur;
        

    public function __construct() {
        
    }
    
    // Static Factory
    
    public static function parId($id) {
        $definitionPartieMapper = new DefinitionPartieDataMapper();
        return $definitionPartieMapper->find($id);
    }
    
   
    // interface entreposageDatabase
    public function getDataMapper() {
        return new DefinitionPartieDataMapper();
    }
    
    public function sauvegarde() {
        $this->getDataMapper()->insert($this);
    }
    
    
    //Getters & Setters
    public function getId() {
        return $this->id;
    }
    public function setId($value) {
        $this->id = $value;
    }
    
    public function getNom() {
        return $this->nom;
    }
    public function setNom($value) {
        $this->nom = $value;
    }
    
    public function getMaxNbJoueur() {
        return $this->maxNbJoueur;
    }
    public function setMaxNbJoueur($value) {
        $this->maxNbJoueur = $value;
    }
    
    
    public function getDescription() {
        return $this->description;
    }
    public function setDescription($value) {
        $this->description = $value;
    }
    
    // données provenant d'autres tables
  
    public function getListeCases() {
        // retourne une liste de cases
        $caseAchetables =  CaseDeJeuAchetable::pourDefinitionPartie($this->getId());
        $caseActions = CaseDeJeuAction::pourDefinitionPartie($this->getId());
        //TODO: concaténer les cases achetables et les caseaction
        $cases = array_merge($caseAchetables, $caseActions);
        echo "<br/><br/>Total: ".count($cases)." Achetables: ".count($caseAchetables)." Actions: ".count($caseActions);
        echo " Case: ".$cases[28]->getNom();
        return $cases;
    }
    
}

?>

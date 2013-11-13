<?php
require_once "interface/entreposageDatabase.php";
require_once "dataMapper/definitionPartieDataMapper.php";
require_once "modele/caseDeJeuAchetable.php";
require_once "modele/pion.php";
require_once "modele/caseDeJeuAction.php";

class DefinitionPartie implements EntreposageDatabase {
    protected $id;
    protected $nom;
    protected $description;
    protected $maxNbJoueur;
    protected $definitionArgent = array();
    

    public function __construct() {
        
    }
    
    // Static Factory
    
    public static function parId($id) {
        $definitionPartieMapper = new DefinitionPartieDataMapper();
        return $definitionPartieMapper->find(array($id));
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
    
    public function getArgent(){
    	if (count($this->definitionArgent) == 0){
    		$datamapper = $this->getDataMapper();
    		$this->definitionArgent = $datamapper->selectArgent($this->getId());
    	}
    	return $this->definitionArgent;
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
    
    // donnees provenant d'autres tables
  
    public function getListeCases() {
        // retourne une liste de cases
        $caseAchetables =  CaseDeJeuAchetable::pourDefinitionPartie($this->getId());
        $caseActions = CaseDeJeuAction::pourDefinitionPartie($this->getId());
        $cases = array_merge($caseActions, $caseAchetables);
        return $cases;
    }
    
    public function getPions() {
        // retourne les pions definis pour cette partie
        return Pion::pourDefinitionPartieId($this->getId());
    }
}

?>

<?php

require_once "modele/caseDeJeu.php";
require_once "interface/entreposageDatabase.php";
require_once "dataMapper/caseActionDataMapper.php";
require_once "modele/actionCarte.php";

class CaseDeJeuAction extends CaseDeJeu {
    protected $actionId;
    protected $partieId; // Tommy    
    
    // static Factory
    static function pourDefinitionPartie($idDefinitionPartie) {
        $dataMapper = new CaseActionDataMapper();
        return $dataMapper->pourDefinitionPartie($idDefinitionPartie);
    }
    
    static function parPositionCase($positionCase, $idDefinitionPartie) {
            $dataMapper = new CaseActionDataMapper();
            return $dataMapper->parPositionCase($positionCase, $idDefinitionPartie);
    }
    
    // interface entreposageDatabase
    public function getDataMapper() {
        return new CaseActionDataMapper();
    }
    
    public function sauvegarde() {
        $this->getDataMapper()->insert($this);
    }
     
    
    public function getType() {
        return "action";
    }
    
    //Getters & Setters
    public function getActionID() {
        return $this->actionId;
    }
    public function setActionID($value) {
        (is_numeric($value))?$this->actionId = $value:0;
    }
    
    /*Tommy---*/
    
    // Actions
    public function execute_action(Joueur $joueur){
        switch($this->actionId){
            case 42:
            case 43:
                $xyz = new ActionCarte($this->actionId);
                $xyz->execute($joueur);
                break;
            default:    // Remplacer ceci pour d'autre type d'action
                return 0;
        }
    }
    
    /*---Tommy*/
}
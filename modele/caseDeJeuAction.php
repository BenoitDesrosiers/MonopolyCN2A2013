<?php

require_once "modele/caseDeJeu.php";
require_once "interface/entreposageDatabase.php";
require_once "dataMapper/caseActionDataMapper.php";

class CaseDeJeuAction extends CaseDeJeu {
    protected $actionId;    
    
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
    
    // Actions
    public function execute_action(){
        //$actionMapper = new ActionDataMapper();
        //switch($actionMapper->parActionId($this->ationId, $idDefinitionPartie)->)
    }
}
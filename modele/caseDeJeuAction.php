<?php

require_once "modele/caseDeJeu.php";
require_once "interface/entreposageDatabase.php";
require_once "dataMapper/caseActionDataMapper.php";

class CaseDeJeuAction extends CaseDeJeu {
    protected $image;
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
    
    
    //Getters & Setters
    
    public function getType() {
        return "action";
    }
    
    public function getImage() {
        return $this->Image;
    }
    public function setImage($value) {
        $this->Image = $value;
    }
     
    public function getActionID() {
        return $this->actionId;
    }
    public function setActionID($value) {
        $this->actionId = $value;
    }
    


}


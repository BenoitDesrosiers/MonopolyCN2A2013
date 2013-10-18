<?php

require_once "modele/caseDeJeu.php";
require_once "interface/entreposageDatabase.php";
require_once "dataMapper/caseAchetableDataMapper.php";

class CaseDeJeuAchetable extends CaseDeJeu {
    protected $prix;
    protected $couleur;
    protected $couleurHTML;
      
    
    
    // static Factory
    static function pourDefinitionPartie($idDefinitionPartie) {
        $dataMapper = new CaseAchetableDataMapper();
        return $dataMapper->pourDefinitionPartie($idDefinitionPartie);
    }
    
    // interface entreposageDatabase
    public function getDataMapper() {
        return new CaseAchetableDataMapper();
    }
    
    public function sauvegarde() {
        $this->getDataMapper()->insert($this);
    }
    
   
    
    //Getters & Setters
    public function getCouleur() {
        return $this->Couleur;
    }
    public function setCouleur($value) {
        $this->Couleur = $value;
    }
    
    public function getPrix() {
        return $this->prix;
    }
    public function setPrix($value) {
        $this->prix = $value;
    }
    public function getCouleurHTML() {
        return $this->couleurHTML;
    }
    public function setCouleurHTML($value) {
        $this->couleurHTML = $value;
    }
     
    
    public function getType() {
        return $this->achetable;
    }
    
    /// partie de samuel
    
    public function getProprio(){
    	return $this->JoueurPartieUsagerCompte;
    }
    
    public function setProprio($value){
    	$this->JoueurPartieUsagerCompte = $value;
    }
    
    public function getMaisons(){
    	return $this->NombreMaisons;
    }
    
    public function setMaisons($value){
    	$this->NombreMaisons = $value;
    }
    
    public function getHotels(){
    	return $this->NombreHotels;
    }
    
    public function setHotels($value){
    	$this->NombreHotels = $value;
    }
    
    
    
}
<?php

require_once "modele/caseDeJeu.php";
require_once "interface/entreposageDatabase.php";
require_once "dataMapper/caseAchetableDataMapper.php";

class CaseDeJeuAchetable extends CaseDeJeu {
    protected $prix;
    protected $couleur;
    protected $couleurHTML;
    protected $proprietaire;
    
    // static Factory
    static function pourDefinitionPartie($idDefinitionPartie) {
        $dataMapper = new CaseAchetableDataMapper();
        return $dataMapper->pourDefinitionPartie($idDefinitionPartie);
    }
    
    static function parPositionCase($positionCase, $idDefinitionPartie) {
    	$dataMapper = new CaseAchetableDataMapper();
    	return $dataMapper->parPositionCase($positionCase, $idDefinitionPartie);
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

    public function getProprietairePourPartieId($partieId) {
        return $this->getDataMapper()->getProprietairePourPartieId($this, $partieId);
    }
    
    public function setProprietaire(Joueur $joueur) {
    	$this->proprietaire = $joueur;
    	$this->getDataMapper()->insertProprietaire($joueur, $this);    	
    }
   
    
  
    public function changerProprietaire($Joueur){
    	$this->setProprietaire($Joueur->getCompte());
    }
    public function getType() {
        return $this->achetable;
    }
    
    /// partie de samuel
    
    
    public function getNombreMaison(){
    	return $this->NombreMaisons;
    }
    
    public function setNombreMaison($value){
    	$this->NombreMaisons = $value;
    }
    
    public function getNombreHotel(){
    	return $this->NombreHotels;
    }
    
    public function setNombreHotel($value){
    	$this->NombreHotels = $value;
    }
    
    
    
}
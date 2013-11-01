<?php

require_once "modele/caseDeJeu.php";
require_once "interface/entreposageDatabase.php";
require_once "dataMapper/caseAchetableDataMapper.php";
require_once "modele/caseDeJeuPropriete.php";
require_once "modele/caseDeJeuServicePublic.php";
require_once "modele/caseDeJeuTrain.php";

abstract class CaseDeJeuAchetable extends CaseDeJeu {
    protected $prix;
    protected $couleur;
    protected $couleurHTML;
    
    // ------- variable à Véro
    protected $proprietaire;
      
    public abstract function calculerLoyer();
    
    
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
        return "achetable";
    }
    
    
    /// ------------  partie à Véro
    
	public function getProprietaire() {
            return $this->proprietaire;
    }
    public function setProprietaire($value) {
            $this->proprietaire = $value;
    }
}
<?php

require_once "interface/entreposageDatabase.php";
require_once "dataMapper/caseAchetableDataMapper.php";
require_once "modele/joueur.php";
require_once "modele/caseDeJeu.php";
require_once "modele/caseDeJeuPropriete.php";
require_once "modele/caseDeJeuServicePublic.php";
require_once "modele/caseDeJeuTrain.php";
require_once "modele/cartePropriete.php";

abstract class CaseDeJeuAchetable extends CaseDeJeu {
    protected $prix;
    protected $couleur;
    protected $couleurHTML;
    protected $proprietaire;
      
    public abstract function calculerLoyer();
    
    
    // static Factory
    static function parId($id) {
        $dataMapper = new CaseAchetableDataMapper();
        return $dataMapper->find(array($id));
    }
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
    
    public function atterrirSur(Joueur $unJoueur) {
        $carte = cartePropriete::pourCasePartie($this->getId(), $unJoueur->getPartieId() );
        if($carte->getProprietaire() != null){ //deja un proprietaire = doit payer le loyer 
            $proprio = $this->getProprietairePourPartieId($unJoueur->getPartieId());
            $proprio->chargerLoyerA($joueur, $carte->calculerLoyer());
        } else { //pas de proprietaire = essayer de vendre la propriete
            if($unJoueur->tenterAchat($carte)){
                $banque = new banque;
                $banque->vendrePropriete($unJoueur, $carte);
            }
        }
    }
  
   
    public function getType() {
        return "achetable";
    }
        
    
}
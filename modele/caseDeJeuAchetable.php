<?php

require_once "modele/caseDeJeu.php";
require_once "interface/entreposageDatabase.php";
require_once "dataMapper/caseAchetableDataMapper.php";
require_once "modele/usager.php";

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
    
    public function atterirSur($unJoueur){
    	 if($this->getType()=="achetable"){
    	 	if($this->getProprio() != null){
    	 		
    	 	}
    	 	else {
    	 		$unJoueur->tenterAchat($this);
    	 		
    	 	}
    	 }
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
    public function getProprietaire() {
    	return $this->proprietaire;
    }
    public function setProprietaire($value) {
    	$this->proprietaire = $value;
    }
    public function changerProprietaire($Joueur){
    	$this->setProprietaire($Joueur->getCompte());
  		
    }
    public function getType() {
        return "achetable";
    }

}
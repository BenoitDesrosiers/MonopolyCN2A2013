<?php

require_once "modele/caseDeJeu.php";
require_once "interface/entreposageDatabase.php";
require_once "dataMapper/caseAchetableDataMapper.php";
require_once "modele/joueur.php";

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
        $compte = $this->getDataMapper()->getCompteProprietairePourPartieId($this->getId(), $partieId);
        return Joueur::parComptePartie($compte, $partieId);
    }
    
    public function setProprietaire(Joueur $joueur) {
    	$this->proprietaire = $joueur;
    	$this->getDataMapper()->insertProprietaire($joueur, $this);    	
    }

   /*TODO: obsolete 
    * public function changerProprietaire($Joueur){
    	$this->setProprietaire($Joueur->getCompte());
    }
    */
    
    public function getType() {
        return "achetable";
    }
    
    /// partie de samuel
    
    
    public function getNombreMaisonPourPartieId($partieId){
        return $this->getDataMapper()->getNombreMaisonPourPartieId($this->getId(), $partieId);
    }
    
    /*TODO: faut ajouter le numero de partie
     * 
     public function setNombreMaison($value){
    	$this->NombreMaisons = $value;
    }
    */
    
    public function getNombreHotelPourPartieId($partieId){
        return $this->getDataMapper()->getNombreHotelPourPartieId($this, $partieId);
    }
    
    /*TODO: faut ajouter le numero de partie
    public function setNombreHotel($value){
    	$this->NombreHotels = $value;
    }
    */
    
    
}
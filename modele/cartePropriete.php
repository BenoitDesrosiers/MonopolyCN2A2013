<?php
/*
 * la carte representant une propriete. 
 * C'est elle qui a un proprietaire, des maisons/hotels, et qui peut etre hypotheque. 
 * 
 * 
 */
require_once "interface/entreposageDatabase.php";
require_once "dataMapper/carteProprieteDataMapper.php";
require_once "modele/joueur.php";



class CartePropriete extends objet {
    protected $compteProprietaire;
    protected $nombreMaisons;
    protected $nombreHotels;
    protected $hypotheque;
    protected $partieId;
    protected $caseId;
    protected $ordreAffichage;
    protected $caseAssociee = null; //la caseDeJeuAchetable associŽ a cette carte (hack afin de simplifier les requetes pour les prix associes ˆ cette carte)
 
    function __construct(array $array) {
        /*
         * input
         *     une array associative 
         *     'CompteProprietaire' : le compte du proprietaire
         *     'PartieId' : l'id de la partie a laquelle cette carte est associee
         *     'CaseId' : l'id de la case associŽe
         *     'OrdreAffichage' : l'ordre dans laquelle cette carte est affichee dans la liste pour le joueur
         *     'Hypotheque' : un booleen, 1=propriete hypothequee, 0=non hypothequee
         *     'NombreMaisons' : le nombre de maison sur cette propriete
         *     'NombreHotels' : le nombre d'hotels sur cette propriete
         */
        
        $this->setCompteProprietaire($array['CompteProprietaire']);
        $this->setPartieId($array['PartieId']);
        $this->setCaseId($array['CaseId']);
        $this->setOrdreAffichage($array['OrdreAffichage']);
        $this->setHypotheque($array['Hypotheque']);
        $this->setNombreMaisons($array['NombreMaisons']);
        $this->setNombreHotels($array['NombreHotels']);
        
    }
    
    // static Factory
    static function pourCasePartie($caseId, $partieId) {
        //retourn la carte de la propriete associee a cette case pour cette partie
        
        $dataMapper = new CarteProprieteDataMapper();
        return $dataMapper->find(array($caseId, $partieId));
    }
    
    static function pourJoueurs(Joueur $joueur) {
        $dataMapper = new CarteProprieteDataMapper();
        return $dataMapper->pourJoueur($joueur);
    }
 
    // interface entreposageDatabase
    public function getDataMapper() {
        return new CarteProprieteDataMapper();
    }
    
    public function sauvegarde() {
        $this->getDataMapper()->insert($this);
    }
    
    //Fonctions pour jouer
    
   
    
    //Getters & Setters
    public function getHypotheque() {
        return $this->hypotheque;
    }
    public function setHypotheque($value) {
        $this->hypotheque = $value;
        $this->notifie('hypotheque');
    }
    
    
    public function getNombreHotels() {
        return $this->nombreHotels;
    }
    public function setNombreHotels($value) {
        $this->nombreHotels = $value;
        $this->notifie('nombreHotels');
    }
    
    
    public function getNombreMaisons() {
        return $this->nombreMaisons;
    }
    public function setNombreMaisons($value) {
        $this->nombreMaisons = $value;
        $this->notifie('nomreMaisons');
    }
    
    
    public function getCompteProprietaire() {
        return $this->compteProprietaire;
    }
    public function setCompteProprietaire($value) {
        $this->compteProprietaire = $value;
        $this->notifie('compteProprietaire');
    }
    
    public function getPartieId() {
        return $this->partieId;
    }
    public function setPartieId($value) {
        $this->partieId = $value;
        $this->notifie('partieId');
    }
    
    public function getCaseId() {
        return $this->caseId;
    }
    public function setCaseId($value) {
        $this->caseId = $value;
        $this->notifie('caseID');
    }
    
    public function getCaseAssociee() {
        //cette function est un hack afin de permettre d'accedee a la caseDeJeu associee a cette carte
        //sinon, il faudrait dupliquer toutes les fonctionnalites de caseDeJeu
        if (is_null($this->caseAssociee)) {
            $this->caseAssociee = CaseDeJeuAchetable::parId($this->getCaseId());
        }
        return $this->caseAssociee;
    }
    // pas de setCaseAssociee() car c'est relatif au champ caseId. 
      
    public function getOrdreAffichage() {
        return $this->ordreAffichage;
    }
    public function setOrdreAffichage($value) {
        $this->ordreAffichage = $value;
        $this->notifie('ordreAffichage');
    }
    
}
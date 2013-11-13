<?php
require_once "interface/entreposageDatabase.php";
require_once 'modele/joueur.php';
require_once 'dataMapper/coupureDataMapper.php';
/*
 * represente l'argent d'un joueur, decoupe en coupure et quantite
 */

class Coupure  implements EntreposageDatabase {
   
    protected $valeur;
    protected $quantite;
    protected $joueurId;
    protected $partieId;
        
    
    function __construct(array $array) {
        /*
         * input
         *     un array associative contenant
         *     'Valeur' : le montant de la coupure (un $50, un $10...)
         *     'Quantite' : la quantite de ce billet
         *     'JoueurCompte' : le compte du joueur a qui appartient ces coupures
         *     'PartieId' : l'id de la partie du joueur  
         *     
         */
        $this->valeur = $array['Valeur'];
        $this->quantite = $array['Quantite'];
        $this->joueurId = $array['JoueurCompte'];
        $this->partieId = $array['PartieId'];
    }
    
    // Static Factory
    
    public static function pourJoueur(Joueur $joueur) {
        /*
         * retourne un array contenant simplement les valeurs et quantites des coupures pour un joueurs. 
         * important: ca ne retourne pas des coupures ... seulement les quantite et valeurs. 
         * Cette fonction sera probablement obsolete quand on introduira les vraies objets billets. 
         */
        $mapper = new CoupureDataMapper();
        $coupures = $mapper->ajouteCoupuresA($joueur);
        
        //transforme les objet coupures en array
        $porteFeuille = array();
        foreach($coupures as $coupure) {
            $porteFeuille[$coupure->getValeur()] = $coupure->getQuantite();
        }
        return $porteFeuille;
    }
    
    // interface entreposageDatabase
    public function getDataMapper() {
        return new CoupureDataMapper();
    }
    
    public function sauvegarde() {
        // pour l'instant, on sauvegarde pas les coupures, c'est fait dans Joueur
        //$this->getDataMapper->insert($this);
    }
    
    //Getters & Setters
    public function getPartieId() {
        return $this->partieId;
    }
    public function setPartieId($value) {
        $this->partieId = $value;
    }
    
    public function getJoueurId() {
        return $this->joueurId;
    }
    public function setJoueurId($value) {
        $this->joueurId = $value;
    }
    
    public function getQuantite() {
        return $this->quantite;
    }
    public function setQuantite($value) {
        $this->quantite = $value;
    }
    
    public function getValeur() {
        return $this->valeur;
    }
    public function setValeur($value) {
        $this->valeur = $value;
    }
    
    
}
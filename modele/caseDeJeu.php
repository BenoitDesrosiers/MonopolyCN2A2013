<?php

require_once "interface/entreposageDatabase.php";
require_once "modele/joueur.php";
require_once "modele/banque.php";

abstract class CaseDeJeu { // implements EntreposageDatabase {
    protected $id;
    protected $nom;
    protected $position;
    
    
    function __construct(array $array) {
  
        //$this->setPosition($array["Position"]);
    }
    
    // static Factory
    //static abstract  function pourDefinitionPartie($idDefinitionPartie);
    
    // fonctions de jeu

	abstract public function atterrirSur(Joueur $unJoueur); //TODO: a deplacer dans les sous-classes
    	
    
    // Getter & Setter
    public function getNom() {
        return $this->Nom;
    }
    public function setNom($value) {
        $this->Nom = $value;
    }
    
    public function getId() {
        return $this->Id;
    }
    public function setId($value) {
        $this->Id = $value;
    }
    public function getPosition() {
        return $this->position;
    }
    public function setPosition($value) {
        $this->position = $value;
    }
    public abstract function getType();
   
    public function getCouleurHTML() {
        return "#ffffff"; //TODO: hack pour faire marcher le tableau d'affichage. 
    }
    public function getCouleur() {
        return "blanc"; //TODO: hack pour faire fonctionner le tableau
    }
    public function getPrix() {
        return 0; //TODO: hack pour faire marcher le tableau d'affichage
    }
}
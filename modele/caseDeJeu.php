<?php

require_once "interface/entreposageDatabase.php";

abstract class CaseDeJeu implements EntreposageDatabase {
    protected $id;
    protected $nom;
    protected $position;
    
    // static Factory
    //static abstract  function pourDefinitionPartie($idDefinitionPartie);
    
    // fonctions de jeu
    public function atterrirSur($joueur) {
        echo $this->getNom();
        echo " est une case de type ";
        echo $this->getType();
        echo ".";
        if ($this->getType() == "achetable") :
    
        endif;
    }
    
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
        return "#FFFFFF"; //TODO: hack pour faire marcher le tableau d'affichage. 
    }
    public function getPrix() {
        return 0; //TODO: hack pour faire marcher le tableau d'affichage
    }
}
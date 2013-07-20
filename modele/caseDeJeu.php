<?php

class CaseDeJeu  {
    protected $Id;
    protected $Nom;
    protected $Carte;
        
    public function getCarte() { return $this->Carte;}
    public function setCarte($value) {  $this->Carte = $value; }
        
    public function getNom() { return $this->Nom;}
    public function setNom($value) {  $this->Nom = $value; }
        
    public function getId() { return $this->Id;}
    public function setId($value) {  $this->Id = $value; }
    
    
}
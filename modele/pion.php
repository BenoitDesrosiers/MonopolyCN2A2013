<?php

require_once "dataMapper/PionDataMapper.php";

require_once "interface/entreposageDatabase.php";

class Pion implements EntreposageDatabase {

    protected $Id;
    protected $nom;
    protected $imageUrl;


    function __construct(array $array) {
        $this->Id = $array['Id'];
        $this->nom = $array['Nom'];
        $this->imageUrl = $array['ImageUrl'];
    }

    // Static Factory
    
    public static function pourDefinitionPartieId($definitionId) {
        //retourne les pions associés à une définition de partie
        $mapper = new PionDataMapper();
        return $mapper->findPourDefinitionPartie($definitionId);
    }
   
    // interface entreposageDatabase
    public function getDataMapper() {
        return new PionDataMapper();
    }
    
    public function sauvegarde() {
        $this->getDataMapper->insert($this);
    }
    
    //Getters & Setters
    public function getId() {
        return $this->Id;
    }
    public function setId($value) {
        $this->Id = $value;
    }
    
    public function getNom() {
        return $this->nom;
    }
    public function setNom($value) {
        $this->nom = $value;
    }
    public function getImageUrl() {
        return $this->imageUrl;
    }
    public function setImageUrl($value) {
        $this->imageUrl = $value;
    }

}
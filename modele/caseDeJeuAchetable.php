<?php

require_once "interface/entreposageDatabase.php";
require_once "modele/joueur.php";
require_once "modele/caseDeJeu.php";
require_once "modele/cartePropriete.php";
require_once "dataMapper/caseAchetableDataMapper.php";

abstract class CaseDeJeuAchetable extends CaseDeJeu {
    protected $prix;
    protected $couleur;
    protected $couleurHTML;
    protected $groupeDeCaseId;
    protected $location;
    protected $location1;
    protected $location2;
    protected $location3;
    protected $location4;
    protected $location5;
    protected $coutMaison;
    protected $coutHotel;
    protected $hypotheque;
    protected $URLLogo;
  
    
    
    function __construct(array $array) {
        /*
         * input
        *     un array associative 
        */
        parent::__construct($array);
        $this->setId($array["Id"]);
        $this->setNom($array["Titre"]);
        $this->setPrix($array["Prix"]);
        $this->setNom($array["Titre"]);
        $this->setGroupeDeCaseId($array["GroupeDeCaseId"]);
        $this->setLocation($array["Location"]);
        $this->setLocation1($array["Location1Maison"]);
        $this->setLocation2($array["Location2Maison"]);
        $this->setLocation3($array["Location3Maison"]);
        $this->setLocation4($array["Location4Maison"]);
        $this->setLocation5($array["LocationHotel"]);
        $this->setCoutHotel($array["CoutHotel"]);
        $this->setCoutMaison($array["CoutMaison"]);
        $this->setHypotheque($array["Hypotheque"]);
        $this->setURLLogo($array["URLlogo"]);
         
    }
    
      
    public abstract function calculerLoyer(CartePropriete $propriete);
    
    
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
    
    //Fonctions pour jouer
    public function atterrirSur(Joueur $unJoueur) {
        $carte = CartePropriete::pourCasePartie($this->getId(), $unJoueur->getPartieId() );
        if($carte->getCompteProprietaire() != null){ //deja un proprietaire = doit payer le loyer
            $proprio = Joueur::parComptePartie($carte->getCompteProprietaire(), $unJoueur->getPartieId());
            if ($proprio->getCompte() != $unJoueur->getCompte()) {
                //le joueur a atterit sur une case qui ne lui appartient pas 
                $proprio->chargerLoyerA($unJoueur, $this->calculerLoyer($carte));
                echo $this->calculerLoyer($carte);
            }
        } else { //pas de proprietaire = essayer de vendre la propriete
            if($unJoueur->tenterAchat($carte)){
                $banque = new banque;
                $banque->vendrePropriete($unJoueur, $carte);
            }
        }
    }
    
    
    protected function nombreCartesMemeGroupeEtProprio(CartePropriete $propriete) {
        // retourne le nombre de carte d'un meme groupe appartenant au meme joueur
        $partie = Partie::parId($propriete->getPartieId());
        $casesDuGroupe = $partie->casesDuGroupe($this->getGroupeDeCaseId());
        $proprietaire = $propriete->getCompteProprietaire();
        $partieId= $propriete->getPartieId();
        $memeProprio = 0;
        foreach ($casesDuGroupe as $case) {
            $carte= CartePropriete::pourCasePartie($case->getId(),$partieId);
            if ($carte->getCompteProprietaire() == $proprietaire) {
                $memeProprio++; //compte le nombre de carte ayant le meme proprio
            }
        }
        return $memeProprio;
    }
    
    //Getters & Setters
   
    
    public function getPrix() {
        return $this->prix;
    }
    public function setPrix($value) {
        $this->prix = $value;
    }
    
    
    public function getURLLogo() {
        return $this->URLLogo;
    }
    public function setURLLogo($value) {
        $this->URLLogo = $value;
    }
    
    public function getHypotheque() {
        return $this->hypotheque;
    }
    public function setHypotheque($value) {
        $this->hypotheque = $value;
    }
    
    public function getCoutHotel() {
        return $this->coutHotel;
    }
    public function setCoutHotel($value) {
        $this->coutHotel = $value;
    }
    
    public function getCoutMaison() {
        return $this->coutMaison;
    }
    public function setCoutMaison($value) {
        $this->coutMaison = $value;
    }
    
    
    public function getLocation5() {
        return $this->location5;
    }
    public function setLocation5($value) {
        $this->location5 = $value;
    }
    
    public function getLocation4() {
        return $this->location4;
    }
    public function setLocation4($value) {
        $this->location4 = $value;
    }
    
    public function getLocation3() {
        return $this->location3;
    }
    public function setLocation3($value) {
        $this->location3 = $value;
    }    
    public function getLocation2() {
        return $this->location2;
    }
    public function setLocation2($value) {
        $this->location2 = $value;
    }
    
    public function getLocation1() {
        return $this->location1;
    }
    public function setLocation1($value) {
        $this->location1 = $value;
    }
    
    
    public function getLocation() {
        return $this->location;
    }
    public function setLocation($value) {
        $this->location = $value;
    }
    
    public function getGroupeDeCaseId() {
        return $this->groupeDeCaseId;
    }
    public function setGroupeDeCaseId($value) {
        $this->groupeDeCaseId = $value;
    }
    
    
   

    public function getType() {
        return "achetable";
    }

}
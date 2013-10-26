<?php
require_once "interface/entreposageDatabase.php";
require_once "modele/coordonnateur.php";
require_once "dataMapper/partieDataMapper.php";
require_once "dataMapper/joueurDataMapper.php";
require_once "modele/tableau.php";

class Partie implements EntreposageDatabase {
    protected $id;
    protected $nom;
    protected $coordonnateur;
    protected $definitionPartieId;
    protected $joueurTour;
    protected $debutPartie;
        
    
    
    
    protected $joueurs; // la liste des joueurs (de 1 à 8)
    protected $heureDebut; // l'heure de la création de la partie
    protected $tableau; // le tableau sur lequel se déroule la partie
    protected $banque;
    protected $des;
    protected $cartesChance;
    protected $cartesCaisseCommune;
    protected $pions;
    protected $maisons;  //TODO: est-ce que ca devrait plutot appartenir à la banque
    protected $hotels;

    public function __construct($nom, $compteCoordonnateur) {
        $this->setNom($nom);
        $this->setCoordonnateur($compteCoordonnateur);
        //reset les variables qui sont lazy loaded
        $this->setTableau(Null);
    }
    
    // Static Factory
    
    public static function parId($id) {
        $partieMapper = new PartieDataMapper();
        return $partieMapper->find(array($id));
    }
    
    public static function pourCoordonnateur(Coordonnateur $coordonnateur) {
        /*
         * retourne la liste des parties associées à un coordonnateur
         */
        $partieMapper = new PartieDataMapper();
        //LISTEPARTIES 1.3.1.1.x : cette fonction est une factory. Utilise un datamapper pour extraire la liste des parties pour un coordonnateur.
        return $partieMapper->findPourCoordonnateur($coordonnateur->getCompte());
    }    
    
    // interface entreposageDatabase
    public function getDataMapper() {
        return new PartieDataMapper();
    }
    
    public function sauvegarde() {
        $this->getDataMapper()->insert($this);
    }
    
    // fonction de jeu
    
    public function ajouteJoueur($usager) {
        /*
         * ajoute un usager à la partie
         * l'usager devient donc un joueur
         * 
         * 
         */
        
        //TODO: ajouter le check si jamais ce joueur est déjà dans la partie
        $ordre = 1; //TODO: calculer le vrai ordre d'après les joueurs qui sont déjà dans la table
        
        $joueur = Joueur::nouveauJoueur(array('Compte'=>$usager->getCompte(),
                                    'PartieId'=>$this->getId(),
                                    'PionId'=>0,
                                    'Position'=>0,
                                    'OrdreDeJeu'=>$ordre,
                                    'EnPrison'=>0,
                                    'ToursRestants_Prison'=>0,
                                    'Billets'=>array())); //les billets seront ajoutés quand la partie sera vraiment démarrée
        
    }
    
    public function estDemarre() {
        /*
         * retourne vrai si la partie est démarrée, faux si non
         */
        
        $heureDebut =$this->getHeureDebut();
        return  $heureDebut != 0;
    }
    
    //Getters & Setters
    public function getNom() {
        return $this->nom;
    }
    public function setNom($value) {
        $this->nom = $value;
    }
    
    public function getCoordonnateur() {
        return $this->coordonnateur;
    }
    public function setCoordonnateur($value) {
        $this->coordonnateur = $value;
    }
    
    public function getHotels() {
        return $this->Hotels;
    }
    public function setHotels($value) {
        $this->Hotels = $value;
    }

    public function getMaisons() {
        return $this->Maisons;
    }
    public function setMaisons($value) {
        $this->Maisons = $value;
    }

    public function getPions() {
        return $this->Pions;
    }
    public function setPions($value) {
        $this->Pions = $value;
    }

    public function getCartesCaisseCommune() {
        return $this->cartesCaisseCommune;
    }
    public function setCartesCaisseCommune($value) {
        $this->cartesCaisseCommune = $value;
    }


    public function getCartesChance() {
        return $this->cartesChance;
    }
    public function setCartesChance($value) {
        $this->cartesChance = $value;
    }

    public function getDes() {
        return $this->des;
    }
    public function setDes($value) {
        $this->des = $value;
    }

    public function getBanque() {
        return $this->banque;
    }
    public function setBanque($value) {
        $this->banque = $value;
    }

    public function getHeureDebut() {
        return $this->heureDebut;
    }

    public function setHeureDebut($value) {
        $this->heureDebut = $value;
    }

    public function getJoueurs() {    
        return Joueur::PourPartie($this->getId());
    }
    
    public function setJoueurs($value) {
        $this->joueurs = $value;
    }

    public function getId() {
        return $this->id;
    }
    public function setId($value) {
        $this->id = $value;
    }

    public function getTableau() {
        if ($this->tableau == null) {
            //lazy load
            $this->setTableau(Tableau::pourDefinition($this->getDefinitionPartieId()));
        }    
        return $this->tableau;
    }

    public function setTableau($value) {
        $this->tableau = $value;
    }

    public function getDebutPartie() {
        return $this->debutPartie;
    }
    public function setDebutPartie($value) {
        $this->debutPartie = $value;
    }
    
    public function getJoueurTour() {
        return $this->joueurTour;
    }
    public function setJoueurTour($value) {
        $this->joueurTour = $value;
    }
    
    public function getDefinitionPartieId() {
        return $this->definitionPartieId;
    }
    public function setDefinitionPartieId($value) {
        $this->definitionPartieId = $value;
    }
    
}

?>

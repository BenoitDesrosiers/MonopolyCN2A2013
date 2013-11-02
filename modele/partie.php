<?php
require_once "interface/entreposageDatabase.php";
require_once "modele/coordonnateur.php";
require_once "dataMapper/partieDataMapper.php";
require_once "modele/tableau.php";
require_once "modele/carteChance.php";
require_once "modele/carteCC.php";

class Partie implements EntreposageDatabase {
    protected $id;
    protected $nom;
    protected $coordonnateur;
    protected $definitionPartieId;
    protected $joueurTour;
    protected $debutPartie;
        
    public function getDebutPartie() { return $this->debutPartie;}
    public function setDebutPartie($value) {  $this->debutPartie = $value; }
        
    public function getJoueurTour() { return $this->joueurTour;}
    public function setJoueurTour($value) {  $this->joueurTour = $value; }
        
    public function getDefinitionPartieId() { return $this->definitionPartieId;}
    public function setDefinitionPartieId($value) {  $this->definitionPartieId = $value; }
        
    
    
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
        return $partieMapper->find($id);
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
        return $this->joueurs;
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
    
    /*Tommy--*/
    
    public function getProchaireCarteCC(){
        $cartes=CarteCC::pourDefinitionPartie($this->id);
        $prochaireCarte=CarteCC::pourPositionCarte(1,$this->id);  // Carte au sommet de la pile
        
        if(!$prochaineCarte->getType=="CCg"){
            foreach($cartes as $carte){
                if($carte->getPosition()==1)
                    $carte->setPostion(count($cartes));
                else
                    $carte->setPostion($carte->getPosition()-1);
                $carte->sauvegarder();
            }
        }
        
        return $prochaireCarte;
    }
    
    public function getProchaireCarteChance(){
        $cartes=CarteChance::pourDefinitionPartie($this->id);
        $prochaireCarte=CarteChance::parPositionCarte(14,$this->id);// Pour les besoins de la fonction en cours de développement,
                                                                    // La carte pigée est la carte à la position 14
        /*foreach($cartes as $carte){                               // Les cartes ne sont pas déplacées.
            foreach($cartes as $carte){
                if($carte->getPosition()==count($cartes))
                    $carte->setPostion(1);
                else
                    $carte->setPostion($carte->getPosition()+1);
                $carte->sauvegarder();
            }    
        }*/
        
        return $prochaireCarte;
    }
    
    /*---Tommy*/

}

?>

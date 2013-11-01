<?php
require_once "interface/entreposageDatabase.php";
require_once "modele/coordonnateur.php";
require_once "dataMapper/partieDataMapper.php";
require_once "modele/tableau.php";
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
        
    
    
    protected $joueurs; // la liste des joueurs (de 1 Ã  8)
    protected $heureDebut; // l'heure de la crÃ©ation de la partie
    protected $tableau; // le tableau sur lequel se dÃ©roule la partie
    protected $banque;
    protected $premierDes;
    protected $deuxiemeDes;
    protected $cartesChance;
    protected $cartesCaisseCommune;
    protected $pions;
    protected $maisons;  //TODO: est-ce que ca devrait plutot appartenir Ã  la banque
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
         * retourne la liste des parties associÃ©es Ã  un coordonnateur
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
    
    public function getPremierDes() {
    	return $this->premierDes;
    }
    
    public function setPremierDes($value) {
    	$this->premierDes = $value;
    }
    
    public function getDeuxiemeDes() {
    	return $this->deuxiemeDes;
    }
    
    public function setDeuxiemeDes($value) {
    	$this->deuxiemeDes = $value;
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
	
	//Fonctions autres
	public function jouerCoup($joueur) {
		
	}
	
	public function genererValeursDes() {
		// Génère une valeur aléatoire entre 1 et 6 pour les 2 deux dés
		$this->setPremierDes(rand(1, 6));
		$this->setDeuxiemeDes(rand(1, 6));
	}
	
	public function valeurDes() {
		// Retourne la valeur de la somme des dés
		if (($this->premierDes + $this->deuxiemeDes) >= 2 && ($this->premierDes + $this->deuxiemeDes) <= 12 ) {
			return ($this->premierDes + $this->deuxiemeDes);
		}
		// Sinon, on lance un message d'erreur
		else {
    		echo "ERREUR: La valeur retournee par les des est trop grande/petite ou NULL.";
    	}
	}

}

?>

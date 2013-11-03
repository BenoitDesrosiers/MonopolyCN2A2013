<?php
require_once "interface/entreposageDatabase.php";
require_once "modele/objet.php";
require_once "modele/coordonnateur.php";
require_once "dataMapper/partieDataMapper.php";
require_once "dataMapper/joueurDataMapper.php";
require_once "modele/tableau.php";
require_once "modele/definitionPartie.php";

class Partie extends Objet implements EntreposageDatabase {
    protected $id;
    protected $nom;
    protected $coordonnateur;
    protected $definitionPartieId; //l'id de la definition de partie
    protected $joueurTour;
    protected $debutPartie; //la date et heure du debut de la partie, en tant qu'objet Date
     
    
    
    
    protected $joueurs; // la liste des joueurs (de 1 ˆ 8)
    protected $tableau; // le tableau sur lequel se deroule la partie
    protected $banque;
    protected $des;
    protected $cartesChance;
    protected $cartesCaisseCommune;
    protected $pions;
    protected $maisons;  //TODO: est-ce que ca devrait plutot appartenir a la banque
    protected $hotels;

    protected $definitionPartie = null; //l'objet representant la definition de partie. 
    
    public function __construct(array $array) {
        $this->id = $array["Id"];
        $this->nom = $array["Nom"];
        $this->coordonnateur = $array["Coordonnateur"];
        $this->definitionPartieId = $array["DefinitionPartieId"];
        $this->joueurTour = $array["JoueurTour"];
        $this->debutPartie = DateTime::createFromFormat('Y-m-d h:i:s', $array["DebutPartie"]);
        
    }
    
    // Static Factory
    
    public static function parId($id) {
        $partieMapper = new PartieDataMapper();
        return $partieMapper->find(array($id));
    }
    
    public static function pourCoordonnateur(Coordonnateur $coordonnateur) {
        /*
         * retourne la liste des parties associees a un coordonnateur
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
         * ajoute un usager a la partie
         * l'usager devient donc un joueur
         * 
         * 
         */
        
        //TODO: ajouter le check si jamais ce joueur est deja dans la partie
       
        $ordre = count($this->getJoueurs())+1; //premier arrivee, premier a jouer
        
        $joueur = Joueur::nouveauJoueur(array('UsagerCompte'=>$usager->getCompte(),
                                    'PartieEnCoursId'=>$this->getId(),
                                    'PionId'=>0,
                                    'Position'=>0,
                                    'OrdreDeJeu'=>$ordre,
                                    'EnPrison'=>0,
                                    'ToursRestants_Prison'=>0,
                                    'Billets'=>array())); //les billets seront ajoutes quand la partie sera vraiment demarree
        
    }
    
    public function estDemarre() {
        /*
         * retourne vrai si la partie est demarree, faux si non
         */
        
        $heureDebut =$this->heureDebut();
        return  $heureDebut != 0;
    }
    
    public function pionsDisponibles() {
        $pions = $this->definitionPartie()->getPions();
        foreach($pions as $pion) {
            $pions2[$pion->getId()]=$pion;
        }
        $joueurs = $this->getJoueurs();
        foreach($joueurs as $joueur) {
            if (isset($pions2[$joueur->getPionId()])) {
                unset($pions2[$joueur->getPionId()]); //enleve le pion qu'un joueur a deja pris
            }
        }
        return $pions2;
    }
    
    public function heureDebut() {
    
        return $this->getDebutPartie()->format('H:i');
    }
    
    public function demarrerPartie()
    {
        $id = $this->getDefinitionPartieId();
        $definition = DefinitionPartie::parId($id);
    
        foreach ($this->getJoueurs() as $joueur) :
            $joueur->encaisse($definition->getArgent());
        endforeach;
        
        // set la date de debut de partie au moment present. 
        $this->setDebutPartie(date('Y-m-d g:h:i'));
    }
    
    public function joueurPresent(Usager $usager) {
        /*
         * verifie si un joueur est dŽjˆ dans cette partie
         */
        $joueurs = $this->getJoueurs();
        $present = false;
        foreach ($joueurs as $joueur) {
            if ($joueur->getCompte() == $usager->getCompte()) {
                $present = true;
            }
        }
        return $present;
    }
    
    //Getters & Setters
    public function getNom() {
        return $this->nom;
    }
    public function setNom($value) {
        $this->nom = $value;
        $this->notifie();
    }
    
    public function getCoordonnateur() {
        return $this->coordonnateur;
    }
    public function setCoordonnateur($value) {
        $this->coordonnateur = $value;
        $this->notifie();
    }
    
    public function getHotels() {
        return $this->Hotels;
    }
    public function setHotels($value) {
        $this->Hotels = $value;
        $this->notifie();
    }

    public function getMaisons() {
        return $this->Maisons;
    }
    public function setMaisons($value) {
        $this->Maisons = $value;        
        $this->notifie();
    }

    public function getPions() {
        return $this->Pions;
    }
    public function setPions($value) {
        $this->Pions = $value;
        $this->notifie();
    }

    public function getCartesCaisseCommune() {
        return $this->cartesCaisseCommune;
    }
    public function setCartesCaisseCommune($value) {
        $this->cartesCaisseCommune = $value;
        $this->notifie();
    }


    public function getCartesChance() {
        return $this->cartesChance;
    }
    public function setCartesChance($value) {
        $this->cartesChance = $value;
        $this->notifie();
    }

    public function getDes() {
        return $this->des;
    }
    public function setDes($value) {
        $this->des = $value;
        $this->notifie();
    }

    public function getBanque() {
        return $this->banque;
    }
    public function setBanque($value) {
        $this->banque = $value;
        $this->notifie();
    }

    

    public function getJoueurs() {    
        return Joueur::PourPartie($this->getId());
    }
    
    /*
     * on ne set pas les joueurs, on ajouter 1 joueurs a la fois avec ajouteJoueur()
     * public function setJoueurs($value) {
        $this->joueurs = $value;
    }
    */
    public function getId() {
        return $this->id;
    }
    public function setId($value) {
        $this->id = $value;
        $this->notifie();
    }

    public function getTableau() {
        if ($this->tableau == null) {
            //lazy load
            $this->tableau=Tableau::pourDefinition($this->getDefinitionPartieId());
        }    
        return $this->tableau;
    }

    /*
     *  pas de setTableau puisqu'on va chercher le tableau dans la definition de partie
     */ 
	
	//Fonctions autres
	public function jouerCoup($joueur) {
	}

    public function getDebutPartie() {
        return $this->debutPartie;
    }
    public function setDebutPartie($value) {
        $this->debutPartie = $value;
        $this->notifie();
    }
    
    public function getJoueurTour() {
        return $this->joueurTour;
    }
    public function setJoueurTour($value) {
        $this->joueurTour = $value;
        $this->notifie();
    }
    
    public function getDefinitionPartieId() {
        return $this->definitionPartieId;
    }
    public function setDefinitionPartieId($value) {
        $this->definitionPartieId = $value;
        $this->notifie();
    }
    
    public function definitionPartie() {
        if (is_null($this->definitionPartie)) {
           $this->definitionPartie= DefinitionPartie::parId($this->getDefinitionPartieId());
        }
        return $this->definitionPartie;
    }
    // pas de setter car la definition est charge a partir du Id
    
}

?>

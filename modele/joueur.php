<?php
require_once "interface/entreposageDatabase.php";
require_once('modele/usager.php');
require_once('modele/caseDeJeu.php');

class Joueur extends Usager implements EntreposageDatabase {
    protected $argent; // une array associative contenant le nombre de billets de chaque sortes. 
    protected $partieEnCours;
    protected $pionId;
    protected $position;
    protected $ordreDeJeu;
    protected $enPrison;
    protected $toursRestantEnPrison;
    
    function __construct(array $array) {
        /*
         * input
        *     un array associative contenant le
        *     mot de passe 'MotDePasse',
        *     le compte 'Compte',
        *     le nom 'Nom',
        *     le role 'Role' pour l'usager à créer
        *     
        *     ainsi que les champs pour le joueurs
        *     la partie en cours 'PartieEnCours'
        *     l'id du pion 'PionId'
        *     la position du joueur 'Position'
        *     l'ordre de jeu 'OrdreDeJeu'
        *     un flag indiquant si le joueur est en prison 'EnPrison'
        *     le nombre de tours restant au joueur à passer en prison  'ToursRestant_Prison' 
        *     une liste de billets 'Billets'
        *     
        */
        parent::__construct($array);
        $this->setPartieEnCours($array['PartieEnCours']);
        $this->setPionId($array['PionId']);
        $this->setPosition($array['Position']);
        $this->setOrdreDeJeu($array['OrdreDeJeu']);
        $this->setEnPrison($array['EnPrison']);
        $this->setToursRestantEnPrison($array['ToursRestants_Prison']);
        $this->setArgent($array['Billets']);

    }
    
    // Static Factory
    
    public static function parComptePartie($compte, $partieId) {
        $mapper = new JoueurDataMapper();
        $joueur = $mapper->find(array($compte, $partieId));
        
        return $joueur;
    }
    
    //fonctions pour jouer
	public function brasseDes() {
	    
	}
	
	public function avanceSurCase(CaseDeJeu $uneCase) {
	     
	}
	
	public function encaisse( $billets) {
	    /*input
	     * $billets: un array de billets   coupures et qte
	     */ 
	    $monArgent = $this->getArgent();
        foreach ($billets as $coupure => $qte) {
            $monArgent[$coupure] += $qte;
        }	    
        $this->setArgent($monArgent);
        $this->update(); // update la db
	}
	
	public function paye( $montant) {
	    
	}


	// Getter & Setter
	
	public function getArgent() {
	    return $this->argent;
	}
	public function setArgent($value) {
	    $this->argent = $value;
	}
	
	public function getToursRestantEnPrison() {
	    return $this->toursRestantEnPrison;
	}
	public function setToursRestantEnPrison($value) {
	    $this->toursRestantEnPrison = $value;
	}
	
	public function getEnPrison() {
	    return $this->enPrison;
	}
	public function setEnPrison($value) {
	    $this->enPrison = $value;
	}
	
	
	public function getOrdreDeJeu() {
	    return $this->ordreDeJeu;
	}
	public function setOrdreDeJeu($value) {
	    $this->ordreDeJeu = $value;
	}
	
	public function getPosition() {
	    return $this->position;
	}
	public function setPosition($value) {
	    $this->position = $value;
	}
	
	public function getPionId() {
	    return $this->pionId;
	}
	public function setPionId($value) {
	    $this->pionId = $value;
	}
	
	public function getPartieEnCours() {
	    return $this->partieEnCours;
	}
	public function setPartieEnCours($value) {
	$this->partieEnCours = $value;
	}
	
}
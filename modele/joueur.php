<?php
require_once "interface/entreposageDatabase.php";
require_once('modele/caseDeJeu.php');

/*
 * un joueur n'est pas un usager, un usager est identifié par son compte, un joueur est identifié par son compte et une partie. 
 * un joueur a un usager d'associé
 */
class Joueur  implements EntreposageDatabase {
    
    protected $compte;   
    protected $partieId;
    protected $pionId;
    protected $position;
    protected $ordreDeJeu;
    protected $enPrison;
    protected $toursRestantEnPrison;
    protected $argent; // une array associative contenant le nombre de billets de chaque sortes.
    
    function __construct(array $array) {
        /*
         * input
        *     un array associative contenant le
        *     'Compte' : le compte ,
        *     'PartieId' : l'id de la partie en cours 
        *     'PionId' : l'id du pion 
        *     'Position' : la position du joueur 
        *     'OrdreDeJeu' : l'ordre de jeu 
        *     'EnPrison' : un flag indiquant si le joueur est en prison 
        *     'ToursRestants_Prison' : le nombre de tours restant au joueur à passer en prison   
        *     'Billets' : une liste de billets 
        *     
        */
        $this->setCompte($array['Compte']);
        $this->setPartieId($array['PartieId']);
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
    
    public static function nouveauJoueur(array $array) {
        /*
         * input
        *     un array associative contenant le
        *     'Compte' : le compte ,
        *     'PartieId' : l'id de la partie en cours
        *     'PionId' : l'id du pion
        *     'Position' : la position du joueur
        *     'OrdreDeJeu' : l'ordre de jeu
        *     'EnPrison' : un flag indiquant si le joueur est en prison
        *     'ToursRestants_Prison' : le nombre de tours restant au joueur à passer en prison
        *     'Billets' : une liste de billets
        *
        */
        
        $joueur = new Joueur($array);
        $mapper = new JoueurDataMapper();
        $mapper->insert($joueur);
        return $joueur;
    }
    
    // interface entreposageDatabase
    public function getDataMapper() {
        return new UsagerDataMapper();
    }
    
    public function sauvegarde() {
        $this->getDataMapper->insert($this);
    }
    
    public function update() {
        $this->getDatamapper->update($this);
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
	
	public function getCompte() {
	    return $this->compte;
	}
	public function setCompte($value) {
	    $this->compte = $value;
	}
	
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
	
	public function getPartieId() {
	    return $this->partieId;
	}
	public function setPartieId($value) {
	$this->partieId = $value;
	}
	
}
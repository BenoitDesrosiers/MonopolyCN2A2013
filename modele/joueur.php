<?php
require_once "interface/entreposageDatabase.php";
require_once('modele/usager.php');
require_once('modele/caseDeJeu.php');

class Joueur extends Usager implements EntreposageDatabase {
    
    protected $compte;
    protected $partieEnCoursId;
    protected $password;
    
    public function __construct(array $array) {
            /*Tommy--*/
            // Emulation du Joueur
            $this->compteCompte=$array['UsagerCompte'];
            $this->partieEnCoursId=$array['PartieEnCoursId'];
            /*---Tommy*/
    }
    
    public function getPartieId(){
        return $this->partieEnCoursId;
    }
    
    public function setPartieId($valeur){
        $this->partieEnCoursId=$valeur;
    }
    
    //fonctions pour jouer
	public function brasseDes() {
	    
	}
	
	public function avanceSurCase(CaseDeJeu $uneCase) {
	     
	}
	
	public function encaisse( $montant) {
	    
	}
	
	public function paye( $montant) {
	    
	}
	
	public function getRole() {
	    return 'joueur';
	}
	
}
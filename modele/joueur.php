<?php
require_once "interface/entreposageDatabase.php";
require_once('modele/usager.php');
require_once('modele/caseDeJeu.php');
require_once('dataMapper/joueurDataMapper.php');

class Joueur extends Usager implements EntreposageDatabase {
    protected $UsagerCompte;
    protected $PartieEnCoursId;
    protected $PionId;
    protected $Position;
    protected $OrdreDeJeu;
    protected $EnPrison;
    protected $ToursRestantsPrison;
    protected $argent = array();
    protected $joueursPartieId = array();
    
    public function __construct(array $array) {
    	$this->setUsagerCompte($array['UsagerCompte']);
    	$this->setPartieEnCoursId($array['PartieEnCoursId']);
    	$this->setPionId($array['PionId']);
    	$this->setOrdreDeJeu($array['OrdreDeJeu']);
    	$this->setEnPrison($array['EnPrison']);
    	$this->setToursRestantsPrison($array['ToursRestants_Prison']);
    }
    
	//Static factory
	public static function pourPartie($idPartie){
		$dataMapper = new JoueurDataMapper();
		return $dataMapper->findJoueursPourPartie($idPartie);
	}
	
    //fonctions pour jouer
	public function brasseDes() {
	    
	}
	
	public function avanceSurCase(CaseDeJeu $uneCase) {
	     
	}
	
	public function encaisse( $montant) {
	    $this->joueurArgent = $montant;
	    $mapper = new JoueurDataMapper();
	    $mapper->update($this);
	}
	
	public function paye( $montant) {
	    
	}
	
	public function getRole() {
	    return 'joueur';
	}
	
	//Getters & Setters
	public function getUsagerCompte(){
		return $this->UsagerCompte;
	}
	
	public function setUsagerCompte($value){
		$this->UsagerCompte = $value;
	}

	public function getPartieEnCoursId(){
		return $this->PartieEnCoursId;
	}

	public function setPartieEnCoursId($value){
		$this->PartieEnCoursId = $value;
	}

	public function getPionId(){
		return $this->PionId;
	}

	public function setPionId($value){
		$this->PionId = $value;
	}

	public function getOrdreDeJeu(){
		return $this->OrdreDeJeu;
	}

	public function setOrdreDeJeu($value){
		$this->OrdreDeJeu = $value;
	}

	public function getEnPrison(){
		return $this->EnPrison;
	}

	public function setEnPrison($value){
		$this->EnPrison = $value;
	}

	public function getToursRestantsPrison(){
		return $this->ToursRestantsPrison;
	}

	public function setToursRestantsPrison($value){
		$this->ToursRestantsPrison = $value;
	}
	
	public function getArgent(){
		if(count($this->argent) == 0)
		{
			$dataMapper = new JoueurDataMapper();
			$this->argent = $dataMapper->selectArgent($this);
		}
		return $this->argent;
	}
	
	public function setArgent($array){
		$this->argent = $array;
		
		$dataMapper = new JoueurDataMapper();
		$dataMapper->deleteArgent($this);
		return $dataMapper->ajoutArgent($this);
	}
	
}
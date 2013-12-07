<?php
require_once "dataMapper/caseAchetableDataMapper.php";
require_once "modele/cartePropriete.php";
require_once "modele/caseDeJeuAchetable.php";

class CaseDeJeuPropriete extends CaseDeJeuAchetable {
	
	/* 
	 * obsolete remplacee par cartePropriete
	 *public function setNbrMaison($nombre){
		$this->nbrMaison = $nombre;
	}
	public function getNbrMaison(){
		return $this->nbrMaison;
	}
	public function setNbrHotel($nombre){
		$this->nbrHotel = $nombre;
	}
	public function getNbrHotel(){
		return $this->nbrHotel;
	}
	*/
	function __construct(array $array) {
		/*
		 * input
		*     un array associative
		*/
		parent::__construct($array);
		$this->setCouleur($array["Couleur"]);
		$this->setCouleurHTML($array["CouleurHTML"]);
	}
	public function calculerLoyer(CartePropriete $propriete){
	
	    switch ($propriete->getNombreMaisons()) {
	        case '0' :
	            $montant = $this->getLocation();
	            break;
	        case "1" :
	            $montant = $this->getLocation1();
	            break;	            
	        case "2" :
	            $montant = $this->getLocation2();
	            break;	            
	        case "3" :
	            $montant = $this->getLocation3();
	            break;	            
	        case "4" :
	            $montant = $this->getLocation4();
	            break;	            
	        default: // un hotel = 5 maisons
	            $montant = $this->getLocation5();
	            break;	            
	    }      

		return $montant;
	}
	//Getter & Setter
	public function getCouleur() {
		return $this->Couleur;
	}
	
	public function setCouleur($value) {
		$this->Couleur = $value;
	}
	public function getCouleurHTML() {
		return $this->couleurHTML;
	}
	public function setCouleurHTML($value) {
		$this->couleurHTML = $value;
	}
	
	public function getType() {
		return "propriete";
	}
}
<?php
require_once "dataMapper/caseAchetableDataMapper.php";
require_once "modele/cartePropriete.php";
require_once "modele/caseDeJeuAchetable.php";

class CaseDeJeuPropriete extends CaseDeJeuAchetable {

	public function getNombreMaisonPourPartieId($partieId){
		return $this->getDataMapper()->getNombreMaisonPourPartieId($this->getId(), $partieId);
	}	
	
	public function getNombreHotelPourPartieId($partieId){
		return $this->getDataMapper()->getNombreHotelPourPartieId($this->getId(), $partieId);
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
}
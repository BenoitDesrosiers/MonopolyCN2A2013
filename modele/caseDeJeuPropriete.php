<?php
require_once "modele/caseDeJeuAchetable.php";
require_once "dataMapper/caseAchetableDataMapper.php";

class CaseDeJeuPropriete extends CaseDeJeuAchetable {

	public function getNombreMaisonPourPartieId($partieId){
		return $this->getDataMapper()->getNombreMaisonPourPartieId($this->getId(), $partieId);
	}
	
	/*TODO: faut ajouter le numero de partie
	 
	public function setNombreMaison($value){
		$this->NombreMaisons = $value;
	}*/
	
	
	public function getNombreHotelPourPartieId($partieId){
		return $this->getDataMapper()->getNombreHotelPourPartieId($this->getId(), $partieId);
	}
	
	/*TODO: faut ajouter le numero de partie
	 public function setNombreHotel($value){
	$this->NombreHotels = $value;
	}
	*/
	
	public function calculerLoyer($joueur){
		
		$prix = $this->getDataMapper()->loadPrix($this->getId());
		
		if($this->nbrHotel == 1)
			$montant = $prix['LocationHotel'];
		elseif ($this->getNombreHotelPourPartieId($joueur->getPartieId()) == 4)
			$montant = $prix['Location4Maison'];
		elseif ($this->getNombreMaisonPourPartieId($joueur->getPartieId()) == 3)
			$montant = $prix['Location3Maison'];
		elseif ($this->getNombreMaisonPourPartieId($joueur->getPartieId()) == 2)
			$montant = $prix['Location2Maison'];
		elseif ($this->getNombreMaisonPourPartieId($joueur->getPartieId()) == 1)
			$montant = $prix['Location1Maison'];
		else 
			$montant = $prix['Location'];
		
		return $montant;
	}
}
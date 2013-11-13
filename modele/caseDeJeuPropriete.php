<?php
require_once "modele/caseDeJeuAchetable.php";
require_once "dataMapper/caseAchetableDataMapper.php";
require_once "modele/cartePropriete.php";

class CaseDeJeuPropriete extends CaseDeJeuAchetable {
	protected $nbrMaison;
	protected $nbrHotel;
	
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
	
	public function calculerLoyer(cartePropriete $propriete){
		//array avec lenght pis un if, c pas clean mais ca va marcher
		//comment faire pour les groupes de 2?
		//faut getter le proprio des autres couleurs pareilles
		//a modifier plus tard
		
		/*$listePrix[] = array($query[`Location`],
		 $query[`Location1Maison`],
				$query[`Location2Maison`],
				$query[`Location3Maison`],
				$query[`Location4Maison`],
				$query[`LocationHotel`]);*/
		
		// pourquoi??? $prix = $this->getDataMapper()->loadPrix($this->getId());
	    switch ($propriete->getNombreMaisons())
	    case "1"
	    if($this->nbrHotel == 1)
			$montant = $prix['LocationHotel'];
		elseif ($this->nbrMaison == 4)
			$montant = $prix['Location4Maison'];
		elseif ($this->nbrMaison == 3)
			$montant = $prix['Location3Maison'];
		elseif ($this->nbrMaison == 2)
			$montant = $prix['Location2Maison'];
		elseif ($this->nbrMaison == 1)
			$montant = $prix['Location1Maison'];
		else 
			$montant = $prix['Location'];
		
		return $montant;
	}
}
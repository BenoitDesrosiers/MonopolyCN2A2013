<?php

require_once "modele/caseDeJeuAchetable.php";
require_once "dataMapper/caseAchetableDataMapper.php";

class CaseHabitable extends CaseDeJeuAchetable {
	protected $nbrMaison;
	protected $nbrHotel;
	
	public function setNbrMaison($nombre){
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
	
	public function calculerLoyer(){
		$dataMapper = new CaseAchetableDataMapper();
		
		if($this->nbrHotel == 1){
			return $dataMapper->pourLePrix($this)[5];
		}
		else{
			return $dataMapper->pourLePrix($this)[$this->nbrMaison];
		}
	}
}
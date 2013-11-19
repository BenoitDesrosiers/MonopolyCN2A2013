<?php
require_once "modele/caseDeJeuAchetable.php";
require_once "datamapper/caseAchetableDataMapper.php";

class CaseDeJeuTrain extends CaseDeJeuAchetable {
	public function calculerLoyer($joueur){
		$compteur = 0;
		foreach ($this->getDataMapper()->pourDefinitionPartie($joueur->getPartieId()) as $case) :
		if($case->getCouleur() == "service")
		if($this->getProprietairePourPartieId($joueur->getPartieId()) == $case->getProprietairePourPartieId($joueur->getPartieId()))
			$compteur++;
		endforeach;
		return (50*$compteur);
	}
}
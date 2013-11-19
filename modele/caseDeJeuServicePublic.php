<?php
require_once "modele/caseDeJeuAchetable.php";

class CaseDeJeuServicePublic extends CaseDeJeuAchetable {
	public function calculerLoyer($joueur){
		$compteur = 0;
		foreach ($this->getDataMapper()->pourDefinitionPartie($joueur->getPartieId()) as $case) :
			if($case->getCouleur() == "service")
				if($this->getProprietairePourPartieId($joueur->getPartieId()) == $case->getProprietairePourPartieId($joueur->getPartieId()))
					$compteur++;
		endforeach;
		if($compteur == 2){
			return (10*Joueur::brasseDes());
		}
		else{
			return (4*Joueur::brasseDes());
		}
	}
}
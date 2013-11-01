<?php
require_once "modele/caseDeJeuAchetable.php";

class CaseDeJeuServicePublic extends CaseDeJeuAchetable {
	public function calculerLoyer(){
		//a modifier plus tard
		//[1]==avec un terain
		//[2]==avec le second
		$compteur = 0;
		foreach ($tableauDeJeu->getCases() as $case) :
			if($case->getCouleur == "service")
				if($this->getProprio == $case->getProprio)
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
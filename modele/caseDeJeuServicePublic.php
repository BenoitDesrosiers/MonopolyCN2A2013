<?php
require_once "modele/caseDeJeuAchetable.php";
require_once "modele/casePropriete.php";
require_once "modele/cartePropriete.php";

class CaseDeJeuServicePublic extends CaseDeJeuAchetable {
	public function calculerLoyer(CartePropriete $propriete) {
        //verifie si le proprietaire de cette carte a l'autre carte de service
        $carteService = CartePropriete::cartesDuGroupePourPartie($this->getGroupeDeCaseId(), $propriete->getPartieId());
        
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
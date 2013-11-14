<?php
require_once "modele/caseDeJeuAchetable.php";
require_once "modele/casePropriete.php";

class CaseDeJeuTrain extends CaseDeJeuAchetable {
	public function calculerLoyer(CartePropriete $propriete) {
		$compteur = 0;
		foreach ($tableauDeJeu->getCases() as $case) : //FIXME: tableauDeJeu??? ca existe pas ici
		if($case->getCouleur == "service")
		if($this->getProprio == $case->getProprio)
			$compteur++;
		endforeach;
		return (50*$compteur);
	}
}
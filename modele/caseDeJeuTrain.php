<?php
require_once "modele/caseDeJeuAchetable.php";
require_once "modele/cartePropriete.php";

class CaseDeJeuTrain extends CaseDeJeuAchetable {
	public function calculerLoyer(CartePropriete $propriete) {
		$nombreCartesMemeProprio = $this->nombreCartesMemeGroupeEtProprio($propriete);
	    
		return (50*$nombreCartesMemeProprio);
	}
}
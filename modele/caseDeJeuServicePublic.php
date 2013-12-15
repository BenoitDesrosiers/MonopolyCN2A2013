<?php
require_once "modele/caseDeJeuAchetable.php";
require_once "modele/cartePropriete.php";
require_once "modele/partie.php";

class CaseDeJeuServicePublic extends CaseDeJeuAchetable {
	public function calculerLoyer(CartePropriete $propriete) {
        //verifie si le proprietaire de cette carte a l'autre carte de service
        $nombreCartesMemeProprio = $this->nombreCartesMemeGroupeEtProprio($propriete);
        
		if($memeProprio == 2){
			return (10*Joueur::brasseDes());
		}
		else{
			return (4*Joueur::brasseDes());
		}
	}

	public function getType() {
		return "ServicePublic";
	}
}
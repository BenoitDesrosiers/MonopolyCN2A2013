<?php
require_once "modele/caseDeJeuAchetable.php";
require_once "modele/cartePropriete.php";
require_once "modele/partie.php";

class CaseDeJeuServicePublic extends CaseDeJeuAchetable {
	public function calculerLoyer(CartePropriete $propriete) {
        //verifie si le proprietaire de cette carte a l'autre carte de service
        $nombreCartesMemeProprio = $this->nombreCartesMemeGroupeEtProprio($propriete);
        $partie = Partie::parId($propriete->getPartieId());
        $partie->genererValeursDes();
        
        if($nombreCartesMemeProprio == 2){
        	return (10*($partie->getPremierDes() + $partie->getDeuxiemeDes()));
        }
        else{
        	return (4*($partie->getPremierDes() + $partie->getDeuxiemeDes()));
        }
	}

	public function getType() {
		return "ServicePublic";
	}
}
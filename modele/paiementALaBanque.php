<?php

require_once "modele/paiement.php";
require_once "modele/joueur.php";


class paiementALaBanque extends paiement {

 public static function  fairePayer($joueur, $montant)    
 {
 	$banque = new banque();
 	$banque->paye($joueur, $montant);
 } 
 
}
<?php

require_once "modele/joueur.php";
require_once "modele/banque.php";


class paiementALaBanque {

 public static function  fairePayer($joueur, $montant)    
 {
 	$banque = new banque();
 	$billet=$banque->paye($joueur, $montant);
 	return $billet;
 } 
 
}
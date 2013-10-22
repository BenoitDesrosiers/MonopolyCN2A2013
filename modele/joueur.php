<?php
require_once "interface/entreposageDatabase.php";
require_once('modele/usager.php');
require_once('modele/caseDeJeu.php');

class Joueur extends Usager implements EntreposageDatabase {
    
    //fonctions pour jouer
	public function brasseDes() {
	    
	}
	
	public function avanceSurCase(CaseDeJeu $uneCase) {
	     
	}
	
	public function encaisse($montant) {
	    
	}
	
	public function paye( $montant) {
		
		$billet = array(0,0,0,0,0,0,0);
		
		$billetJoueur = getListeBillet();
//calcul nombre de 500
		if($billetJoueur[6]>0)
		{
		if($montant >=500)
		{
		$montantReste = $montant%500;
		$montant=$montant - $montantReste;
		$billet[6]=$montant/500;
		}
		}
		else
			$billet[6]=0;
//calcul nombre de 100		
		$montant = $montantReste;
		if($billetJoueur[5]>0)
		{
		if($montant >=100)
		{
		$montantReste = $montant%100;
		$montant = $montant - $montantReste;
		$billet[5]=$montant/100;
		}
		else 
			$billet[5]=0;
//calcul nombre de 50	
		$montant = $montantReste;
		if($billetJoueur[4]>0)
		{
		if($montant >=50)
		{
		$montantReste = $montant%50;
		$montant = $montant - $montantReste;
		$billet[4]=$montant/50;
		}
		else
			$billet[4]=0;
//calcul nombre de 20
		$montant = $montantReste;
		if($billetJoueur[3]>0)
		{
		if($montant >=20)
		{
		$montantReste = $montant%20;
		$montant = $montant - $montantReste;
		$billet[3]=$montant/20;
		}
		else 
			$billet[3]=0;
//calcul nombre de 10
		$montant = $montantReste;
		if($billetJoueur[2]>0)
		{
		if($montant >=10)
		{
		$montantReste = $montant%10;
		$montant = $montant - $montantReste;
		$billet[2]=$montant/10;
		}
		else
			$billet[2]=0;
//calcul nombre de 5
		$montant = $montantReste;
		if($billetJoueur[1]>0)
		{
		if($montant >=5)
		{
		$montantReste = $montant%5;
		$montant = $montant - $montantReste;
		$billet[1]=$montant/5;
		}
		else
			$billet[1]=0;
//calcul nombre de 1
		if($billetJoueur[0]>0)
		{
		$billet[0]=$montantReste;
		}
		else
		{
			$billet[0]=0;
		}

		return $billet;    
	}
	
	public function getListeBillet() {
		$billet = array(1,1,1,1,3,2,1);
	    return $billet; 
	}
	
	
}
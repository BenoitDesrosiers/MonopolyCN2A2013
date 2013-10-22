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
	
	public function encaisse( $montant) {
	    
	}
	
	public function paye( $montant) {
	    $arrayBillet[0]="500";
	    $arrayBillet[1]="100";
	    $arrayBillet[2]="50";
	    $arrayBillet[3]="20";
	    $arrayBillet[4]="10";
	    $arrayBillet[5]="5";
	    $arrayBillet[6]="1";
	    $i=0;
	    $ctr=0;
	    $arrayMontant = array() ;
	    while($i < count($arrayBillet)){
	    	while($montant >= $arrayBillet[$i]){
	    		$ctr++;
	    		$montant = $montant-$arrayBillet[$i];
	    	}
	    	$arrayMontant[$i]=$ctr;
	    	$ctr=0;
	    	echo $i;
	    	echo "-----------";
	    	echo $arrayMontant[$i];
	    	echo "++++++++++++++++++++++++";
	    	$i++;
	    }
	    echo $montant;
	}
	
	
	public function getRole() {
	    return 'joueur';
	}
	
	public function tenterAchat(CaseDeJeuAchetable $uneCase){
		return true;
	}
	
}
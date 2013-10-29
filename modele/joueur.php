<?php
require_once "interface/entreposageDatabase.php";
require_once('modele/usager.php');
require_once('modele/caseDeJeu.php');

class Joueur extends Usager implements EntreposageDatabase {
    
	public $argent = array();
	
    //fonctions pour jouer
	public function brasseDes() {
	    
	}
	
	public function avanceSurCase(CaseDeJeu $uneCase) {
	     
	}
	
	public function encaisse( $montant) {
	    
	}
	
	public function paye($montant) {
		
		//Fonction  
	    $argent['500']= 0;
	    $argent['100']= 2;
	    $argent['50'] = 1;
	    $argent['20'] = 4;
	    $argent['10'] = 0;
	    $argent['5'] = 3;
	    $argent['1'] = 5;
	    //Array de l'Argent retourné pour l'encaisse
	    $argentRetour['500']= 0;
	    $argentRetour['100']= 0;
	    $argentRetour['50'] = 0;
	    $argentRetour['20'] = 0;
	    $argentRetour['10'] = 0;
	    $argentRetour['5'] = 0;
	    $argentRetour['1'] = 0;
	    
	    $i = 0;
	    $montantCtr = 0;
	    $argentCtr = 0;
	    
	    foreach($argent as $billet=>$quantite){
	    	$argentCtr += intval($billet) * $quantite; 
	    }
	    echo $argentCtr;
	    
	    if($argentCtr < $montant){
	    	echo "Le joueur n'a pas assez d'argent. ".($montant-$argentCtr)."$ de plus sont nécéssaire.";
	    }
	    else{
		    echo "Argent du joueur avant : ".$argentCtr."<br/>";
		    echo "Montant à payer: ".$montant."<br/>";
		    
		    $argentCtr -= $montant;
		    echo "Argent du joueur après: ".$argentCtr."<br/>";
		    
		    $i = 0;
		    foreach($argent as $billet=>$quantite){
		    	if($quantite != 0){
		    		if($montant > 0){
		    			echo "Montant : ".$montant."</br>";
		    			$montant -=  intval($billet);
		    			echo "Montant : ".$montant."</br>";
		    			$montantCtr = $montant;
		    			echo "MontantCtr : ".$montantCtr."</br>";
		    			$quantite--; 
		    			if($montantCtr < 0){
		    				$montantCtr *= -1;
		    				echo "MontantCtr : ".$montantCtr."</br>";
		    			}		    				
		    		}
		    	}	
		    }
		    foreach($argentRetour as $billet=>$quantite){
		    	if($billet <= $montantCtr){
					$quantite = floor($montantCtr / intval($billet));
					echo "Billet :".$billet."</br>";
					echo "Quantité Retour ... ".$quantite."</br>";
					echo "Montant ".$montantCtr."</br>";
					if($quantite != 0){
						$montantCtr -= intval($billet) * $quantite;
						//echo "Montant :".$montant."</br>";	
					}
		    	}
		    }
		    
	    }	
	}
	
	public function getRole() {
	    return 'joueur';
	}
	
	public function tenterAchat(CaseDeJeuAchetable $uneCase){
		return true;
	}
	
}
<?php
require_once "interface/entreposageDatabase.php";
require_once('modele/usager.php');
require_once('modele/caseDeJeu.php');
require_once('dataMapper/joueurDataMapper.php');

class Joueur extends Usager implements EntreposageDatabase {
	
    //fonctions pour jouer
	public function brasseDes() {
	    
	}
	
	public function avanceSurCase(CaseDeJeu $uneCase) {
	     
	}
	
	public function encaisse( $montant) {
	    
	}
	/*vero, David, Vinccent ------*/
	public function paye($montant) {
		
		//Fonction 
		
		//
		//Fake de l'Argent du joueur 
	    $argent['500']= 0;
	    $argent['100']= 5;
	    $argent['50'] = 1;
	    $argent['20'] = 4;
	    $argent['10'] = 0;
	    $argent['5'] = 3;
	    $argent['1'] = 5;
	    
	    //Variable pour calculer le montant
	    $montantCtr = 0;
	    $argentCtr = 0;
	    $quantiteCtr =0;
	    
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
		    	$argent[$billet]=$quantite;
		    }
		    
		    foreach($argent as $billet=>$quantite){
		    	echo "Billet Avant :".$billet."</br>";
		    	echo "Quantité Retour ... Avant".$quantite."</br>";
		    	echo "Montant Avant".$montantCtr."</br>";
		    	if($billet <= $montantCtr){
					$quantiteCtr = floor($montantCtr / intval($billet));
					$quantite += $quantiteCtr; 
					echo "Billet Après :".$billet."</br>";
					echo "Quantité Retour ... Après ".$quantite."</br>";
					echo "Montant Après".$montantCtr."</br>";
					if($quantite != 0){
						$montantCtr -= intval($billet) * $quantite;
						//echo "Montant :".$montant."</br>";	
					}
		    	}
		    	$argent[$billet]=$quantite;
		    }
		    
	    }
	    $this->encaisse($argent);
	}
	
	public function tenterAchat(CaseDeJeuAchetable $uneCase){
		return true;
	}
	/*-----vero*/
	public function getRole() {
		return 'joueur';
	}
}
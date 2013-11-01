<?php
require_once "interface/entreposageDatabase.php";
require_once('modele/usager.php');
require_once('modele/caseDeJeu.php');

class Joueur extends Usager{
    
    //fonctions pour jouer
	public function brasseDes() {
	    
	}
	
	public function avanceSurCase(CaseDeJeu $uneCase) {
	     
	}
	
	public function encaisse($montant) {
	    
	}
	
public function paye($montant) {
                
			//Fonction aller chercher argent dans la database
			//$argent = $this->getArgent();
			  
            $argent['500']= 0;
            $argent['100']= 2;
            $argent['50'] = 1;
            $argent['20'] = 4;
            $argent['10'] = 0;
            $argent['5'] = 3;
            $argent['1'] = 5;
        
            
            $montantCtr = 0;
            $argentCtr = 0;
            
            //verification argent
            //si le joueur a assez d'argent pour payer 
            foreach($argent as $billet=>$quantite){
                    $argentCtr += intval($billet) * $quantite; 
            }
            echo "Le joueur à ".$argentCtr."$ et doit payer ".$montant."$";
            echo "</br>";
            
            if($argentCtr < $montant){
                    echo "Le joueur n'a pas assez d'argent. ".($montant-$argentCtr)."$ de plus sont nécéssaire.";
            }
            else{
                    echo "Argent du joueur avant : ".$argentCtr."<br/>";
                    echo "Montant à payer: ".$montant."<br/>";
                    
                    $argentCtr -= $montant;
                    echo "Argent du joueur après: ".$argentCtr."<br/>";
                    
                    //creation de l'array de paiement exemple le joueur doit payer 350, il paye avec un 500
                    // montantCtr = valeur que le joueur recupere
                    // quantiteCtr = quantite de billet utilisé
                    foreach($argent as $billet=>$quantite){
                            if($quantite != 0){
                                    if($montant > 0){
                                            //echo "Montant : ".$montant."</br>";
                                    		$quantiteCtr = ceil($montant / intval($billet));
                                    		if($quantiteCtr > $quantite)
                                    			$quantiteCtr = $quantite;
                                            $montant -=  $quantiteCtr *intval($billet);
                                            //echo "Montant : ".$montant."</br>";
                                            $montantCtr = $montant;
                                            //echo "MontantCtr : ".$montantCtr."</br>";
                                            $quantite -= $quantiteCtr ; 
                                            if($montantCtr < 0){
                                                    $montantCtr *= -1;
                                                    //echo "MontantCtr : ".$montantCtr."</br>";
                                            }               
                                    	//echo "Billet actuel : " . $billet . "</br>";
                                    	//echo "quantite actuel : " . $quantiteCtr . "</br>";   
                                    	//echo "montantctr : " . $montantCtr . "</br>";                                     
                                    }
                                    
                            } 
                     
                            $argent[$billet]=$quantite;     
                            
                    }
                    
                    //creation de l'array que le joueur doit encaisser apres avoir payer
                    //exemple il a payer 350 avec un billet de 500 donc il doit encaisser 150
                    //update l'array d'argent total du joueur
                    //montantCtr = valeur que le joueur recupere
                    // quantiteCtr = quantite de billet recuperé
                    foreach($argent as $billet=>$quantite){
                    	//echo "montantctr retour: ". $montantCtr . "</br>";
                            if($billet <= $montantCtr){
                                        $quantiteCtr = floor($montantCtr / intval($billet));
                                        $quantite += $quantiteCtr;
                                        
                                        //echo "Billet retour :".$billet."</br>";
                                        //echo "Quantité Retour : ".$quantiteCtr."</br>";
                                        
                                        if($quantiteCtr != 0){
                                                $montantCtr -= intval($billet) * $quantiteCtr;
                                                //echo "Montant Retour ".$montantCtr."</br>";
                                        }
                               
                                   
                            }
                            $argent[$billet]=$quantite;
                    }
                    
            }
            //appel la fonction encaisse pour mettre a jour l'argent du joueur.
            $this->encaisse($argent);
            return $argent;
        }
       
        
	
	public function getRole() {
		return 'coordonnateur';
	}
}
?>
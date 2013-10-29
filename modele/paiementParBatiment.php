<?php
require_once('modele/caseDeJeuAchetable.php');
require_once('modele/tableau.php');
require_once('modele/partie.php');
//require_once('modele/banque.php');

class paiementParBatiment {
	
	protected $totalhotels = 0;
	protected $totalmaisons = 0;
	
	public function calculPaiementParBatiment($joueur, $carte) {
		 
	//parcours le tableau de jeu, trouve les cases achetables, regarde si la case achetable appartient a un propriétaire donné
		$partie = Partie::parId('1'); //ceci étant un démo, nous utiliserons la partie #1
		$tableauDeJeu = $partie->getTableau();
		
		for($x = 1; $x<40;$x++)
    	{
    		$case = $tableauDeJeu->getCaseParPosition($x);
    			if( $case != null)
    			{
    				$array[$x-1]=$case;
    				
    				if ($array[$x-1]->getProprietaire() == $joueur->getNom())
    				{
    					$totalmaisons += $array[$x-1]->getNombreMaison();
    					$totalhotels += $array[$x-1]->getNombreHotel();
    				}
    			}
    	}

    
    //carte de la Caisse Commune ou Chance.
    		
    if ($carte->getid() == 15)
    {
    	$facture = $totalmaisons * 40 + $totalhotels * 115;
    }
    
    if ($carte->getid() == 27)
    {
    	$facture = $totalmaisons * 25 + $totalhotels * 100;
    }
    
    return $facture;
    
    //paiement à la banque a partir du $joueur du montant $facture
    
 //   $banque = new banque;
 //   $banque->fairePayer($joueur,$facture);
    		
 
    		
}}
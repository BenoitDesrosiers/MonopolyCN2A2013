<?php
require_once('modele/caseDeJeuAchetable.php');
require_once('modele/tableau.php');
require_once('modele/partie.php');

//require_once('modele/banque.php');

class paiementParBatiment {
	
	public function calculPaiementParBatiment($joueur, $carte, $partie) {
		 
		$totalhotels = 0;
		$totalmaisons = 0;
	
		$tableauDeJeu = $partie->getTableau();

		//parcours le tableau de jeu, trouve les cases achetables, regarde si la case achetable appartient a un propriétaire donné
		for($x = 1; $x<40;$x++)
    	{
    		$case = $tableauDeJeu->getCaseParPosition($x); //TODO: ca devrait simplement demander au joueur ses cases achet�es (de JoueurPartie_CaseAchetable)
    		
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

    
    //carte de la Caisse Commune ou Chance, "hardcoder" avec leurs ID provenant de la BD.
    		
    if ($carte->getid() == 15)
    {
    	$facture = $totalmaisons * 40 + $totalhotels * 115;
    }
    
    if ($carte->getid() == 27)
    {
    	$facture = $totalmaisons * 25 + $totalhotels * 100;
    }
    
    
    //return pour fin de test seulement, normalement pas de return, paiement à la banque (code en commentaire plus bas)
    return $facture;
    
    //paiement à la banque a partir du $joueur du montant $facture
    
 //   $banque = new banque;
 //   $banque->fairePayer($joueur,$facture);
    		
 
    		
}}
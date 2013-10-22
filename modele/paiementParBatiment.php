<?php
require_once('modele/paiement.php'); //TODO: faire modele/paiement.php
require_once('modele/caseDeJeuAchetable.php');
require_once('modele/banque.php');

class paiementParBatiment extends paiement {
	
	protected $totalhotels = 0;
	protected $totalmaisons = 0;

	// de paiement, j'ai besoin du joueur, que paiement doit recevoir de carte par Joueur
	
	public function calculPaiementParBatiment($joueur, $carte) {
		 
	
	for($x = 1; $x<40;$x++)
    		{
    			$case = $tableauDeJeu->getCaseParPosition($x);
    			if( $case != null)
    			{
    				$array[$x-1]=$case;
    			}
    			else
    				$array[$x-1]=null;
    		}
    		
    for($x = 1; $x<40;$x++)
    {
    	if ($array[$x-1] != null)
    	{
    		if ($array[$x-1]->getProprio() == $joueur->getNom())
    		{
    			$totalmaisons += $array[$x-1]->getMaisons();
    			$totalhotels += $array[$x-1]->getHotels();
    		} 
    	}
    	
    }
    		
    if ($carte->getId() == 3)
    {
    	$facture = $totalmaisons * 15 + $totalhotels * 25;
    }
    
    if ($carte->getId() == 6)
    {
    	$facture = $totalmaisons * 10 + $totalhotels * 20;
    }
    
    $banque = new banque;
    $banque->fairePayer($joueur,$facture);
    		
    //paiement à la banque a partir du $joueur du montant $facture 
    		
}}
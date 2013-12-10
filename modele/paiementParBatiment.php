<?php
//require_once('modele/tableau.php');
require_once('modele/partie.php');
require_once('modele/joueur.php');
require_once('modele/carte.php');
require_once('modele/banque.php');
require_once('modele/cartePropriete.php');
//require_once('modele/banque.php');

class paiementParBatiment {
	
	public function calculPaiementParBatiment(Joueur $joueur, Carte $carte, Partie $partie) {
		 
		$totalhotels = 0;
		$totalmaisons = 0;
	
		$proprietes = $joueur->getProprietes();
		foreach ($proprietes as $propriete) {
		    $totalmaisons += $propriete->getNombreMaisons();
		    $totalhotels += $propriete->getNombreHotels();
		}
    
        //carte de la Caisse Commune ou Chance, "hardcoder" avec leurs ID provenant de la BD.

		switch ($carte->getid()) {
			case '15' :
				$facture = $totalmaisons * 40 + $totalhotels * 115;
				break;
			case '27' :
				$facture = $totalmaisons * 25 + $totalhotels * 100;
				break;
		}
		
        //paiement a la banque a partir du $joueur du montant $facture
         
        $banque = new banque; 
        $banque->fairePayer($joueur,$facture);
        		
        //return pour fin de test seulement, normalement pas de return, paiement a la banque 
        return $facture;
    	
	}
}
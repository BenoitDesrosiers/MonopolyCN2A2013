<?php
require_once('modele/joueur.php');

class banque
{


public function paye($joueur, $montant)
{
	$billet = $joueur->paye($montant);
	
}

}

?>
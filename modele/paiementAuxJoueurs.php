<?php
// Par Tommy Teasdale
require_once "modele/carteChance.php";

class PaiementAuxJoueurs{
    
    public function execute($unJoueur, $montantPayer){
        $partie=Partie::parId($unJoueur->getPartieId());
        
        $joueurs=$partie->getJoueurs();
        
        foreach($joueurs as $joueur){
            $unJoueur->paye($montantPayer);
            $joueur->encaisse($montantPayer);
        }
    }
}
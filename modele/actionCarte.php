<?php
// Par Tommy Teasdale
require_once "modele/action.php";
require_once "modele/partie.php";


class ActionCarte extends Action{
    
    public function __construct($idAction){
        $this->setID($idAction);
    }
    
    public function execute($unJoueur){
        
        $partie=Partie::parId($unJoueur->getPartieId());
        
        if($this->id==42)
            $carte=$partie->getProchaineCarteCC();
        elseif($this->id==43)
            $carte=$partie->getProchaineCarteChance();
        
        $carte->execute($unJoueur);
        
    }
}
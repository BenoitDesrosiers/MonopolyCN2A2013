<?php
/*
 * la première classe dans la hierarchie des modèles
 * 
 */
require_once 'interface/observateur.php';

class Objet {
    protected $observateurs; //une liste d'objets qui m'observent et a qui j'envoie des notifications quand je change
    

    // Protocole pour de pattern Observer
    public function attache(Observateur $observateur ) {
        $this->observateurs[] = $observateur;
    }
    
    public function detache(Observateur $observateur) {
        if (is_int($key = array_search($observateur, $this->observateurs, true))) {
            unset($this->observateurs[$key]);
        }
    }
    
    public function notifie()
    {
        foreach ($this->observateurs as $observateur) {
            $observateur->update($this);
        }
    }
    
}
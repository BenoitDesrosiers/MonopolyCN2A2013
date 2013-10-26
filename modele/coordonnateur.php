<?php
require_once 'modele/joueur.php';
require_once 'modele/partie.php';
require_once 'dataMapper/coordonnateurDataMapper.php';

class Coordonnateur extends Usager {
    protected $partiesEnCours = array(); // les parties appartenant à ce coordonnateur

    // Static Factory
    
    public static function tous() {    
        /*
         * retourne tous les coordonnateurs existant dans le système
         */
        $mapper = new CoordonnateurDataMapper();
        $coordonnateurs = $mapper->findAllCoordonnateur();
        //recrée l'usager selon son type.
        return $coordonnateurs;
    }
   
    // Setter et Getter
    public function getPartiesEnCours() {
        // les parties appartenant à ce coordonnateur
        //LISTEPARTIE 1.3.1.x : on utilise une factory de parties

        //lazy load 
        $this->setPartiesEnCours(Partie::pourCoordonnateur($this));
        return $this->partiesEnCours;
    }

    public function setPartiesEnCours($value) {
        $this->partiesEnCours = $value;
    }

    public function creerPartie() {
        //TODO: à faire
    }

    public function demarrePartie() {
        //TODO: à faire
    }

    public function arretePartie() {
        //TODO: à faire
    }

    public function accepteJoueur() {

    }

    public function rejetteJoueur() {

    }


}
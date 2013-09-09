<?php
require_once 'modele/joueur.php';
require_once 'modele/partie.php';

class Coordonnateur extends Usager {
    protected $partiesEnCours = array(); // les parties appartenant à ce coordonnateur

    
   
    // Setter et Getter
    public function getPartiesEnCours() {
        // les parties appartenant à ce coordonnateur
        //LISTEPARTIE 1.3.1.x : on utilise une factory de parties 
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


    public function getRole() {
        return 'coordonnateur';
    }


}
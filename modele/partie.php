<?php

class Partie {
    protected $id;
    protected $joueurs; // la liste des joueurs (de 1 à 8)
    protected $heureDebut; // l'heure de la création de la partie
    protected $tableau; // le tableau sur lequel se déroule la partie
    protected $banque;
    protected $des;
    protected $cartesChance;
    protected $cartesCaisseCommune;
    protected $pions;
    protected $maisons;  //TODO: est-ce que ca devrait plutot appartenir à la banque
    protected $hotels;

    //Getters & Setters
    public function getHotels() {
        return $this->Hotels;
    }
    public function setHotels($value) {
        $this->Hotels = $value;
    }

    public function getMaisons() {
        return $this->Maisons;
    }
    public function setMaisons($value) {
        $this->Maisons = $value;
    }

    public function getPions() {
        return $this->Pions;
    }
    public function setPions($value) {
        $this->Pions = $value;
    }

    public function getCartesCaisseCommune() {
        return $this->cartesCaisseCommune;
    }
    public function setCartesCaisseCommune($value) {
        $this->cartesCaisseCommune = $value;
    }


    public function getCartesChance() {
        return $this->cartesChance;
    }
    public function setCartesChance($value) {
        $this->cartesChance = $value;
    }

    public function getDes() {
        return $this->des;
    }
    public function setDes($value) {
        $this->des = $value;
    }

    public function getBanque() {
        return $this->banque;
    }
    public function setBanque($value) {
        $this->banque = $value;
    }



    public function getHeureDebut() {
        return $this->heureDebut;
    }

    public function setHeureDebut($value) {
        $this->heureDebut = $value;
    }

    public function getJoueurs() {
        return $this->joueurs;
    }
    public function setJoueurs($value) {
        $this->joueurs = $value;
    }

    public function getId() {
        return $this->id;
    }
    public function setId($value) {
        $this->id = $value;
    }

    public function getTableau() {
        return $this->tableau;
    }

    public function setTableau($value) {
        $this->tableau = $value;
    }



    // Hydratation de l'objet

    public function hydrate(array $donnees) {
        foreach ($donnees as $cle => $valeur) {
            $method = 'set'.ucfirst($cle);
            if (method_exists($this, $method)) {
                $this->$method($valeur);
            }
        }
    }


    public function getCoordonnateur() {
        //TODO: trouver le coordonnateur dans la liste des joueurs
        //TODO: serait un bel endroit pour un lazy init
    }


    
    



}

?>

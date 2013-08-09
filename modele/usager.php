<?php

//require_once "interface/entreposageDatabase.php";
//FIXME: si je mets l'interface, ca ne fonctionnne pas
require_once 'dataMapper/usagerDataMapper.php';
require_once 'modele/partie.php';

abstract class Usager {  //implements EntreposageDatabase {
    protected $nom;
    protected $compte;
    protected $password;

    function __construct($password, $compte, $nom) {
        $this->setPassword($password);
        $this->setCompte($compte);
        $this->setNom($nom);
    }

    // Static Factory
    
    public static function parCompte($compte) {
        $usagerMapper = new UsagerDataMapper();
        return $usagerMapper->find($compte);
    }
    
    public static function parComptePW($compte, $password) {
        // crée l'usager associer à un numéro de compte en verifiant si le mot de passe est le bon
        // si aucun usager n'est associé ou si le pw est mauvais, null sera retourné
        $usager = null;
        $usager1 = self::parCompte($compte);
        if ($usager1 <> null) {
            if ($usager1->validePW($password)) {
                $usager = $usager1;
            }
        }
        return $usager; //FIXME: changer le retour de null par une exception
    }
    
   
    // interface entreposageDatabase
    public function getDataMapper() {
        return new UsagerDataMapper();
    }
    
    public function sauvegarde() {
        $this->getDataMapper->insert($this);
    }
    
    //Getters & Setters

    public function getCompte() {
        return $this->compte;
    }
    public function setCompte($value) {
        $this->compte = $value;
    }
     

    public function getNom() {
        return $this->nom;
    }
    public function setNom($value) {
        $this->nom = $value;
    }

    public function getPassword() {
        return $this->password;
    }
    public function setPassword($value) {
        $this->password = $value;
    }


    public function validePW($password) {
        return sha1($password)==$this->password;
    }

    public function estCharge() {
        //est-ce que l'objet est charge en memoire a partir de la db
        return ($this->compte <> null);
    }

    
    abstract public function getRole();

    // function de Jeu

    public function joindrePartie(Partie $unePartie) {
         
    }

}
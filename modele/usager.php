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
        //CONNECTION 1.2.4.2.x : un data mapper sert à faire l'interface avec la bd. 
        $usagerMapper = new UsagerDataMapper();
        //CONNECTION 1.2.4.3.x : cherche l'usager avec ce compte dans la bd
        return $usagerMapper->find($compte);
    }
    
    public static function parComptePW($compte, $password) {
        // crée l'usager associer à un numéro de compte en verifiant si le mot de passe est le bon
        // si aucun usager n'est associé ou si le pw est mauvais, null sera retourné
        
        //CONNECTION 1.2.4.1 : appelé à partir de connectionUsager/index.php. 
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
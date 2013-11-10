<?php

//require_once "interface/entreposageDatabase.php";
//FIXME: si je mets l'interface, ca ne fonctionnne pas
require_once 'dataMapper/usagerDataMapper.php';
require_once 'dataMapper/joueurDataMapper.php';
require_once 'dataMapper/coordonnateurDataMapper.php';

require_once 'modele/partie.php';

class Usager {  //implements EntreposageDatabase {
    protected $nom;
    protected $compte;
    protected $password;
    protected $role;
    

    function __construct(array $array) {
        /*
         * input
         *     un array associative contenant le 
         *     mot de passe 'MotDePasse', 
         *     le compte 'Compte', 
         *     le nom 'Nom', 
         *     et le role 'Role' de l'usager à créer
         */
        $this->setPassword($array['MotDePasse']);
        $this->setCompte($array['Compte']);
        $this->setNom($array['Nom']);
        $this->setRole($array['Role']);
    }

    // Static Factory
    
    public static function parCompte($compte) {
        //CONNECTION 1.2.4.2.x : un data mapper sert à faire l'interface avec la bd. 
        $usagerMapper = new UsagerDataMapper();
        //CONNECTION 1.2.4.3.x : cherche l'usager avec ce compte dans la bd
        $usager = $usagerMapper->find(array($compte));
        //recrée l'usager selon son type. 
        If ($usager->getRole() == 'coordonnateur') {
                $mapper = new CoordonnateurDataMapper();
        } else {
            $mapper = new UsagerDataMapper();
        }
        return $mapper->find(array($compte));
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
    
    public function update() {
        $this->getDatamapper->update($this);
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

    
    public function getRole() {
        return $this->role;
    }
    public function setRole($value) {
        $this->role = $value;
    }

    // function de Jeu

    public function joindrePartie(Partie $unePartie) {
         
    }

}
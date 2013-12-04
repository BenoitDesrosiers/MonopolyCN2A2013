<?php
require_once "dataMapper/mapper.php";
require_once "modele/usager.php";


class UsagerDataMapper extends Mapper {
    
    function __construct() {
        //CONNECTION 1.2.4.2.1 : batit le datamapper. Faire un 'new' appele "__construct"
        parent::__construct(); // "parent" veut dire "cette methode de ma superclasse. 
        $this->selectStmt = self::$db->prepare("SELECT * FROM Usager where compte=?");
        $this->updateStmt = self::$db->prepare('update Usager set compte=?, password=?, nom=?, role=?,  where compte=?');
        $this->insertStmt = self::$db->prepare("insert into Usager ( compte, password, nom, role ) values (?, ?, ?, ?)");
        
    }

    
    protected function doCleUnique() {
        /* retourne la cle unique pour identifier cet objet dans la bd 
         * utilise pour la gestion des instance 
         * output
         *     Une array contenant les champs a utiliser pour la cle dans la bd
         */     
       
        return (array("Compte"));
        
    }
    
    protected function classeGeree() {
        return "Usager";
    }
    
    protected function doCreateObject( array $array) {
        //CONNECTION 1.2.4.3.2.1 cree l'usager
        return new Usager($array) ;
        //TODO: ajouter le attache pour l'observer         
    }
    
    protected function doInsert( $object) {
        //TODO: ajouter une exception si le compte est deja utilise
        $values = array($object->getCompte(), $object->getPassword(), $object->getNom(), $object->getRole());
        $this->insertStmt->execute($values);
    }
    
    function update($object, $sujet) {
        $values= array ($object->getCompte(), $object->getPassword(), $object->getNom(), $object->getRole());
        $this->updateStmt->execute($values);
    }
    
    function selectStmt() {
        return $this->selectStmt;
    }

   
}
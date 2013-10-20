<?php

require_once "dataMapper/mapper.php";
require_once "modele/usager.php";


class UsagerDataMapper extends Mapper {
    
    function __construct() {
        //CONNECTION 1.2.4.2.1 : batit le datamapper. Faire un 'new' appele "__construct"
        parent::__construct(); // "parent" veut dire "cette méthode de ma superclasse. 
        $this->selectStmt = self::$db->prepare("SELECT * FROM Usager where compte=?");
        $this->updateStmt = self::$db->prepare('update Usager set compte=?, password=?, nom=?, role=?,  where compte=?');
        $this->insertStmt = self::$db->prepare("insert into Usager ( compte, password, nom, role ) values (?, ?)");
        
    }

    protected function doCreateObject( array $array) {
        //CONNECTION 1.2.4.3.2.1 crée l'usager
        return new Usager($array) ;        
    }
    
    protected function doInsert( $object) {
        //TODO: ajouter une exception si le compte est déja utilisé
        $values = array($object->getCompte(), $object->getPassword(), $object->getNom(), $object->getRole());
        $this->insertStmt->execute($values);
    }
    
    function update($object) {
        $values= array ($object->getCompte(), $object->getPassword(), $object->getNom(), $object->getRole(), $object->getCompte());
        $this->updateStmt->execute($values);
    }
    
    function selectStmt() {
        return $this->selectStmt;
    }
    
    

   
   
}
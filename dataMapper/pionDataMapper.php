<?php

require_once "dataMapper/mapper.php";
require_once "modele/pion.php";

class PionDataMapper extends Mapper {
    
    function __construct() {
        parent::__construct(); 
        
        $this->selectStmt = self::$db->prepare("SELECT * FROM Pion WHERE Id = ?");
        $this->updateStmt = self::$db->prepare("update Pion set Id = ?, Nom = ?, ImageUrl = ?
                                                where Id = ?");
        $this->insertStmt = self::$db->prepare("insert into Pion ( Id, Nom, ImageUrl ) values (?,?,?)");
        
    }
    
    protected function doCreateObject( array $array) {
        return new Pion($array) ;
    }
    protected function classeGeree() {
        return "Pion";
    }
    protected function doCleUnique() {
        return (array("Id"));
    }
    
    protected function doInsert( $objet) {
        //TODO: ajouter le check si l'objet est deja dans la BD. 
        $values = array($objet->getId(), $objet->getNom(), $objet->getImageUrl());
        $this->insertStmt->execute($values);
    }
    
    function update($objet, $sujet) {
        $values= array ($objet->getId(), $objet->getNom(), $objet->getImageUrl(),
                        $objet->getId());
        $this->updateStmt->execute($values);        
    }
    
  
    
    function selectStmt() {
        return $this->selectStmt;
    }
    
    function findPourDefinitionPartie($definitionPartieId) {
        /*
         * input
        *     $definitionPartieId: l'id d'une definition de partie
        * output
        *     un array contenant les pions associees a la partie.
        *     un array vide si aucun pions n'est trouve
        *
        */
        
        $queryTxt = 'SELECT * FROM DefinitionPartie_Pion
                        WHERE  DefinitionPartieId = :id';
        $query = self::$db->prepare($queryTxt);
        $query->bindValue(':id', $definitionPartieId);
        
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $query->execute();
        $listeItems = array();
        // $query contient les id des pions a creer
        foreach($query as $row) {
             $unItem = $this->find(array($row['PionId']));
             if ($unItem <> null) {
                $listeItems[] = $unItem;
             }
        }
        return $listeItems;
    } 
        
  
}
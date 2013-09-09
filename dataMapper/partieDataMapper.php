<?php

require_once "dataMapper/mapper.php";
require_once "modele/partie.php";

class PartieDataMapper extends Mapper {
    
    function __construct() {
        parent::__construct();
        $this->selectStmt = self::$db->prepare("SELECT * FROM PartiesEnCours where id=?");
        $this->updateStmt = self::$db->prepare('update PartiesEnCours set id=?, nom=?, coordonnateur=?,  where id=?');
        $this->insertStmt = self::$db->prepare("insert into PartiesEnCours ( nom, coordonnateur ) values (?, ?)");
        
    }

    protected function doCreateObject( array $array) {
        
        $obj = new Partie($array['nom'],$array['coordonnateur'] );
        $obj->setId($array['id']);
        return $obj;        
    }
    
    protected function doInsert($object) {
        if (!$this->nomLibre($object->getNom())) {
            //Verifie si il n'y a pas déjà une partie avec le même nom.
            throw new Exception('nom déjà utilisé');
        }
        //TODO ajouter un check si le coordonnateur n'est pas null ou inexistant
        $values = array($object->getNom(), $object->getCoordonnateur());
        $this->insertStmt->execute($values);
        $id = self::$db->lastInsertId();
        $object->setId($id);
    }
    
    function update($object) {
        $values= array ($object->getId(), $object->getNom(), $object->getCoordonnateur(), $object->getId());
        $this->updateStmt->execute($values);
    }
    
    function selectStmt() {
        return $this->selectStmt;
    }
    
    /*
     * fonctions spécific à ce datamapper
     */
    
    function nomLibre($nom) {
        /*
         * vérifie si ce $nom est déjà utilisé pour une autre partie
         * 
         * Retour
         *     true: le nom n'est pas utilisé
         *     false: une partie a déjà ce nom
         */
        $queryTxt = 'SELECT * FROM PartiesEnCours
                WHERE nom = :nom';
        $query = self::$db->prepare($queryTxt);
        $query->bindValue(':nom', $nom);
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $query->execute();
        
        if ($query->rowCount() == 0) {
            return true;
        } else {
            return false;
        }
        
    }
    function findPourCoordonnateur( $idCoordonnateur) {
        // crée les parties associées à un coordonnateur a partir de la db
        
        /*
         * input
        *     $idCoordonnateur: l'id du coordonnateur
        * output
        *     un array contenant les parties associées au coordonnateur.
        *     un array vide si aucune partie n'est associée au coordonnateur
        *
        */
        //LISTEPARTIE 1.3.1.1.1 extrait la liste des parties pour un coordonnateur. 
        $queryTxt = 'SELECT * FROM PartiesEnCours
                        WHERE coordonnateur = :coordonnateur';
        $query = self::$db->prepare($queryTxt);
        $query->bindValue(':coordonnateur', $idCoordonnateur);
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $query->execute();
        
        $listeItems = array();
        
        foreach($query as $row) {
            $unItem = $this->createObject($row);
            if ($unItem <> null) {
                $listeItems[] = $unItem;
            }
        }
        return $listeItems;
    }
}
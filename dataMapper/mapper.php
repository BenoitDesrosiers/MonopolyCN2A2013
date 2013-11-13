<?php
require_once('modele/database.php');
require_once('interface/observateur.php');
/*
 * cette classe est tiree du livre PHP objects patterns and practice, 3rd edition (p227)
 */

/*
 * Cette classe est la superclass de tous les datamapper pour les objets qui doivent
 * se sauvegarder dans une BD
 * 
 * 
 */
abstract class Mapper implements Observateur {
    protected static $db;
    
    function __construct() {
        //TODO: le mapper devrait être un singleton pour chaque sous-classe, il devrait donc s'enregistrer et avoir une factory sinon le pattern observateur peut faire qu'on fera plusieur ecritures
        
        self::$db = Database::getDB(); 
    }
    
    function find( array $cle) {
        /*
         * find est la methode "generique" pour trouver un objet avec la cle egale a $id
         * trouve l'objet qui a cet $id dans la bd
         * le selectStmt de la sous-classe doit selectionner selon cette cle
         */
        //TODO: garder les items dans un Registry pour eviter la duplication d'instance
        //TODO: trouver un moyen pour les cas ou la cle est composee (au lieu de id, prendre un array. Devra matcher dans le selectStmt 
        $this->selectStmt()->execute( $cle);
        $array = $this->selectStmt()->fetch();
        //$this->selectStmt()->closeCursor(); // appel optionnel non necessaire pour mysql
        if (!is_array($array)){return null;} // aucune row de retourner, donc l'objet n'existe pas dans la bd. 
        //if (!isset($array['id'])) {return null;}   //TODO: a quoi sert ce check? je l'ai enleve parce que le cles ne sont pas toujours ID
        //CONNECTION 1.2.4.3.1 cree l'usager
        $object = $this->createObject($array);
        return $object;
    }
    
    function findAll($pdoSelect) {
        /*
         * retourne tous les objects correspondant au query pdo passe en paramètre 
         */
        $pdoSelect->setFetchMode(PDO::FETCH_ASSOC);
        $pdoSelect->execute();
        $listeItems = array();
    
        foreach($pdoSelect as $row) {
             $unItem = $this->createObject($row);
             if ($unItem <> null) {
                $listeItems[] = $unItem;
             }
        }
        return $listeItems;
    }
        
     //   function findAll(array $array) {
            /*
             * retourne tous les objects correspondant aux critères passes dans $array
            */
     /*      $this->selectAllStmt()->execute($array);
            $listeItems = array();
            foreach($this->selectAllStmt() as $row) {
                $unItem = $this->createObject($row);
                if ($unItem <> null) {
                    $listeItems[] = $unItem;
                }
            }
            return $listeItems;
        }
        */
    
    
    function createObject($array) {
        /*
         * cree un objet a partir d'un array associatif contenant tous les champs de la bd
        */
        //CONNECTION 1.2.4.3.2.x cree l'usager
        $obj = $this->doCreateObject($array);
        return $obj;
    }
    
    function insert( $obj ) {
        /*
         * ajoute $obj dans la db
         */
        $this->doInsert($obj);
    }
    
    //Ces functions doivent etre cree dans les sous-classes
    public function update ($objet, $sujet) {
        //devrait etre abstract, mais ca marche pas a cause de l'interface Observateur; 
    }
    protected abstract function doCreateObject( array $array);
    protected abstract function doInsert( $object);
    protected abstract function selectStmt();
    
}
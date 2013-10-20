<?php
require_once('modele/database.php');

/*
 * cette classe est tirée du livre PHP objects patters and practice, 3rd edition (p227)
 */

/*
 * Cette classe est la superclass de tous les datamapper pour les objets qui doivent
 * se sauvegarder dans une BD
 * 
 * 
 */
abstract class Mapper {
    protected static $db;
    
    function __construct() {
        self::$db = Database::getDB(); 
    }
    
    function find( array $cle) {
        /*
         * find est la méthode "générique" pour trouver un objet avec la clé égale à $id
         * trouve l'objet qui a cet $id dans la bd
         * le selectStmt de la sous-classe doit sélectionner selon cette clé
         */
        //TODO: garder les items dans un Registry pour eviter la duplication d'instance
        //TODO: trouver un moyen pour les cas ou la clé est composée (au lieu de id, prendre un array. Devra matcher dans le selectStmt 
        $this->selectStmt()->execute( $cle);
        $array = $this->selectStmt()->fetch();
        //$this->selectStmt()->closeCursor(); // appel optionnel non nécessaire pour mysql
        if (!is_array($array)){return null;} // aucune row de retourner, donc l'objet n'existe pas dans la bd. 
        //if (!isset($array['id'])) {return null;}   //TODO: a quoi sert ce check? je l'ai enleve parce que le clés ne sont pas toujours ID
        //CONNECTION 1.2.4.3.1 créé l'usager
        $object = $this->createObject($array);
        return $object;
    }
    
    function findAll(array $array) {
        /*
         * retourne tous les objects correspondant aux critères passés dans $array 
         */
        $this->selectAllStmt()->execute($array);
        $listeItems = array();
        
        foreach($this->selectAllStmt() as $row) {
            $unItem = $this->createObject($row);
            if ($unItem <> null) {
                $listeItems[] = $unItem;
            }
        }
        return $listeItems;
    }
    
    function createObject($array) {
        /*
         * crée un objet à partir d'un array associatif contenant tous les champs de la bd
        */
        //CONNECTION 1.2.4.3.2.x créé l'usager
        $obj = $this->doCreateObject( $array);
        return $obj;
    }
    
    function insert( $obj ) {
        /*
         * ajoute $obj dans la db
         */
        $this->doInsert($obj);
    }
    
    //Ces functions doivent être créée dans les sous-classes
    abstract function update ($object); 
    protected abstract function doCreateObject( array $array);
    protected abstract function doInsert( $object);
    protected abstract function selectStmt();
    
}
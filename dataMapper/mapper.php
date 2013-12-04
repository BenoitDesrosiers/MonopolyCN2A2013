<?php
require_once "modele/database.php";
require_once "interface/observateur.php";
require_once "util/gestionInstance.php";
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
        //TODO: le mapper devrait etre un singleton pour chaque sous-classe, il devrait donc s'enregistrer et avoir une factory sinon le pattern observateur peut faire qu'on fera plusieur ecritures
        
        self::$db = Database::getDB(); 
    }
    
    function find( array $cle) {
        /*
         * find est la methode "generique" pour trouver un objet 
         * trouve l'objet qui a cet $cle dans la bd
         * le selectStmt de la sous-classe doit selectionner selon cette cle
         * 
         * input
         *     $cle : un array contenant les champs qui compose la clŽ 
         */
        $cleUnique = $this->cleUnique($cle);
        if (GestionInstance::objetExiste($this, $cleUnique)) {
            $objet = GestionInstance::extraitObjet($this, $cle);
        } else {
            $this->selectStmt()->execute( $cle);
            $array = $this->selectStmt()->fetch();
            //$this->selectStmt()->closeCursor(); // appel optionnel non necessaire pour mysql
            if (!is_array($array)){return null;} // aucune row de retourner, donc l'objet n'existe pas dans la bd. 
            //if (!isset($array['id'])) {return null;}   //TODO: a quoi sert ce check? je l'ai enleve parce que le cles ne sont pas toujours ID
            //CONNECTION 1.2.4.3.1 cree l'usager
            $objet = $this->createObject($array);
        }
        return $objet;
    }
    
    function findAll($pdoSelect) {
        /*
         * retourne tous les objects correspondant au query pdo passe en parametre 
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
        
    
    
    function createObject($array) {
        /*
         * cree un objet a partir d'un array associatif contenant tous les champs de la bd
        */
        //CONNECTION 1.2.4.3.2.x cree l'usager
        
        //TODO: le call a objetExiste devrait se faire avant le find, afin d'eviter un fetch dans la bd
        //      mais createObject est le dernier point commun avant de vraiement creer l'objet. 
        //commence par utiliser un objet qui a deja ete cree
        $cleUnique = $this->cleUnique($array);
        if (GestionInstance::objetExiste($this, $cleUnique)) {
            $obj = GestionInstance::extraitObjet($this, $cle);
        } else {
            //si cet objet est nouveau, on le cree et on l'enregistre
            $obj = $this->doCreateObject($array);
            GestionInstance::enregistre($this, $cleUnique, $obj);
        }
        return $obj;
    }
    
    protected function cleUnique(array $array) {
        //FIXME mettre la fonction doCleUnique abstract en bas 
        $classe = $this->classeGeree();
        $cleArray = $this->doCleUnique();
        $cleUnique = $classe;
        foreach($cleArray as $cle) {
            $cleUnique = $cleUnique . $array[$cle];
        }
        return array($cleUnique);
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
    //protected abstract function cleUnique(array $array);
}
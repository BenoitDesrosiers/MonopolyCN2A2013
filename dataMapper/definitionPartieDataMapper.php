<?php

require_once "dataMapper/mapper.php";
require_once "modele/definitionPartie.php";

class DefinitionPartieDataMapper extends Mapper {
    
    function __construct() {
        parent::__construct();
        $this->selectStmt = self::$db->prepare("SELECT * FROM DefinitionPartie where id=?");
        $this->updateStmt = self::$db->prepare('update DefinitionPartie set id=?, nom=?, Description=?, MaxNbJoueur=?  
                                                    where id=?');
        $this->insertStmt = self::$db->prepare("insert into DefinitionPartie ( nom, Description, MaxNbJoueur ) values (?, ?, ?)");
        
    }

    protected function doCreateObject( array $array) {
        
        $obj = new DefinitionPartie( );
        $obj->setId($array['Id']);
        $obj->setNom($array['Nom']);
        $obj->setDescription($array['Description']);
        $obj->setMaxNbJoueur($array['MaxNbJoueur']);
        return $obj;        
    }
    
    protected function doInsert($object) {
        if (!$this->nomLibre($object->getNom())) {
            //Verifie si il n'y a pas déjà une partie avec le même nom.
            throw new Exception('nom déjà utilisé');
        }
        //TODO ajouter un check si le coordonnateur n'est pas null ou inexistant
        $values = array($object->getNom(), 
                        $object->getDescription(), 
                        $object->getMaxNbJoueur());
        $this->insertStmt->execute($values);
        $id = self::$db->lastInsertId();
        $object->setId($id);
    }
    
    function update($object) {
        $values= array ($object->getId(), 
                        $object->getNom(), 
                        $object->getDescription(), 
                        $object->getMaxNbJoueur());
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
        $queryTxt = 'SELECT * FROM DefinitionPartie
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
    
    function selectArgent($id){
    	$queryTxt = 'SELECT * FROM DefinitionPartie_Argent
    				WHERE DefinitionPartieId = :id';
    	$query = self::$db->prepare($queryTxt);
    	$query->bindValue(':id', $id);
    	$query->setFetchMode(PDO::FETCH_ASSOC);
    	$query->execute();    	

    	$listeItems = array();
    	
    	foreach($query as $row) {
    		if ($row <> null) {
    			$listeItems[$row['ArgentMontant']] = $row['Quantite'];
    		}
    	}
    	return $listeItems;
    }
    
}
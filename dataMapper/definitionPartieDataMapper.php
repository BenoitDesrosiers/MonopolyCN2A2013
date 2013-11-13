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
            //Verifie si il n'y a pas deja une partie avec le même nom.
            throw new Exception('nom deja utilise');
        }
        //TODO ajouter un check si le coordonnateur n'est pas null ou inexistant
        $values = array($object->getNom(), 
                        $object->getDescription(), 
                        $object->getMaxNbJoueur());
        $this->insertStmt->execute($values);
        $id = self::$db->lastInsertId();
        $object->setId($id);
    }
    
    function update($object, $sujet) {
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
     * fonctions specific a ce datamapper
     */
    
    function nomLibre($nom) {
        /*
         * verifie si ce $nom est deja utilise pour une autre partie
         * 
         * Retour
         *     true: le nom n'est pas utilise
         *     false: une partie a deja ce nom
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
        /*
         * genere les billets de depart d'une partie 
         * 
         * input
         *     l'id d'une definition de partie
         * output
         *     un array associatif, la cle etant le montant du billet (ex: 50 pour un 50$), la valeur etant la quantite de ce billet
         *     
         */
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
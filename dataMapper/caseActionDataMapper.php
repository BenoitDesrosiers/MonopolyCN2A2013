<?php

require_once "dataMapper/mapper.php";
require_once "modele/caseDeJeuAction.php";

class CaseActionDataMapper extends Mapper {
    
    function __construct() {
        parent::__construct();
        $this->selectStmt = self::$db->prepare("SELECT * FROM CaseAction where id=?");
        //TODO: ajouter tous les champs
        $this->updateStmt = self::$db->prepare('UPDATE CaseAction 
        										SET ID=?, Nom=?, ActionID=?  
                                                WHERE ID=?');
        $this->insertStmt = self::$db->prepare("INSERT INTO CaseAction ( Nom, ActionID ) 
        										VALUES (?, ?)");
    }

    protected function doCreateObject( array $array) {
        $obj = new CaseDeJeuAction($array);

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
    
    function pourDefinitionPartie($idDefinitionPartie) {
        // retourne un array contenant toutes les cases actions du tableau
        
        // commence par aller chercher la liste des Id dans la table DefinitionPartie_CaseAction
        $queryTxt = 'SELECT * FROM DefinitionPartie_CaseAction
                            WHERE DefinitionPartieId = :id';
        $query = self::$db->prepare($queryTxt);
        $query->bindValue(':id', $idDefinitionPartie);
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $query->execute();
        
        $listeItems = array();
        
        foreach($query as $row) {
            $unItem = $this->find(array($row['CaseActionId']));
            if ($unItem <> null) {
                //set la position a partir de celle trouvee dans DefinitionPartie_CaseAction
                $unItem->setPosition($row['Position']);
                $listeItems[] = $unItem;
            }
        }
        return $listeItems;
    }
    
    function parPositionCase($position, $idDefinitionPartie) {
    	// retourne la case a la position dans la definition de partie donnee
    	$queryTxt = 'SELECT * FROM DefinitionPartie_CaseAction
                            WHERE Position = :position AND DefinitionPartieId = :idDefinitionPartie';
    	$query = self::$db->prepare($queryTxt);
    	$query->bindValue(':position', $position);
    	$query->bindValue(':idDefinitionPartie', $idDefinitionPartie);
    	$query->setFetchMode(PDO::FETCH_ASSOC);
    	$query->execute();
    
    	foreach($query as $row) {
    		$item = $this->find(array($row['CaseActionId']));
    		if ($item <> null) {
    			//set la position a partir de celle trouvee dans DefinitionPartie_CaseAction
    			$item->setPosition($row['Position']);
    		}
    	}
    	return $item;
    }
}
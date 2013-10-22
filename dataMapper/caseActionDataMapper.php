<?php

require_once "dataMapper/mapper.php";
require_once "modele/caseDeJeuAction.php";

class CaseActionDataMapper extends Mapper {
    
    function __construct() {
        parent::__construct();
        $this->selectStmt = self::$db->prepare("SELECT * FROM CaseAction where id=?");
        //TODO: ajouter tous les champs
        $this->updateStmt = self::$db->prepare('update CaseAction set id=?, ActionID=?, Nom=?, Image=? where id=?');
        $this->insertStmt = self::$db->prepare("insert into CaseAction ( ActionID, Nom, Image ) values (?, ?, ?)");
    }

    protected function doCreateObject( array $array) {        
        //TODO: créer 3 autres sous-clase de CaseDeJeuAction et les appeler CasePropriete, CaseTrain et CaseService et créer la bon selon le type provenant de GroupeDeCase
        $obj = new CaseDeJeuAction( );
        $obj->setId($array['ID']);
        $obj->setNom($array['Nom']);
        $obj->setImage($array['Image']);
        
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
        
        $listeItems = array();
        
        foreach($query as $row) {
            $unItem = $this->createObject($row);
            if ($unItem <> null) {
                $listeItems[] = $unItem;
            }
        }
        return $listeItems;
        
    }
    
    function pourDefinitionPartie($idDefinitionPartie) {
        // retourne un array contenant toutes les cases Action du tableau
        
        // commence par aller chercher la liste des Id dans la table DefinitionPartie_CaseAction
        $queryTxt = 'SELECT * FROM DefinitionPartie_CaseAction
                            WHERE DefinitionPartieId = :id';
        $query = self::$db->prepare($queryTxt);
        $query->bindValue(':id', $idDefinitionPartie);
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $query->execute();
        
        $listeItems = array();
        
        foreach($query as $row) {
            $unItem = $this->find($row['CaseActionId']);
            if ($unItem <> null) {
                //set la position à partir de celle trouvée dans DefinitionPartie_CaseAction
                $unItem->setPosition($row['Position']);
                $listeItems[] = $unItem;
            }
        }
        return $listeItems;
    }
}
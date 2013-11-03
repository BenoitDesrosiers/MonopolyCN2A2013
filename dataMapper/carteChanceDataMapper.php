<?php

require_once "dataMapper/mapper.php";
require_once "modele/carteChance.php";

class CarteChanceDataMapper extends Mapper {
    
    function __construct() {
        parent::__construct();
        $this->selectStmt = self::$db->prepare("SELECT * FROM Carte c where c.id=?");
        $this->updateStmt = self::$db->prepare('update Carte set id=?, ActionId=?, TypeCarte=?, Description=? 
                                                    where id=?');
        $this->insertStmt = self::$db->prepare("insert into Carte ( ActionId, TypeCarte, Description ) values (?, ?, ?)");
    }
    
    function update ($object){
        $values= array ($object->getId(), 
                        $object->getActionID(), 
                        $object->getTypeCarte(), 
                        $object->getDescription());
        $this->updateStmt->execute($values);
    }
    
    protected function doCreateObject( array $array){
        $obj = new CarteChance(); //TODO: changer pour passer un array
        $obj->setId($array['Id']);
        $obj->setDescription($array['Description']);
        $obj->setActionID($array['ActionId']);
        $obj->setType($array['TypeCarte']);
        
        return $obj;        
    }
    
    protected function doInsert( $object){
        if (!$this->nomLibre($object->getNom())) {
            //Verifie si il n'y a pas déjà une partie avec le même nom.
            throw new Exception('nom déjà utilisé');
        }
        //TODO ajouter un check si le coordonnateur n'est pas null ou inexistant
        $values = array($object->getActionID(), 
                        $object->getTypeCarte(), 
                        $object->getDescription());
        $this->insertStmt->execute($values);
        $id = self::$db->lastInsertId();
        $object->setId($id);
    }
    
    protected function selectStmt(){
        return $this->selectStmt;
    }
    
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
        // retourne un array contenant toutes les cases actions du tableau
        
        // commence par aller chercher la liste des Id dans la table PartienEnCours_CarteCC
        $queryTxt = 'SELECT * FROM PartieEnCours_CarteChance cc INNER JOIN PartieEnCours pec ON pec.Id=cc.PartieEnCoursId
                            WHERE pec.DefinitionPartieId = :id';
        $query = self::$db->prepare($queryTxt);
        $query->bindValue(':id', $idDefinitionPartie);
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $query->execute();
        
        $listeItems = array();
        
        foreach($query as $row) {
            $unItem = $this->find($row['CarteId']);
            if ($unItem <> null) {
                //set la position à partir de celle trouvée dans PartienEnCours_CarteCC
                $unItem->setPosition($row['Position']);
                $listeItems[] = $unItem;
            }
        }
        return $listeItems;
    }
    
    function parPositionCarte($position, $idDefinitionPartie) {
            // retourne un array contenant toutes les cases actions du tableau
    
            // commence par aller chercher la liste des Id dans la table PartieEnCours_CarteCC
            $queryTxt = 'SELECT * FROM PartieEnCours_CarteChance cc INNER JOIN PartieEnCours pec ON pec.Id=cc.PartieEnCoursId
                            WHERE cc.Position = :position AND pec.DefinitionPartieId = :idDefinitionPartie';
            $query = self::$db->prepare($queryTxt);
            $query->bindValue(':position', $position);
            $query->bindValue(':idDefinitionPartie', $idDefinitionPartie);
            $query->setFetchMode(PDO::FETCH_ASSOC);
            $query->execute();
    
            foreach($query as $row) {
                    $item = $this->find($row['CarteId']);
                    if ($item <> null) {
                            //set la position à partir de celle trouvée dans PartienEnCours_CarteCC
                            $item->setPosition($row['Position']);
                    }
            }
            return $item;
    }
}
<?php

require_once "dataMapper/mapper.php";
require_once "modele/carteCC.php";

class CarteCCDataMapper extends Mapper {
    
    function __construct() {
        parent::__construct();
        $this->selectStmt = self::$db->prepare("SELECT * FROM Carte c where c.id=?");
        $this->updateStmt = self::$db->prepare('update Carte set id=?, ActionId=?, TypeCarte=?, Description=? 
                                                    where id=?');
        $this->insertStmt = self::$db->prepare("insert into Carte ( ActionId, TypeCarte, Description ) values (?, ?, ?)");
    }
    
    function update ($object, $sujet) {
        $values= array ($object->getId(), 
                        $object->getActionID(), 
                        $object->getTypeCarte(), 
                        $object->getDescription());
        $this->updateStmt->execute($values);
    }
    
    protected function doCreateObject( array $array){
        $obj = new CarteCC();
        $obj->setId($array['Id']);
        $obj->setDescription($array['Description']);
        $obj->setActionID($array['ActionId']);
        $obj->setType($array['TypeCarte']);
        
        return $obj;        
    }
    
    protected function doInsert( $object){
        if (!$this->nomLibre($object->getNom())) {
            //Verifie si il n'y a pas deja une partie avec le meme nom.
            throw new Exception('nom deja utilise');
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
        $queryTxt = 'SELECT * FROM PartieEnCours_CarteCC cc INNER JOIN PartieEnCours pec ON pec.Id=cc.PartieEnCoursId
                            WHERE pec.DefinitionPartieId = :id';
        $query = self::$db->prepare($queryTxt);
        $query->bindValue(':id', $idDefinitionPartie);
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $query->execute();
        
        $listeItems = array();
        
        foreach($query as $row) {
            $unItem = $this->find($row['CarteId']);
            if ($unItem <> null) {
                //set la position a partir de celle trouvee dans PartienEnCours_CarteCC
                $unItem->setPosition($row['Position']);
                $listeItems[] = $unItem;
            }
        }
        return $listeItems;
    }
    
    function parPositionCarte($position, $idDefinitionPartie) {
            // retourne un array contenant toutes les cases actions du tableau
    
            // commence par aller chercher la liste des Id dans la table PartieEnCours_CarteCC
            $queryTxt = 'SELECT * FROM PartieEnCours_CarteCC cc INNER JOIN PartieEnCours pec ON pec.Id=cc.PartieEnCoursId
                            WHERE cc.Position = :position AND pec.DefinitionPartieId = :idDefinitionPartie';
            $query = self::$db->prepare($queryTxt);
            $query->bindValue(':position', $position);
            $query->bindValue(':idDefinitionPartie', $idDefinitionPartie);
            $query->setFetchMode(PDO::FETCH_ASSOC);
            $query->execute();
    
            foreach($query as $row) {
                    $item = $this->find($row['CarteId']);
                    if ($item <> null) {
                            //set la position a partir de celle trouvee dans PartienEnCours_CarteCC
                            $item->setPosition($row['Position']);
                    }
            }
            return $item;
    }
}
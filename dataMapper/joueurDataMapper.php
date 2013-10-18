<?php

require_once "dataMapper/mapper.php";
require_once "modele/caseDeJeuAchetable.php";

class CaseAchetableDataMapper extends Mapper {
    
    function __construct() {
        parent::__construct();
        $this->selectStmt = self::$db->prepare("SELECT * FROM JoueurPartie WHERE UsagerCompte=?
        																	AND PartieEnCoursId=");
        //TODO: ajouter tous les champs
        $this->updateStmt = self::$db->prepare("UPDATE JoueurPartie 
        										SET UsagerCompte=?, PartieEnCoursId=?, PionId=?, Position=?, OrdreDeJeu=?, EnPrison=?, ToursRestants_Prison=? 
        										WHERE UsagerCompte=? 
        										AND PartieEnCoursId=");
        $this->insertStmt = self::$db->prepare("INSERT INTO JoueurPartie ( UsagerCompte, PartieEnCoursId, PionId, Position, OrdreDeJeu, EnPrison, ToursRestants_Prison )
        										VALUES (?, ?, ?, ?, ?, ?, ?)");
    }

    protected function doCreateObject( array $array) {
        
        // va chercher de l'information additionnelle dans la table GroupeDeCase
        $queryTxt = 'SELECT * FROM GroupeDeCase
                            WHERE id = :id';
        $query = self::$db->prepare($queryTxt);
        $query->bindValue(':id', $array['GroupeDeCaseId']);
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $query->execute();
        $array2  = $query->fetch();
        
        
        //TODO: créer 3 autres sous-clase de CaseDeJeuAchetable et les appeler CasePropriete, CaseTrain et CaseService et créer la bon selon le type provenant de GroupeDeCase
        $obj = new CaseDeJeuAchetable( );
        $obj->setId($array['Id']);
        $obj->setNom($array['Titre']);
        $obj->setPrix($array['Prix']);

        // set la couleur d'après l'info de GroupeDeCase
        //TODO: la couleur devrait aller dans CasePropriete
        $obj->setCouleur($array2['Couleur']);
        $obj->setCouleurHTML($array2['CouleurHTML']);
        
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
        // retourne un array contenant toutes les cases achetable du tableau
        
        // commence par aller chercher la liste des Id dans la table DefinitionPartie_CaseAchetable
        $queryTxt = 'SELECT * FROM DefinitionPartie_CaseAchetable
                            WHERE DefinitionPartieId = :id';
        $query = self::$db->prepare($queryTxt);
        $query->bindValue(':id', $idDefinitionPartie);
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $query->execute();
        
        $listeItems = array();
        
        foreach($query as $row) {
            $unItem = $this->find($row['CaseAchetableId']);
            if ($unItem <> null) {
                //set la position à partir de celle trouvée dans DefinitionPartie_CaseAchetable
                $unItem->setPosition($row['Position']);
                $listeItems[] = $unItem;
            }
        }
        return $listeItems;
    }
    
    function parPositionCase($position, $idDefinitionPartie) {
    	// retourne un array contenant toutes les cases achetable du tableau
    
    	// commence par aller chercher la liste des Id dans la table DefinitionPartie_CaseAchetable
    	$queryTxt = 'SELECT * FROM DefinitionPartie_CaseAchetable
                            WHERE Position = :position AND DefinitionPartieId = :idDefinitionPartie';
    	$query = self::$db->prepare($queryTxt);
    	$query->bindValue(':position', $position);
    	$query->bindValue(':idDefinitionPartie', $idDefinitionPartie);
    	$query->setFetchMode(PDO::FETCH_ASSOC);
    	$query->execute();
    
    	foreach($query as $row) {
            $item = $this->find($row['CaseAchetableId']);
            if ($item <> null) {
                //set la position à partir de celle trouvée dans DefinitionPartie_CaseAchetable
                $item->setPosition($row['Position']);
            }
        }
    	return $item;
    }
}
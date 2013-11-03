<?php

require_once "dataMapper/mapper.php";
require_once "modele/caseDeJeuAchetable.php";

class CaseAchetableDataMapper extends Mapper {
    
    function __construct() {
        parent::__construct();
        $this->selectStmt = self::$db->prepare("SELECT * FROM CaseAchetable where id=?");
        //TODO: ajouter tous les champs
        $this->updateStmt = self::$db->prepare('update CaseAchetable set id=?, Titre=?, Prix=?  
                                                    where id=?');
        $this->insertStmt = self::$db->prepare("insert into CaseAchetable ( Titre, Prix ) values (?, ?)");
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
        
        
        //TODO: creer 3 autres sous-clase de CaseDeJeuAchetable et les appeler CasePropriete, CaseTrain et CaseService et crÃ©er la bon selon le type provenant de GroupeDeCase
        $obj = new CaseDeJeuAchetable( ); //TODO: a refaire en passant un array
        $obj->setId($array['Id']);
        $obj->setNom($array['Titre']);
        $obj->setPrix($array['Prix']);

        // set la couleur d'aprs l'info de GroupeDeCase
        //TODO: la couleur devrait aller dans CasePropriete
        $obj->setCouleur($array2['Couleur']);
        $obj->setCouleurHTML($array2['CouleurHTML']);
        
        return $obj;        
    }
    
    protected function doInsert($object) {
        //TODO: a faire
    }
    
    function update($object) {
        //TODO: a faire
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
            $unItem = $this->find(array($row['CaseAchetableId']));
            if ($unItem <> null) {
                //set la position a partir de celle trouvee dans DefinitionPartie_CaseAchetable
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
            $item = $this->find(array($row['CaseAchetableId']));
            if ($item <> null) {
                //set la position a partir de celle trouvee dans DefinitionPartie_CaseAchetable
                $item->setPosition($row['Position']);
            }
        }
    	return $item;
    }
}
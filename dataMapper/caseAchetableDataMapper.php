<?php

require_once "dataMapper/mapper.php";
require_once "modele/joueur.php";
require_once "modele/caseDeJeuPropriete.php";
require_once "modele/caseDeJeuServicePublic.php";
require_once "modele/caseDeJeuTrain.php";

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
     
       if($array2['IsCheminDeFer']==1)
        	$obj = new CaseDeJeuTrain($array );
        elseif($array2['IsServicePublique']==1)
        	$obj = new CaseDeJeuServicePublic($array);
        else {
            $array["GroupeDeCaseId"] = $array2["Id"];
            $array["Couleur"] = $array2["Couleur"];
            $array["CouleurHTML"] = $array2["CouleurHTML"];
        	$obj = new CaseDeJeuPropriete($array); 
        }
        return $obj;        
    }
    
    protected function doInsert($object) {
        //TODO: a faire
    }
    
    function update($object, $sujet) {
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
    
    function insertProprietaire(Joueur $joueur, CaseDeJeuAchetable $case) {
    	/*TODO: le changer pour faire un set en faisant un delete si necessaire avant le insert. Faudrait transferer l'info existante
    	 * ajoute une entre dans la table JoueurPartie_CaseAchetable pour indiquer que 
    	 * la $case appartient au $joueur 
    	 * 
    	 * input 
    	 *     $joueur : le joueur a qui cette case sera assignee
    	 *     $case : la case a ajouter au joueur
    	 *     
    	 */
    	$queryTxt2 = "insert into JoueurPartie_CaseAchetable ( JoueurPartieUsagerCompte, JoueurPartiePartieEnCoursId, CaseAchetableId, OrdreAffichage, Hypotheque, NombreMaisons, NombreHotels) values (?, ?, ?, ?, ?, ?, ?)";
    	$query = self::$db->prepare($queryTxt2);
    	$values = array ($joueur->getCompte(),
    					 $joueur->getPartieId(),
    					 $case->getId(),
    					 "1", 
    					 "0",
    					 "0",
    					 "0");
    	$query->execute($values);
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
    
   /* obsolete
    *  static function loadPrix($proprieteId) {
        // retourne un array contenant tout les prix de la propriete
    
        // commence par aller chercher les prix dans la table CaseAchetable
        $queryTxt = 'SELECT * FROM CaseAchetable
        				WHERE Id = :id';
        $query = self::$db->prepare($queryTxt);
        $query->bindValue(':id', $proprieteId);
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $query->execute();
    
        $listePrix = $query->fetch();
       
        return $listePrix;
    }
    */
}
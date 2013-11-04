<?php

require_once "dataMapper/mapper.php";
require_once "modele/caseDeJeuAchetable.php";
require_once "modele/joueur.php";

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
        
        
        
        //TODO: creer 3 autres sous-clase de CaseDeJeuAchetable et les appeler CasePropriete, CaseTrain et CaseService et créer la bon selon le type provenant de GroupeDeCase
        $obj = new CaseDeJeuAchetable( ); //TODO: a refaire en passant un array
        $obj->setId($array['Id']);
        $obj->setNom($array['Titre']);
        $obj->setPrix($array['Prix']);

        // set la couleur d'apr�s l'info de GroupeDeCase
        //TODO: la couleur devrait aller dans CasePropriete
        $obj->setCouleur($array2['Couleur']);
        $obj->setCouleurHTML($array2['CouleurHTML']);
        
        // on le fait pas ici car ces champs viennent d'une autre table et faire le set engendrerait un notify 
        //set le propriétaire et ses propriétés si applicable
        /*$obj->setProprietaire($array3['JoueurPartieUsagerCompte']);
        $obj->setNombreMaison($array3['NombreMaisons']);
        $obj->setNombreHotel($array3['NombreHotels']);
        */
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

    function insertProprietaire(Joueur $joueur, CaseDeJeuAchetable $case) {
    	/*
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
    	$values = array ($object->getCompte(),
    					 "1",
    					 $case->getId(),
    					 "1", 
    					 "0",
    					 "0",
    					 "0");
    	$query->execute($values);
    }
    
    function getProprietairePourPartieId(CaseAchetable $case, int $partieId) {
        /*
         * retourne le proprietaire de cette case pour cette partie
         * input
         *     $partieId : un id de partie
         * output
         *     le joueur a qui appartient cette case dans cette partie
         *     Null si la case appartient � personne dans cette partie
         *
         */
        // va chercher de l'information additionelle de la table joueurpartie_caseachetable
        $queryTxt = 'SELECT * FROM joueurpartie_caseachetable where CaseAchetableId= :id and JoueurPartiePartieEnCoursId= :partieId ';  //TODO: besoin du id de partie
        $query = self::$db->prepare($queryTxt);
        $query->bindValue(':id', $case->getId());
        $query->bindValue(':partieId', $partieId);
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $query->execute();
        $row  = $query->fetch();
        if (!is_array($row)){// le query a rien retourne, il n'y a donc pas de proprietaire pour cette partie
            $proprietaire = null;
        } else {
            $proprietaire = Joueur::parComptePartie($row['JoueurPartieUsagerCompte'], $partieId);
        }
        return $proprietaire;
        
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
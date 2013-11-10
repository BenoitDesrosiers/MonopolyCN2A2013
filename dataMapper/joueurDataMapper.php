<?php

require_once "dataMapper/mapper.php";
require_once "modele/joueur.php";

class JoueurDataMapper extends Mapper {
    
    function __construct() {
        parent::__construct(); 
        
        $this->selectStmt = self::$db->prepare("SELECT * FROM JoueurPartie WHERE usagercompte = ? AND partieencoursid =? ");
        $this->updateStmt = self::$db->prepare("update JoueurPartie set UsagerCompte = ?, PartieEncoursId = ?, PionId = ?, Position = ?, OrdreDeJeu = ?, EnPrison = ?, ToursRestants_Prison = ?
                                                where usagercompte = ? AND partieencoursid =? ");
        $this->insertStmt = self::$db->prepare("insert into JoueurPartie ( UsagerCompte, PartieEncoursId, PionId, Position, OrdreDeJeu, EnPrison, ToursRestants_Prison ) values (?,?,?,?,?,?,?)");
        
    }
    
    protected function doCreateObject( array $array) {
        $joueur = new Joueur($array) ;
        $joueur->attache($this);
        return $joueur;
    }
    
    
    protected function doInsert( $objet) {
        //TODO: ajouter le check si l'objet est déjà dans la BD. 
        $values = array($objet->getCompte(), $objet->getPartieId(), $objet->getPionId(), $objet->getPosition(),$objet->getOrdreDeJeu(), $objet->getEnPrison(), $objet->getToursRestantEnPrison() );
        $this->insertStmt->execute($values);
    }
    
    function update($objet) {
        $values= array ($objet->getCompte(), $objet->getPartieId(), $objet->getPionId(), $objet->getPosition(),$objet->getOrdreDeJeu(), $objet->getEnPrison(), $objet->getToursRestantEnPrison(),
                        $objet->getCompte(), $objet->getPartieId());
        $this->updateStmt->execute($values);        
    }
    
    

    function selectStmt() {
        return $this->selectStmt;
    }
    

    function findPourPartie($partieId) {
        /*
		 * crée les joueurs associés à une partie 
		 *
         * input
        *     $partieId: l'id d'une partie
        * output
        *     un array contenant les joueurs associées à la partie.
        *     un array vide si aucun joueur n'est trouvé
        *
        */
        
        $queryTxt = 'SELECT * FROM JoueurPartie
                        WHERE  partieencoursid = :partieId';
        $query = self::$db->prepare($queryTxt);
        $query->bindValue(':partieId', $partieId);
        return $this->findAll($query);
    } 
       
}
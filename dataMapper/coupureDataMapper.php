<?php

require_once "dataMapper/mapper.php";
require_once "modele/coupure.php";

class CoupureDataMapper extends Mapper {
    
    function __construct() {
        parent::__construct(); 
        
        $this->selectStmt = self::$db->prepare("SELECT * FROM JoueurPartie_argent WHERE JoueurPartieUsagerCompte = ? AND JoueurPartiePartieEnCoursId =? ");
        //$this->insertStmt = self::$db->prepare("insert into JoueurPartie ( UsagerCompte, PartieEncoursId, PionId, Position, OrdreDeJeu, EnPrison, ToursRestants_Prison ) values (?,?,?,?,?,?,?)");
    }
    
    protected function doCreateObject( array $array) {
        
        return new Coupure($array) ;
    }
    
    public function findCoupuresPour($compte, $partieId) {
        $queryTxt = "SELECT * FROM JoueurPartie_Argent WHERE JoueurPartieUsagerCompte = :joueurId AND JoueurPartiePartieEnCoursId = :partieId";
        $query = self::$db->prepare($queryTxt);
        $query->bindValue(':joueurId', $compte);
        $query->bindValue(':partieId', $partieId);
        return $this->findAll($query);
    }
    protected function doInsert( $objet) {
        //TODO: ajouter le check si l'objet est déjà dans la BD. 
        //$values = array($objet->getCompte(), $objet->getPartieId(), $objet->getPionId(), $objet->getPosition(),$objet->getOrdreDeJeu(), $objet->getEnPrison(), $objet->getToursRestantEnPrison() );
        $this->insertStmt->execute($values);
    }
    
    function update($objet) {
        //$values= array ($objet->getCompte(), $objet->getPartieId(), $objet->getPionId(), $objet->getPosition(),$objet->getOrdreDeJeu(), $objet->getEnPrison(), $objet->getToursRestantEnPrison());
        //$this->updateStmt->execute($values);        
    }
    
    function selectStmt() {
        return $this->selectStmt;
    }
    
 
  
}
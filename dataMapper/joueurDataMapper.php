<?php

require_once "dataMapper/mapper.php";
require_once "modele/joueur.php";

class JoueurDataMapper extends Mapper {
    
    function __construct() {
        parent::__construct(); 
        
        $this->selectStmt = self::$db->prepare("SELECT * FROM JoueurPartie WHERE usagercompte = ? AND partieencoursid =? ");
        $this->insertStmt = self::$db->prepare("insert into JoueurPartie ( UsagerCompte, PartieEncoursId, PionId, Position, OrdreDeJeu, EnPrison, ToursRestants_Prison ) values (?,?,?,?,?,?,?)");
        
        
        $this->selectArgentStmt = self::$db->prepare("SELECT * FROM Usager where compte=?");
        $this->updateArgentStmt = self::$db->prepare('update Usager set compte=?, password=?, nom=?, role=?,  where compte=?');
        $this->insertArgentStmt = self::$db->prepare("insert into Usager ( compte, password, nom, role ) values (?, ?)");
       
    }
    
    protected function doCreateObject( array $array) {
        return new Joueur($array) ;
    }
    
    
    protected function doInsert( $objet) {
        //TODO: ajouter le check si l'objet est déjà dans la BD. 
        $values = array($objet->getCompte(), $objet->getPartieId(), $objet->getPionId(), $objet->getPosition(),$objet->getOrdreDeJeu(), $objet->getEnPrison(), $objet->getToursRestantEnPrison() );
        $this->insertStmt->execute($values);
    }
    
    function update($objet) {
        $values= array ($objet->getCompte(), $objet->getPartieId(), $objet->getPionId(), $objet->getPosition(),$objet->getOrdreDeJeu(), $objet->getEnPrison(), $objet->getToursRestantEnPrison());
        $this->updateStmt->execute($values);        
        $this->updateArgent($objet);
    }
    
    function updateArgent($objet) {
        
    }
    
    function selectStmt() {
        return $this->selectStmt;
    }
    
  
}
<?php

require_once "dataMapper/mapper.php";
require_once "dataMapper/usagerDataMapper.php";

require_once "modele/usager.php";
require_once "modele/joueur.php";

class JoueurDataMapper extends UsagerDataMapper {
    
    function __construct() {
        parent::__construct(); 
        
        $this->selectStmt = self::$db->prepare("SELECT * FROM JoueurPartie as j, Usager as u WHERE j.usagercompte = u.compte AND j.usagercompte = ? AND j.partieencoursid =? ");
        $this->insertStmt = self::$db->prepare("insert into JoueurPartie ( UsagerCompte, PartieEncoursId, PionId, Position, OrdreDeJeu, EnPrison, ToursRestants_Prison ) values (?,?,?,?,?,?,?)");
        
        
        $this->selectArgentStmt = self::$db->prepare("SELECT * FROM Usager where compte=?");
        $this->updateArgentStmt = self::$db->prepare('update Usager set compte=?, password=?, nom=?, role=?,  where compte=?');
        $this->insertArgentStmt = self::$db->prepare("insert into Usager ( compte, password, nom, role ) values (?, ?)");
       
    }
    
    protected function doCreateObject( array $array) {
        return new Joueur($array) ;
    }
    
    
    protected function doInsert( $object) {
        // pour qu'on ajoute un joueur, il faut d'abord que l'usager correspondant ait été créé 
        // il ne reste donc qu'a créer l'entré dans la table JoueurPartie
        $values = array($object->getCompte(), $object->getPartieEnCours(), $object->getPionId(), $object->getPosition(),$object->getOrdreDeJeu(), $object->getEnPrison(), $object->getToursRestants_Prison() );
        $this->insertStmt->execute($values);
    }
    
    function update($object) {
        parent::update($object);
        $this->updateArgent($object);
    }
    
    function updateArgent($object) {
        
    }
    
    function selectStmt() {
        return $this->selectStmt;
    }
    
  
}
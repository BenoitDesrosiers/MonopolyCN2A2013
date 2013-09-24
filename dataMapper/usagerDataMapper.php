<?php

require_once "dataMapper/mapper.php";
require_once "modele/usager.php";
require_once "modele/coordonnateur.php";
require_once "modele/joueur.php";

class UsagerDataMapper extends Mapper {
    
    function __construct() {
        //CONNECTION 1.2.4.2.1 : batit le datamapper. Faire un 'new' appele "__construct"
        parent::__construct(); // "parent" veut dire "cette méthode de ma superclasse. 
        $this->selectStmt = self::$db->prepare("SELECT * FROM Usagers where compte=?");
        $this->updateStmt = self::$db->prepare('update Usagers set compte=?, password=?, nom=?, role=?,  where compte=?');
        $this->insertStmt = self::$db->prepare("insert into Usagers ( compte, password, nom, role ) values (?, ?)");
        
    }

    protected function doCreateObject( array $array) {
        //CONNECTION 1.2.4.3.2.1 choisit si on fait un coordonnateur ou un joueur
        switch ($array['role']) {
            case 'coordonnateur' :
                $obj = new Coordonnateur($array['password'], $array['compte'], $array['nom']);
                break;
            case 'joueur' :
                $obj = new Joueur($array['password'], $array['compte'], $array['nom']);
                break;
        }
        return $obj;        
    }
    
    protected function doInsert( $object) {
        //TODO: ajouter une exception si le compte est déja utilisé
        $values = array($object->getCompte(), $object->getPassword(), $object->getNom(), $object->getRole());
        $this->insertStmt->execute($values);
    }
    
    function update($object) {
        $values= array ($object->getCompte(), $object->getPassword(), $object->getNom(), $object->getRole(), $object->getCompte());
        $this->updateStmt->execute($values);
    }
    
    function selectStmt() {
        return $this->selectStmt;
    }
    
    
    function findPourCoordonnateur( $idCoordonnateur) {
        // crée les parties associées à un coordonnateur a partir de la db
        
        /*
         * input
        *     $idCoordonnateur: l'id du coordonnateur
        * output
        *     un array contenant les parties associées au coordonnateur.
        *     un array vide si aucune partie n'est associée au coordonnateur
        *
        */
        
        $queryTxt = 'SELECT * FROM PartiesEnCours
                        WHERE coordonnateur = :coordonnateur';
        $query = self::$db->prepare($queryTxt);
        $query->bindValue(':coordonnateur', $idCoordonnateur);
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
}
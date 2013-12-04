<?php

require_once "dataMapper/usagerDataMapper.php";
require_once "modele/coordonnateur.php";

class CoordonnateurDataMapper extends UsagerDataMapper {
 
    function __construct() {
        parent::__construct();
    }

    protected function doCreateObject( array $array) {
        return new Coordonnateur($array) ;        
    }
    protected function classeGeree() {
        return "Coordonnateur";
    }
    
    
    public function findAllCoordonnateur() {
        $queryTxt = "SELECT * FROM Usager WHERE Role = 'coordonnateur'";
        $query = self::$db->prepare($queryTxt);
        return $this->findAll($query);
    }
    
    
   
}
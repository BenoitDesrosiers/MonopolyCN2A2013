<?php

require_once "dataMapper/usagerDataMapper.php";
require_once "modele/coordonnateur.php";

class CoordonnateurDataMapper extends UsagerDataMapper {
 
    function __construct() {
        parent::__construct();
        $this->selectAllStmt = self::$db->prepare("SELECT * FROM Usager WHERE Role = 'coordonnateur'");
    }

    protected function doCreateObject( array $array) {
        return new Coordonnateur($array) ;        
    }
   
    function selectAllStmt() {
        return $this->selectAllStmt;
    }
   
}
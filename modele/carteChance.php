<?php 

require_once "modele/carte.php";
require_once "interface/entreposageDatabase.php";
require_once "dataMapper/carteChanceDataMapper.php";


class CarteChance extends Carte{
    
    // static Factory
    static function pourDefinitionPartie($idDefinitionPartie) {
        $dataMapper = new CarteChanceDataMapper();
        return $dataMapper->pourDefinitionPartie($idDefinitionPartie);
    }
    
    static function parPositionCarte($positionCarte, $idDefinitionPartie) {
            $dataMapper = new CarteChanceDataMapper();
            return $dataMapper->parPositionCarte($positionCarte, $idDefinitionPartie);
    }
    
    public function getDataMapper() {
        return new CarteChanceDataMapper();
    }
    
    public function sauvegarde() {
        $this->getDataMapper()->insert($this);
    }
}
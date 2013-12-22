<?php 

require_once "modele/carte.php";
require_once "interface/entreposageDatabase.php";
require_once "dataMapper/carteCCDataMapper.php";


class CarteCC extends Carte{
    
    // static Factory
    static function pourDefinitionPartie($idDefinitionPartie) {
        $dataMapper = new CarteCCDataMapper();
        return $dataMapper->pourDefinitionPartie($idDefinitionPartie);
    }
    
    static function parPositionCarte($positionCarte, $idDefinitionPartie) {
            $dataMapper = new CarteCCDataMapper();
            return $dataMapper->parPositionCarte($positionCarte, $idDefinitionPartie);
    }
    
    static function pourJoueur($joueur){
    	$dataMapper = new CarteCCDataMapper();
    	return $dataMapper->pourJoueurPourPartie($joueur->getCompte(), $joueur->getPartieId());
    }
    
    public function getDataMapper() {
        return new CarteCCDataMapper();
    }
    
    public function sauvegarde() {
        $this->getDataMapper()->insert($this);
    }
    
    public function execute($joueur){
    
    }
}
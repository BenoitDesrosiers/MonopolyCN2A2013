<?php 

require_once "modele/carte.php";
require_once "modele/paiementAuxJoueurs.php";
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
    
    static function pourJoueur($joueur){
    	$dataMapper = new CarteChanceDataMapper();
    	return $dataMapper->pourJoueurPourPartie($joueur->getCompte(), $joueur->getPartieId());
    }
    
    public function getDataMapper() {
        return new CarteChanceDataMapper();
    }
    
    public function sauvegarde() {
        $this->getDataMapper()->insert($this);
    }
    
    public function execute($joueur){
        switch($this->getActionID()){
            case 29:
                $xyz = new PaiementAuxJoueurs();
                $xyz->execute($joueur, 50);
                break;
            // Ajouter les autres actions des cartes chances
        }
    }
}
<?php 

require_once "modele/carte.php";
require_once "modele/paiementAuxJoueurs.php";
require_once "interface/entreposageDatabase.php";
require_once "dataMapper/carteChanceDataMapper.php";
require_once "modele/joueur.php";
require_once "modele/caseDeJeu.php";


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
    
    public function execute(Joueur $joueur){
        switch($this->getActionID()){
            case 29:
                $xyz = new PaiementAuxJoueurs();
                $xyz->execute($joueur, 50);
                break;
            case 24:
            	$joueur->setPosition($joueur->getPosition()-3); //nouvelle position du joueur
            	
            	$partie = Partie::parId($joueur->getPartieId()); //4 lignes de code qui cause "l'atterissage" du joueur sur la nouvelle case
            	$tableau = $partie->getTableau();				 //J'assume que la version du code que j'ai est à jour, sinon la partie "atterir sur" devra être mise à jour
            	$case = $tableau->getCaseParPosition($joueur->getPosition());
            	$case->atterrirSur($joueur);
            	
            	break;
            case 27:
            	$joueur->setPosition(CaseDeJeuAchetable::parId(5)->getPosition()); //nouvelle position du joueur
            	
            	$partie = Partie::parId($joueur->getPartieId()); //4 lignes de code qui cause "l'atterissage" du joueur sur la nouvelle case
            	$tableau = $partie->getTableau();				 //J'assume que la version du code que j'ai est à jour, sinon la partie "atterir sur" devra être mise à jour
            	$case = $tableau->getCaseParPosition($joueur->getPosition());
            	$case->atterrirSur($joueur);
            	
            	if ($joueur->getPosition()>CaseDeJeuAchetable::parId(5)->getPosition()) { //si le joueur est plus "loin" que reading, il passe forcement par go donc encaisse 200$
            		$joueur->encaisse(200);
            	}
            	
            	break;
            	
            // Ajouter les autres actions des cartes chances
        }
    }
}
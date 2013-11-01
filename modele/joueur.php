<?php
require_once "interface/entreposageDatabase.php";
require_once('modele/usager.php');
require_once('modele/caseDeJeu.php');
require_once('dataMapper/joueurDataMapper.php');
require_once('modele/database.php');

class Joueur extends Usager implements EntreposageDatabase {
	
	public $argent = array();
	
    //fonctions pour jouer
	public function brasseDes() {
	    
	}
	
	public function avanceSurCase(CaseDeJeu $uneCase) {
	     
	}
	
	public function encaisse( $montant) {
		//cause un avertissement car je n'ai aucune variable a mettre dedans
		JoueurDataMapper::updateArgent('500', $this, $montant['500']);
		JoueurDataMapper::updateArgent('100', $this, $montant);
		JoueurDataMapper::updateArgent('50', $this, $montant);
		JoueurDataMapper::updateArgent('20', $this, $montant);
		JoueurDataMapper::updateArgent('10', $this, $montant);
		JoueurDataMapper::updateArgent('5', $this, $montant);
		JoueurDataMapper::updateArgent('1', $this, $montant);
		
		/*$this->getDataMapper()->updateArgent('500', $this, $montant);
		$this->getDataMapper()->updateArgent('100', $this, $montant);
		$this->getDataMapper()->updateArgent('50', $this, $montant);
		$this->getDataMapper()->updateArgent('20', $this, $montant);
		$this->getDataMapper()->updateArgent('10', $this, $montant);
		$this->getDataMapper()->updateArgent('5', $this, $montant);
		$this->getDataMapper()->updateArgent('1', $this, $montant);*/
	}
	
	public function paye( $montant) {
	    //fonction a Véro censée retourner un array de billets a encaisser ensuite
	}
	
	public function chargerLoyerA($locataire, $loyer){
		$this->encaisse($locataire->paye($loyer));
		$this->encaisse($loyer);
	}
	
	public function getRole() {
	    return 'joueur';
	}
	
}
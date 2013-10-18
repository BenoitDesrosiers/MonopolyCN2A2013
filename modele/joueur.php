<?php
require_once "interface/entreposageDatabase.php";
require_once('modele/usager.php');
require_once('modele/caseDeJeu.php');

class Joueur extends Usager implements EntreposageDatabase {
    
	protected $posJoueur;
	
    //fonctions pour jouer
	public function brasseDes() {
		// Création des dés
		$des1 = array('ID' => 0, 'Val' => 3);
		$des2 = array('ID' => 1, 'Val' => 5);
		
		// Ajustement de la position du joueur
		$this->setPosition($this->getPosition() + $des1['Val'] + $des2['Val']);
				
		// Créer et lancer une case de jeu		
		$uneCase = null;
		
		foreach (CaseDeJeuAchetable::pourDefinitionPartie(1) as $caseAchetable) :
			if ($caseAchetable->getPosition() == $this->getPosition()) :
				$uneCase = CaseDeJeuAchetable::parPositionCase($this->getPosition(), 1);
			endif;
		endforeach;
		
		if ($uneCase == null) :
			foreach (CaseDeJeuAction::pourDefinitionPartie(1) as $caseAction) :
				if ($caseAction->getPosition() == $this->getPosition()) :
					$uneCase = CaseDeJeuAction::parPositionCase($this->getPosition(), 1);
				endif;
			endforeach;
		endif;
		
		if ($uneCase == null) :
			echo "ATTENTION: Erreur lors de l'attribution de l'objet case achetable/case action par la position";
		endif;
		
		$this->avanceSurCase($uneCase);
	}
	
	public function avanceSurCase(CaseDeJeu $uneCase) {
	     if ($uneCase->getType() == "achetable") :
	     	$uneCase->atterrirSur($this);
	     elseif ($uneCase->getType() == "action") :
	     	$uneCase->atterrirSur($this);
	     else :
	     	echo "ATTENTION: Erreur lors de l'identification du type de la case!";
	     endif;
	}
	
	public function encaisse( $montant) {
	    
	}
	
	public function paye( $montant) {
	    
	}
	
	public function getRole() {
	    return 'joueur';
	}
	
	//TODO: Enlever cette fonction dès que le joueurDataMapper sera créé.
	public function setPosition($position) {
		if ($position > 39) :
			$position = $position - 40;
		endif;
		
		$this->posJoueur = $position;
	}
	
	//TODO: Enlever cette fonction dès que le joueurDataMapper sera créé.
	public function getPosition() {
		return $this->posJoueur;
	}
	
	
}
<?php
require_once "interface/entreposageDatabase.php";
require_once('modele/usager.php');
require_once('modele/caseDeJeu.php');

class Joueur extends Usager implements EntreposageDatabase {
    
	protected $posJoueur;
	
    //fonctions pour jouer
	public function brasseDes() {
		// Création de la partie et set des dés
		$partie = Partie::parId(1);
		$partie->genererValeursDes();
		
		// Ajustement de la position du joueur en ajoutant la valeur des dés à la valeur de la position actuelle du joueur.
		$this->setPosition($this->getPosition() + $partie->valeurDes());
				
		// Créer et lancer une case de jeu		
		$uneCase = null;
		
		foreach (CaseDeJeu)
		
		
		/*
		// Vérifie si la case est une case achetable
		foreach (CaseDeJeuAchetable::pourDefinitionPartie(1) as $caseAchetable) :
			if ($caseAchetable->getPosition() == $this->getPosition()) :
				$uneCase = CaseDeJeuAchetable::parPositionCase($this->getPosition(), 1);
			endif;
		endforeach;
		
		// Si la case est null, vérifie si la case est une case action
		if ($uneCase == null) :
			foreach (CaseDeJeuAction::pourDefinitionPartie(1) as $caseAction) :
				if ($caseAction->getPosition() == $this->getPosition()) :
					$uneCase = CaseDeJeuAction::parPositionCase($this->getPosition(), 1);
				endif;
			endforeach;
		endif;
		*/
		
		// Si la case est null, une erreur est survenue
		if ($uneCase == null) :
			echo "ATTENTION: Erreur lors de l'attribution de l'objet case achetable/case action par la position";
		endif;
		
		$this->avanceSurCase($uneCase);
		
		/// Output Tests ///
		echo "Dice value: ".$partie->getPremierDes().", ".$partie->getDeuxiemeDes();
		echo "<br/>";
		echo $uneCase->getNom()." est une ".$uneCase->getType();
		////////////////////
		
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
		while ($position > 39) :
			$position = $position - 40;
		endwhile;
		
		$this->posJoueur = $position;
	}
	
	//TODO: Enlever cette fonction dès que le joueurDataMapper sera créé.
	public function getPosition() {
		return $this->posJoueur;
	}
	
	
}
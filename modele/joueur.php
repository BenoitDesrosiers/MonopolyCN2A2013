<?php
require_once "interface/entreposageDatabase.php";
require_once('modele/usager.php');
require_once('modele/caseDeJeu.php');

class Joueur extends Usager implements EntreposageDatabase {
    
	protected $posJoueur;
	
    //fonctions pour jouer
	public function brasseDes() {
		// Cr�ation de la partie et set des d�s
		$partie = Partie::parId(1);
		$partie->genererValeursDes();
		
		// Ajustement de la position du joueur en ajoutant la valeur des d�s � la valeur de la position actuelle du joueur.
			// ATTENTION : Pr�sentement, le setPosition est plac� dans cette classe en attendant que le dataMapper de joueur soit cr��. (Voir lignes 72 � 84)
		$this->setPosition($this->getPosition() + $partie->valeurDes());
				
		// Cr�er et lancer une case de jeu		
		$uneCase = null;
		
		// V�rifie si la case est une case achetable
		foreach ($partie->getTableau()->getCases() as $case) :
			if ($case->getPosition() == $this->getPosition()) :
				$uneCase = $case;
			endif;
		endforeach;
		
		// Si la case est null, une erreur est survenue
		if ($uneCase == null) :
			echo "ATTENTION: Erreur lors de l'attribution de l'objet case achetable/case action par la position";
		endif;
		
		$this->avanceSurCase($uneCase);
		
		/// Output Tests ///
		echo "Dice values: ".$partie->getPremierDes().", ".$partie->getDeuxiemeDes();
		echo "<br/>";
		echo $uneCase->getNom()." est une ".$uneCase->getType();
		/////////////////////
		
	}
	
	public function avanceSurCase(CaseDeJeu $uneCase) {
		$uneCase->atterrirSur($this);
	}
	
	public function encaisse( $montant) {
	    
	}
	
	public function paye( $montant) {
	    
	}
	
	public function getRole() {
	    return 'joueur';
	}
	
	//TODO: Enlever cette fonction d�s que le joueurDataMapper sera cr��.
	public function setPosition($position) {
		while ($position > 39) :
			$position = $position - 40;
		endwhile;
		
		$this->posJoueur = $position;
	}
	
	//TODO: Enlever cette fonction d�s que le joueurDataMapper sera cr��.
	public function getPosition() {
		return $this->posJoueur;
	}
	
	
}
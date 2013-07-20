<?php

require_once 'modele/partie.php';

abstract class Usager {
	protected $nom;
	protected $compte;
	protected $password;
	protected $role;
	
	
	
	// Hydratation de l'objet
	public function hydrate(array $donnees) {
	    foreach ($donnees as $cle => $valeur) {
	        $method = 'set'.ucfirst($cle);
	        if (method_exists($this, $method)) {
	            $this->$method($valeur);
	        }
	    }
	}
	
	public function reinitialise() {
		$value = null;
		$this->setCompte($value);
		$this->setNom($value);
		$this->setPassword($value);
	}
	
	public function getCompte() { return $this->compte;}
	public function setCompte($value) { $this->compte = $value;}
	    
	
	public function getNom() { return $this->nom; }
	public function setNom($value) { $this->nom = $value; }
	
	public function getPassword() {
		return $this->password;
	}
	public function setPassword($value) {
		$this->password = $value;
	}
	
	
	public function validePW($password) {
		return sha1($password)==$this->password;
	}
	
	public function estCharge() {
		//est-ce que l'objet est charge en memoire a partir de la db
		return ($this->compte <> null);
	}
	
	abstract public function getRole();
	
    // function de Jeu

	public function joindrePartie(Partie $unePartie) {
	    
	}

}
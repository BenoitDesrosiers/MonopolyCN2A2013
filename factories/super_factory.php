<?php
/*
 * super_factory
 * la superclasse de toutes les factories
 * la factory est un singleton
 * 
 */

abstract class Super_Factory { 
	//la variable $_SESSION["lesFactories"] sert à entreposer les factories d'une sessions à l'autre
	//TODO: verifier que les factories sont bien effacer quand on ferme la session 
	//Etant donne que cette variable est unique pour TOUTES les factories
	// je dois en faire un array qui sera indexe par le nom de la sous-classe appelante
	
    protected static $listeItems = array(); // array associative contenant les items qui ont déjà été créés
    
	private function __construct() {
		// ca fait rien
	}
	
	public static function singleton() {
		$class = get_called_class();
		//get_called_class() est nouveau dans PHP 5.3.
		//Il fait parti des fonctions ajoutees pour le "late static binding".
		$instances = $_SESSION['lesFactories'];
		if (!isset($instances[$class])) {
			$instances[$class] = new $class(); 
			$_SESSION['lesFactories']=$instances;
		}
		
		return $instances[$class];
	}
	
	public function __clone() {
		// prévient le clonage
		trigger_error('Clonage non autorise.', E_USER_ERROR);
	}
	

}

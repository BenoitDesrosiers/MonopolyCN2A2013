<?php

require_once "modele/definitionPartie.php";


//require_once "interface/entreposageDatabase.php";
//FIXME: si je mets l'interface, ca ne fonctionnne pas

class Tableau {  

    protected $cases;
    


    function __construct() {
       
    }

    // Static Factory
    
    public static function pourDefinition($idDefinition) {
        //retourne un tableau base sur une definition de partie
        $definition = DefinitionPartie::parId($idDefinition);
        $tableau = new Tableau();
        $tableau->setCases($definition->getListeCases());
        return $tableau;
    }
   
    //Getters & Setters
    public function getCases() {
        return $this->cases;
    }
	
    public function setCases($value) {
        $this->cases = $value;
    }
    
	public function getCaseParPosition($position) {
	    //TODO: changer pour une array associative
		$i = 0;
		$stop = false;
		
		while ($stop != true)
		{
			// Si $i dépasse le nombre d'entrées, il sort de la boucle.
			if ($i > (count($this->cases) - 1)) //TODO: utiliser le getter
				$stop = true;
			// Si $position est égal à la position d'une case, il sort de la boucle.
			else if ($position == $this->cases[$i]->getPosition())
				$stop = true;				
			$i++;
		}
		
		// Si notre sortie de boucle a été causée par l'atteinte de la fin du tableau, on retourne null.
		if ($i > count($this->cases))
		{
			return null;
		}
		// Si notre sortie de boucle a été causée car la case a été trouvée, on retourne la case.
		else
		{
			return $this->cases[$i - 1];
		}
	}
	



}
<?php

require_once "modele/definitionPartie.php";


//require_once "interface/entreposageDatabase.php";
//FIXME: si je mets l'interface, ca ne fonctionnne pas

class Tableau {  //implements EntreposageDatabase {

    protected $cases;
    


    function __construct() {
       
    }

    // Static Factory
    
    public static function pourDefinition($idDefinition) {
        //retourne un tableau basé sur une définition de partie
        $definition = DefinitionPartie::parId($idDefinition);
        $tableau = new Tableau();
        $tableau->setCases($definition->getListeCases());
        return $tableau;
    }
   
    // interface entreposageDatabase
    public function getDataMapper() {
        return new TableauDataMapper();
    }
    
    public function sauvegarde() {
        $this->getDataMapper->insert($this);
    }
    
    //Getters & Setters
    public function getCases() {
        return $this->cases;
    }
	
	public function getCaseByPosition($position) {
		$i = 0;
		$stop = false;
		
		while ($stop != true)
		{
			// Si $i dépasse le nombre d'entrées, il sort de la boucle.
			if ($i > (count($this->cases) - 1))
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
	
    public function setCases($value) {
        $this->cases = $value;
    }

}
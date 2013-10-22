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
        //TODO: j'ai juste les cases achetable pour l'instant
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
    
    public function getCaseParPosition($position)
    {
    	$x =0;
    	$c = count($this->cases);
    	//while(($this->cases[$x]->getPosition())!=$position && $x<$c)
    		//{
    		//	$x=$x+1;
    		//}
    		//if($x < $c)
    		//{
    		//return $this->cases[$x];
    		//}
    		//else
    		//{
    			//$this->cases = null;
    			//return $this->cases;
    		//}
    		
    	for($x =0; $x<$c;$x++)
    	{
    		if(($this->cases[$x]->getPosition())==$position)
    		{
    			return $this->cases[$x];
    		}
    		if($x == $c-1)
    		{
    			return null;
    		}
    	}
    }
    
    public function setCases($value) {
        $this->cases = $value;
    }
    

}
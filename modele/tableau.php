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
    public function getCasesParPosition($position){
    	$i =0;
    	while($position != $this->cases[$i]->getPosition()){
    		if($position == $this->cases[$i]->getPosition()){
    			$position = $this->cases[$i]->getPosition();
    		}
   			$i++;
   			
    	}
		return $cases[$i];
    }
    public function setCases($value) {
        $this->cases = $value;
    }

}
<?php

require_once "modele/caseDeJeu.php";
require_once "interface/entreposageDatabase.php";
require_once "dataMapper/caseActionDataMapper.php";
require_once "modele/actionCarte.php";

class CaseDeJeuAction extends CaseDeJeu {
    protected $image;
    protected $actionId;

    function __construct(array $array) {
        /*
         * input
        *     un array associative contenant le
        *     'Id' : le compte ,
        *     'Titre' : le nom de la case
        */
        parent::__construct($array);
        $this->setId($array["ID"]);
        $this->setNom($array["Nom"]);
        $this->setImage($array["Image"]);
        $this->setActionID($array["ActionId"]);
    }
    
    // static Factory
    static function pourDefinitionPartie($idDefinitionPartie) {
        $dataMapper = new CaseActionDataMapper();
        return $dataMapper->pourDefinitionPartie($idDefinitionPartie);
    }
    
    static function parPositionCase($positionCase, $idDefinitionPartie) {
        $dataMapper = new CaseActionDataMapper();
        return $dataMapper->parPositionCase($positionCase, $idDefinitionPartie);
    }
    
    // interface entreposageDatabase
    public function getDataMapper() {
        return new CaseActionDataMapper();
    }
    
    public function sauvegarde() {
        $this->getDataMapper()->insert($this);
    }
    
    
    //Getters & Setters
    
    public function getType() {
        return "action";
    }
    
    public function getImage() {
        return $this->Image;
    }
    public function setImage($value) {
        $this->Image = $value;
    }
     
    public function getActionID() {
        return $this->actionId;
    }
    public function setActionID($value) {
        (is_numeric($value))?$this->actionId = $value:0;
        //TODO: devrait pas mettre 0, devrait generer une erreur
    }
    
    public function atterrirSur(Joueur $unJoueur) {
   		$this->execute_action($unJoueur);
    }
    // Actions
    public function execute_action(Joueur $joueur){
        switch($this->actionId){
            case 42:
            case 43:
                $xyz = new ActionCarte($this->actionId);
                $xyz->execute($joueur);
                break;
            default:    // Remplacer ceci pour d'autre type d'action
                return 0;
        }
    }

}


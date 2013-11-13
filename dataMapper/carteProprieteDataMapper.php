<?php

require_once "dataMapper/mapper.php";
require_once "modele/cartePropriete.php";

class CarteProprieteDataMapper extends Mapper {
	
    function __construct() {
        parent::__construct();
        $this->selectStmt = self::$db->prepare("SELECT * FROM joueurpartie_caseachetable where CaseAchetableId= ? and JoueurPartiePartieEnCoursId= ? ");
        $this->updateStmt = self::$db->prepare('update joueurpartie_caseachetable set JoueurPartieUsagerCompte=?, JoueurPartiePartieEnCoursId=?, 
                                                        CaseAchetableId=?, OrdreAffichage=?, Hypotheque=?, NombreMaisons=?, NombreHotels=?  
                                                    where CaseAchetableId= ? and JoueurPartiePartieEnCoursId= ?');
        $this->insertStmt = self::$db->prepare("insert into joueurpartie_caseachetable ( JoueurPartieUsagerCompte, JoueurPartiePartieEnCoursId, 
                                                        CaseAchetableId, OrdreAffichage, Hypotheque, NombreMaisons, NombreHotels) values (?,?,?,?,?,?,?)");
    }

    function find($cle) {
        $obj = parent::find($cle);
        if ($obj == null) { //la carte n'est pas dans la bd encore, on cree une carte dummy sans proprietaire
            $array = array("JoueurPartieUsagerCompte"=>"",
                    "JoueurPartiePartieEnCoursId"=>$cle[1],
                    "CaseAchetableId"=>$cle[0],
                    "OrdreAffichage"=>0,
                    "Hypotheque"=>0,
                    "NombreMaisons"=>0,
                    "NombreHotels"=>0
                    );
            $obj = $this->doCreateObject($array);
        }
        return $obj;
    }
    protected function doCreateObject( array $array) {
       $array2 = array("Proprietaire"=>$array("JoueurPartieUsagerCompte"),
               "PartieId"=>$array("JoueurPartiePartieEnCoursId"),
               "CaseId"=>$array("CaseAchetableId"),
               "OrdreAffichage"=>$array("OrdreAffichage"),
               "Hypotheque"=>$array("Hypotheque"),
               "NombreMaisons"=>$array("NombreMaisons"),
               "NombreHotels"=>$array("NombreHotels")
               );
       $obj = new CartePropriete($array2);
       $obj->attache($this);
       return $obj;        
    }
    
    protected function doInsert($object) {
        //TODO: a faire
    }
    
    function update(CartePropriete $objet, $sujet) {
        $values= array ($objet->getProprietaire(), 
                        $objet->getPartieId(), 
                        $objet->getCaseId(), 
                        $objet->getOrdreAffichage(),
                        $objet->getHypotheque(),
                        $objet->getNombreMaisons(),
                        $objet->getNombreHotels());
        $this->updateStmt->execute($values);       
    }

    function selectStmt() {
        return $this->selectStmt;
    }
    
    /*
     * fonctions specific a ce datamapper
     */
    

    
    
}
<?php

require_once "dataMapper/mapper.php";
require_once "modele/cartePropriete.php";
require_once "modele/joueur.php";

class CarteProprieteDataMapper extends Mapper {
	
    function __construct() {
        parent::__construct();
        $this->selectStmt = self::$db->prepare("SELECT * FROM joueurpartie_caseachetable where CaseAchetableId= ? and JoueurPartiePartieEnCoursId= ? ");
        $this->updateStmt = self::$db->prepare('update joueurpartie_caseachetable set JoueurPartieUsagerCompte=?, JoueurPartiePartieEnCoursId=?, 
                                                        CaseAchetableId=?, OrdreAffichage=?, Hypotheque=?, NombreMaisons=?, NombreHotels=?  
                                                    where JoueurPartieUsagerCompte = ? and CaseAchetableId= ? and JoueurPartiePartieEnCoursId= ?');
        $this->insertStmt = self::$db->prepare("insert into joueurpartie_caseachetable ( JoueurPartieUsagerCompte, JoueurPartiePartieEnCoursId, 
                                                        CaseAchetableId, OrdreAffichage, Hypotheque, NombreMaisons, NombreHotels) values (?,?,?,?,?,?,?)");
    }

    function find(array $cle) {
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
       $array2 = array("CompteProprietaire"=>$array["JoueurPartieUsagerCompte"],
               "PartieId"=>$array["JoueurPartiePartieEnCoursId"],
               "CaseId"=>$array["CaseAchetableId"],
               "OrdreAffichage"=>$array["OrdreAffichage"],
               "Hypotheque"=>$array["Hypotheque"],
               "NombreMaisons"=>$array["NombreMaisons"],
               "NombreHotels"=>$array["NombreHotels"]
               );
       $obj = new CartePropriete($array2);
       $obj->attache($this);
       return $obj;        
    }
    
    protected function doInsert($object) {
        //TODO: a faire
    }
    
    function update( $objet, $sujet) {
        $values= array ($objet->getCompteProprietaire(), 
                        $objet->getPartieId(), 
                        $objet->getCaseId(), 
                        $objet->getOrdreAffichage(),
                        $objet->getHypotheque(),
                        $objet->getNombreMaisons(),
                        $objet->getNombreHotels(),
                        );
        
        //verifie si l'enregistrement existe deja
        $selectStatement = self::$db->prepare('SELECT * FROM joueurpartie_caseachetable 
        										WHERE JoueurPartiePartieEnCoursId = :partieId 
        										AND JoueurPartieUsagerCompte = :usagerCompte 
        										AND CaseAchetableId = :caseId');
        $selectStatement->bindParam(':partieId', $values[1]);
        $selectStatement->bindParam(':usagerCompte', $values[0]);
        $selectStatement->bindParam(':caseId', $values[2]);
        $selectStatement->execute();
        if (sizeof($selectStatement->fetchAll()) >= 1) {
            //si il existe, on l'update
        	$values = array_merge($values, array($objet->getCompteProprietaire(), $objet->getCaseId(), $objet->getPartieId()));
        	$this->updateStmt->execute($values);
        }
        else {
            //si non, on l'ajoute. 
        	$this->insertStmt->execute($values);
        }       
    }

    function selectStmt() {
        return $this->selectStmt;
    }
    
    /*
     * fonctions specific a ce datamapper
     */

    function pourJoueur(Joueur $joueur) {
        $queryTxt = 'SELECT * FROM JoueurPartie_CaseAchetable
                        WHERE JoueurPartieUsagerCompte = :joueurId AND JoueurPartiePartieEnCoursId = :partieId';
        $query = self::$db->prepare($queryTxt);
        $query->bindValue(':joueurId', $joueur->getCompte());
        $query->bindValue(':partieId', $joueur->getPartieId());
        return $this->findAll($query);
    }
    
}
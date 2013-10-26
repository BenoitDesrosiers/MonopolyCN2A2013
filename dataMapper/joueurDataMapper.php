<?php

require_once "dataMapper/mapper.php";
require_once "modele/joueur.php";

class JoueurDataMapper extends Mapper {
    
    function __construct() {
        parent::__construct(); 
        
        $this->selectStmt = self::$db->prepare("SELECT * FROM JoueurPartie WHERE usagercompte = ? AND partieencoursid =? ");
        $this->updateStmt = self::$db->prepare("update JoueurPartie set UsagerCompte = ?, PartieEncoursId = ?, PionId = ?, Position = ?, OrdreDeJeu = ?, EnPrison = ?, ToursRestants_Prison = ?
                                                where usagercompte = ? AND partieencoursid =? ");
        $this->insertStmt = self::$db->prepare("insert into JoueurPartie ( UsagerCompte, PartieEncoursId, PionId, Position, OrdreDeJeu, EnPrison, ToursRestants_Prison ) values (?,?,?,?,?,?,?)");
        
    }
    
    protected function doCreateObject( array $array) {
        return new Joueur($array) ;
    }
    
    
    protected function doInsert( $objet) {
        //TODO: ajouter le check si l'objet est déjà dans la BD. 
        $values = array($objet->getCompte(), $objet->getPartieId(), $objet->getPionId(), $objet->getPosition(),$objet->getOrdreDeJeu(), $objet->getEnPrison(), $objet->getToursRestantEnPrison() );
        $this->insertStmt->execute($values);
    }
    
    function update($objet) {
        $values= array ($objet->getCompte(), $objet->getPartieId(), $objet->getPionId(), $objet->getPosition(),$objet->getOrdreDeJeu(), $objet->getEnPrison(), $objet->getToursRestantEnPrison(),
                        $objet->getCompte(), $objet->getPartieId());
        $this->updateStmt->execute($values);        
        $this->updateArgent($objet);
    }
    
    private function updateArgent($objet) {
        // update la table contenant l'argent à partir de l'array de coupures 
        $coupures = $objet->getArgent();
        $queryTxt = 'update JoueurPartie_Argent set ArgentMontant = :montant, 
                                                    JoueurPartieUsagerCompte = :joueurId, 
                                                    JoueurPartiePartieEnCoursId = :partieId,
                                                    Quantite = :qte  
                                                    where JoueurPartieUsagerCompte = :joueurId 
                                                      and JoueurPartiePartieEnCoursId = :partieId';
        $query = self::$db->prepare($queryTxt);
        $query->bindValue(':joueurId', $objet->getCompte());
        $query->bindValue(':partieId', $objet->getPartieId());
        foreach($coupures as $valeur=>$qte) {
            $query->bindValue(':montant', $valeur);
            $query->bindValue(':qte', $qte);
            $query->execute(); //TODO: trapper les erreurs. 
        }
    }
    
    function selectStmt() {
        return $this->selectStmt;
    }
    
    function findPourPartie($partieId) {
        /*
         * input
        *     $partieId: l'id d'une partie
        * output
        *     un array contenant les joueurs associées à la partie.
        *     un array vide si aucun joueur n'est trouvé
        *
        */
        
        $queryTxt = 'SELECT * FROM JoeurPartie
                        WHERE  partieencoursid = :partieId';
        $query = self::$db->prepare($queryTxt);
        $query->bindValue(':partieId', $partieId);
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $query->execute();
        
        $listeItems = array();
        
        foreach($query as $row) {
            $unItem = $this->createObject($row);
            if ($unItem <> null) {
                $listeItems[] = $unItem;
            }
        }
        return $listeItems;
    } 
        
  
}
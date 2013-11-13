<?php

require_once "dataMapper/mapper.php";
require_once "dataMapper/coupureDataMapper.php";
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
        $joueur = new Joueur($array) ;
        $joueur->attache($this);
        //$coupureDM= new CoupureDataMapper();
        //$joueur->attache($coupureDM); // attache un dm de coupure afin de mettre � jour l'argent. 
        //TODO: en attachant un dm de coupure, on va mettre a jouer la table d'argent au moindre changement dans le joueur. 
        //TODO: faudrait trouver une facon de changer l'argent juste quand elle change vraiment. 
        //      soit qu'on appele coupureDM directement au moment du setArgent --> cree une dependance entre joueur et coupureDM
        //      soit qu'on a un flag pour indique que c'est l'argent qui a change. 

        return $joueur;
    }
    
    
    protected function doInsert( $objet) {
        //TODO: ajouter le check si l'objet est déjà dans la BD. 
        $values = array($objet->getCompte(), $objet->getPartieId(), $objet->getPionId(), $objet->getPosition(),$objet->getOrdreDeJeu(), $objet->getEnPrison(), $objet->getToursRestantEnPrison() );
        $this->insertStmt->execute($values);
    }
    
    function update($objet, $sujet) {
        if ($sujet == "argent") {
            // update la table d'argent quand c'est l'argent qui est changee.
            $coupureDM = new CoupureDataMapper();
            $coupureDM->update($objet, $sujet);
        } else {
            // update la table principale du joueur
            $values= array ($objet->getCompte(), $objet->getPartieId(), $objet->getPionId(), $objet->getPosition(),$objet->getOrdreDeJeu(), $objet->getEnPrison(), $objet->getToursRestantEnPrison(),
                    $objet->getCompte(), $objet->getPartieId());
            $this->updateStmt->execute($values);
        }

    }
    
    

    function selectStmt() {
        return $this->selectStmt;
    }
    

    function findPourPartie($partieId) {
        /*
		 * crée les joueurs associés à une partie 
		 *
         * input
        *     $partieId: l'id d'une partie
        * output
        *     un array contenant les joueurs associées à la partie.
        *     un array vide si aucun joueur n'est trouvé
        *
        */
        
        $queryTxt = 'SELECT * FROM JoueurPartie
                        WHERE  partieencoursid = :partieId';
        $query = self::$db->prepare($queryTxt);
        $query->bindValue(':partieId', $partieId);
        return $this->findAll($query);
    } 
       
}
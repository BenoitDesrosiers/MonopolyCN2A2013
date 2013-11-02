<?php

/*
 * l'argent d'un joueur 
 */

require_once "dataMapper/mapper.php";
require_once "modele/coupure.php";
require_once "modele/joueur.php"; 

class CoupureDataMapper extends Mapper {
    
    function __construct() {
        parent::__construct(); 
        
        $this->selectStmt = self::$db->prepare("SELECT * FROM JoueurPartie_argent WHERE JoueurPartieUsagerCompte = ? AND JoueurPartiePartieEnCoursId =? ");
        //$this->insertStmt = self::$db->prepare("insert into JoueurPartie ( UsagerCompte, PartieEncoursId, PionId, Position, OrdreDeJeu, EnPrison, ToursRestants_Prison ) values (?,?,?,?,?,?,?)");
    }
    
    protected function doCreateObject( array $array) {
        
        return new Coupure(array('Valeur'=>$array['ArgentMontant'], 
                                 'Quantite'=>$array['Quantite'],
                                 'JoueurCompte'=>$array['JoueurPartieUsagerCompte'], 
                                 'PartieId'=>$array['JoueurPartiePartieEnCoursId'])) ;
    }
    
    public function ajouteCoupuresA(Joueur $joueur) {
        //FIXME: c'est pas clean 
        /*
         * va chercher les billets associés à un joueur
         * et s'ajoute en tant qu'Observer pour ce joueur. 
         *
         */
        
        $joueur->attache($this);
        
        $queryTxt = "SELECT * FROM JoueurPartie_Argent WHERE JoueurPartieUsagerCompte = :joueurId AND JoueurPartiePartieEnCoursId = :partieId";
        $query = self::$db->prepare($queryTxt);
        $query->bindValue(':joueurId', $joueur->getCompte());
        $query->bindValue(':partieId', $joueur->getPartieId());
        return $this->findAll($query);
    }
    
    protected function doInsert( $objet) {
        //TODO: ajouter le check si l'objet est déjà dans la BD. 
        //$values = array($objet->getCompte(), $objet->getPartieId(), $objet->getPionId(), $objet->getPosition(),$objet->getOrdreDeJeu(), $objet->getEnPrison(), $objet->getToursRestantEnPrison() );
        $this->insertStmt->execute($values);
    }
    
    function update($objet) {
        /*
         * le joueur associé a changé  
         * update la table contenant l'argent à partir de l'array de coupures
         */

        $coupures = $objet->getArgent();
        // commence par effacer tout l'argent courrant du joueur
        // on doit faire ca car si la bd avait un billet de 50$ et que maintenant il n'y a plus de 50$, il restera dans la bd. 
        $queryTxt = 'DELETE FROM joueurPartie_Argent
                        WHERE JoueurPartieUsagerCompte = :joueurId
                            AND JoueurPartiePartieEnCoursId = :partieId';
        $query = self::$db->prepare($queryTxt);
        $query->bindValue(':joueurId', $objet->getCompte());
        $query->bindValue(':partieId', $objet->getPartieId());
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $query->execute();
        
        if (count($coupures) != 0) {
            // re-insert tous les billets
            $queryTxt = 'INSERT INTO JoueurPartie_Argent (ArgentMontant , JoueurPartieUsagerCompte , JoueurPartiePartieEnCoursId , Quantite ) 
                                    VALUES (:montant, :joueurId, :partieId, :qte)';
            $query = self::$db->prepare($queryTxt);
            $query->bindValue(':joueurId', $objet->getCompte());
            $query->bindValue(':partieId', $objet->getPartieId());
            foreach($coupures as $valeur=>$qte) {
                $query->bindValue(':montant', $valeur);
                $query->bindValue(':qte', $qte);
                $query->execute(); //TODO: trapper les erreurs.
            }
        }
        // se detache du joueur. Tant qu'on aura pas été rechercher ses billets, on a pas besoin d'etre attaché. 
        $objet->detache($this);  
    }
    
    function selectStmt() {
        return $this->selectStmt;
    }
    
 
  
}
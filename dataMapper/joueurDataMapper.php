<?php

require_once "dataMapper/mapper.php";
require_once "modele/joueur.php";

class JoueurDataMapper extends Mapper {
    
    function __construct() {
        //CONNECTION 1.2.4.2.1 : batit le datamapper. Faire un 'new' appele "__construct"
        parent::__construct(); // "parent" veut dire "cette mÃ©thode de ma superclasse. 
        $this->selectStmt = self::$db->prepare("SELECT * FROM joueurPartie where UsagerCompte=?");
        $this->updateStmt = self::$db->prepare('update joueurPartie set Position=?, EnPrison=?, ToursRestants_Prison=?, where UsagerCompte=?');
        $this->insertStmt = self::$db->prepare("insert into joueurPartie ( UsagerCompte, PartieEnCoursId, PionId, Position, OrdreDeJeu, EnPrison, ToursRestants_Prison ) values (?, ?)");
        
    }

    protected function doCreateObject( array $array) {
    	$obj = new Joueur($array);
        return $obj;        
    }
    
    protected function doInsert( $object) {
        //TODO: ajouter une exception si le compte est dÃ©ja utilisÃ©
        $values = array($object->getCompte(), $object->getPassword(), $object->getNom(), $object->getRole());
        $this->insertStmt->execute($values);
    }
    
    function update($object) {
        $values= array ($object->getCompte(), $object->getPassword(), $object->getNom(), $object->getRole(), $object->getCompte());
        $this->updateStmt->execute($values);
    }
    
    function selectArgent($joueur){
    	//Va chercher l'argent pour le joueur dans la db
    	/*
    	 * input
    	 * 		$joueur: un objet joueur
    	 * output
    	 * 		$listeArgent: array qui contient l'argent du joueur
    	 */
    	
    	$queryTxt = 'SELECT * FROM joueurPartie_Argent
    				WHERE JoueurPartieUsagerCompte = :compte';
    	$query = self::$db->prepare($queryTxt);
    	$query->bindValue(':compte', $joueur->getUsagerCompte());
    	$query->setFetchMode(PDO::FETCH_ASSOC);
    	$query->execute();    	

    	$listeArgent = array();
    	
    	foreach($query as $row) {
    		if ($row <> null) {
    			$listeArgent[$row['ArgentMontant']] = $row['Quantite'];
    		}
    	}
    	return $listeArgent;
    }
    
    function ajoutArgent($joueur) {
    	//Ajout de l'argent pour les joueurs dans la db
    	/*
    	 * input
    	 * 		$joueur: un objet joueur
    	 * ouput
    	 * 		L'argent est ajouté dans la db pour les joueurs
    	*/
    	
        $ajoutArgentStmt = self::$db->prepare('insert into joueurPartie_Argent ( ArgentMontant, JoueurPartieUsagerCompte, JoueurPartiePartieEnCoursId, Quantite ) values (?, ?, ?, ?)');
        
        foreach ($joueur->getArgent() as $montant=>$quantite) :
        	$ajoutArgentStmt->execute(array($montant, $joueur->getUsagerCompte(), $joueur->getPartieEnCoursId(), $quantite));
    	endforeach;
    }
    
    function deleteArgent($joueur){
    	$queryTxt = 'DELETE FROM joueurPartie_Argent
    				WHERE JoueurPartieUsagerCompte = :compte';
    	$query = self::$db->prepare($queryTxt);
    	$query->bindValue(':compte', $joueur->getUsagerCompte());
    	$query->setFetchMode(PDO::FETCH_ASSOC);
    	$query->execute();    	
    }
    
    function selectStmt() {
        return $this->selectStmt;
    }
    
    function findJoueursPourPartie($idPartie) {
    	// crée les joeurs associés Ã  une partie a partir de la db
    
    	/*
    	 * input
    	*     $idPartie: l'id de la partie
    	* output
    	*     un array contenant les joueurs associés a la partie.
    	*     un array vide si aucun joueurs n'est associé a la partie
    	*
    	*/
    
    	$queryTxt = 'SELECT * FROM JoueurPartie
                        WHERE PartieEnCoursId = :partie';
    	$query = self::$db->prepare($queryTxt);
    	$query->bindValue(':partie', $idPartie);
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
<?php
/* usager_factory
 * gestion de la creation des usagers
 * la factory est un singleton
 * Elle recoit un id d'usager et cree une instance d'une des sous-classe 
 * de Usager selon le type inscrit dans la bd.
 */

require_once('factories/super_factory.php');
require_once('modele/usager.php');
require_once('modele/coordonnateur.php');
require_once('modele/joueur.php');


class Usager_Factory extends Super_Factory { 
	
	
	public function parCompte($compte) {
		// crée l'usager associer à un numéro de compte sans verifier le mot de passe
		// si aucun usager n'est associé, null sera retourné
		
		$usager = self::$listeItems[$compte];
		if (!$usager) { // si l'usager n'est pas déjà créé, on le créé
		    $db = Database::getDB();
		    $queryTxt = 'SELECT compte, nom, password FROM Usagers WHERE compte = :compte';
		    $query = $db->prepare($queryTxt);
		    $query->bindValue(':compte', $compte);
		    $query->setFetchMode(PDO::FETCH_ASSOC);
		    $query->execute();
		    if ($query->rowCount() == 1) {
		        $row = $query->fetch();
		        $usager = $this->parHydratation($row,$row['compte']);
		    }
		} 
		return $usager;
	}	
	
	public function parComptePW($compte, $password) {
		// crée l'usager associer à un numéro de compte en verifiant si le mot de passe est le bon
		// si aucun usager n'est associé, null sera retourné
		
		$usager = null;
		$usager1 = $this->parCompte($compte);
		if ($usager1 <> null) {
			if ($usager1->validePW($password)) {
				$usager = $usager1;
			}
		}	
		return $usager;
	}
	
	private function parHydratation($uneRow, $laCle) {
	    switch ($this->rolePourCompte($uneRow['compte'])) {
	        case 'coordonnateur' :
	            $unItem = new Coordonnateur();
	            $unItem->hydrate($uneRow);
	            break;
	        case 'joeur' :
	            $unItem = new Joueur();
	            $unItem->hydrate($uneRow);
	            break;
	    }    
	    self::$listeItems[$laCle] = $unItem;
	    
	    return $unItem;
	}
	
	private static function rolePourCompte($compte) {
	    //retourne le role d'un usager
	    $db = Database::getDB();
	    $queryTxt = 'SELECT * FROM Usagers WHERE compte = :compte';
	    $query = $db->prepare($queryTxt);
	    $query->bindValue(':compte', $compte);
	    $query->execute();
	    if ($query->rowCount() == 1) {
	        $row = $query->fetch();
	        return $row['role'];
	    } else {
	        return null;
	    }
	}
}

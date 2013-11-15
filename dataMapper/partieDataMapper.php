<?php

require_once "dataMapper/mapper.php";
require_once "modele/partie.php";

class PartieDataMapper extends Mapper {
    
    function __construct() {
        parent::__construct();
        $this->selectStmt = self::$db->prepare("SELECT * FROM PartieEnCours where id=?");
        $this->updateStmt = self::$db->prepare('update PartieEnCours set id=?, nom=?, coordonnateur=?, DefinitionPartieId = ?, JoueurTour =?, DebutPartie = ?, InteractionId =? 
                                                    where id=?');
        $this->insertStmt = self::$db->prepare("insert into PartieEnCours ( nom, coordonnateur, DefinitionPartieId, JoueurTour, DebutPartie, InteractionId ) values (?, ?, ?, ?, ?, ?)");
        
    }

    protected function doCreateObject( array $array) {
        
        $partie =  new Partie($array );
        $partie->attache($this);
        return $partie;
    }
    
    protected function doInsert($object) {
        if (!$this->nomLibre($object->getNom())) {
            //Verifie si il n'y a pas deja une partie avec le meme nom.
            throw new Exception('nom deja utilise');
        }
        //TODO ajouter un check si le coordonnateur n'est pas null ou inexistant
        $values = array($object->getNom(), 
                        $object->getCoordonnateur(), 
                        $object->getDefinitionPartieId(),
                        $object->getJoueurTour(),
                        $object->getDebutPartie()->format('Y-m-d h:i:s'),
                        $object->getInteractionId());
        $this->insertStmt->execute($values);
        $id = self::$db->lastInsertId();
        $object->setId($id);
    }
    
    function update($object, $sujet) {
        $values= array ($object->getId(), 
                        $object->getNom(), 
                        $object->getCoordonnateur(), 
                        $object->getDefinitionPartieId(),
                        $object->getJoueurTour(),
                        $object->getDebutPartie(),
                        $object->getInteractionId(),
                        $object->getId());
        $this->updateStmt->execute($values);
    }
    
    function selectStmt() {
        return $this->selectStmt;
    }
    
    /*
     * fonctions specific a ce datamapper
     */
    
    function nomLibre($nom) {
        /*
         * verifie si ce $nom est deja utilise pour une autre partie
         * 
         * Retour
         *     true: le nom n'est pas utilise
         *     false: une partie a deja ce nom
         */
        $queryTxt = 'SELECT * FROM PartieEnCours
                WHERE nom = :nom';
        $query = self::$db->prepare($queryTxt);
        $query->bindValue(':nom', $nom);
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $query->execute();
        
        if ($query->rowCount() == 0) {
            return true;
        } else {
            return false;
        }
        
     function positionJoueur($idPartieEnCours, $compteUsager) {
     	// Retourne la position du $compteUsager dans la partie $idPartieEnCours.
     	
     	/*
     	 * Input:
     	 * 		$idPartieEnCours: L'id de la partie en cours
     	 * 		$compteUsager: Nom de compte de l'usager 
     	 * Output:
     	 * 		Position du joueur du compte dans la partie actuelle
     	 * 
     	 */
     	
     	$queryTxt = 'SELECT Position FROM PartieEnCoursId 
     					WHERE UsagerCompte = :usagerCompte
     					AND PartieEnCoursId = :partieEnCoursId';
     	$query = self::$db->prepare($queryTxt);
     	$query->bindValue(':usagerCompte', $compteUsager, PDO::PARAM_STR);
     	$query->bindValue(':partieEnCoursId', $idPartieEnCours, PDO::PARAM_INT);
     	$query->setFetchMode(PDO::FETCH_ASSOC);
     	$query->execute();
     	
     	foreach($query as $row) {
     		$item = $this->createObject($row);
     	}
     	
     	return $item;
     }
        
    }
    function findPourCoordonnateur( $idCoordonnateur) {
        //TODO: remplacer par un call a findAll en mettant selectAllStmt = au select. ??? est ce que ca fit dans le modele ou ca va melanger le selectAllStmt, on saura pas lequel est pour etre appele 
        // cree les parties associees a un coordonnateur a partir de la db
        
        /*
         * input
        *     $idCoordonnateur: l'id du coordonnateur
        * output
        *     un array contenant les parties associees au coordonnateur.
        *     un array vide si aucune partie n'est associee au coordonnateur
        *
        */
        //LISTEPARTIE 1.3.1.1.1 extrait la liste des parties pour un coordonnateur. 
        $queryTxt = 'SELECT * FROM PartieEnCours
                        WHERE coordonnateur = :coordonnateur';
        $query = self::$db->prepare($queryTxt);
        $query->bindValue(':coordonnateur', $idCoordonnateur);
        return $this->findAll($query);
       
    }
}
<?php
require_once "interface/entreposageDatabase.php";
require_once 'modele/usager.php';
require_once 'dataMapper/coupureDataMapper.php';
/*
 * représente l'argent d'un joueur, découpé en coupure et quantité
 */

class Coupure  implements EntreposageDatabase {
   
    protected $valeur;
    protected $quantite;
    protected $joueurId;
    protected $partieId;
    
    function __construct(array $array) {
        /*
         * input
         *     un array associative contenant
         *     'Valeur' : le montant de la coupure (un $50, un $10...)
         *     'Quantite' : la quantite de ce billet
         *     'JoueurId' : l'id du joueur à qui appartient ces coupures
         *     'PartieId' : l'id de la partie du joueur  
         *     
         */
        $this->valeur = $array['Valeur'];
        $this->quantite = $array['Quantite'];
        $this->joueurId = $array['JoueurId'];
        $this->partieId = $array['PartieId'];
    }
    
    // Static Factory
    
    public static function pourJoueur(Joueur $joueur) {
        /*
         * retourne un array contenant simplement les valeurs et quantités des coupures pour un joueurs. 
         * important: ca ne retourne pas des coupures ... seulement les quantité et valeurs. 
         * Cette fonction sera probablement obsolete quand on introduira les vraies objets billets. 
         */
        $mapper = new PortefeuilleDataMapper();
        $coupures = $mapper->findCoupuresPour(array($joueur->compte, $joueur->partieId));
        
        //transforme les objet coupures en array
        $portefeuille = array();
        foreach($coupures as $uneValeur=>$uneQte) {
            $portefeuille[$uneValeur] = $uneQte;
        }
        return $porteFeuille;
    }
    
    // interface entreposageDatabase
    public function getDataMapper() {
        return new CoupureDataMapper();
    }
    
    public function sauvegarde() {
        // pour l'instant, on sauvegarde pas les coupures, c'est fait dans Joueur
        //$this->getDataMapper->insert($this);
    }
    
    
}
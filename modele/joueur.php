<?php
require_once 'interface/entreposageDatabase.php';
require_once 'modele/objet.php';
require_once 'modele/caseDeJeu.php';
require_once 'modele/coupure.php';
require_once 'modele/partie.php';
require_once 'modele/tableau.php';
require_once 'modele/cartePropriete.php';
/*
 * un joueur n'est pas un usager, un usager est identifie par son compte, un joueur est identifie par son compte et une partie. 
 * un joueur a un usager d'associe
 */
class Joueur extends Objet  implements EntreposageDatabase{
    
    protected $compte;   
    protected $partieId;
    protected $pionId;
    protected $position;
    protected $ordreDeJeu;
    protected $enPrison;
    protected $toursRestantEnPrison;
    protected $argent; // une array associative contenant le nombre de billets de chaque sortes.
    
    function __construct(array $array) {
        /*
         * input
        *     un array associative contenant le
        *     'Compte' : le compte ,
        *     'PartieId' : l'id de la partie en cours 
        *     'PionId' : l'id du pion 
        *     'Position' : la position du joueur 
        *     'OrdreDeJeu' : l'ordre de jeu 
        *     'EnPrison' : un flag indiquant si le joueur est en prison 
        *     'ToursRestants_Prison' : le nombre de tours restant au joueur a passer en prison   
        *     'Billets' : une liste de billets 
        *     
        */
        
        $this->compte = $array['UsagerCompte'];
        $this->partieId = $array['PartieEnCoursId'];
        $this->pionId = $array['PionId'];
        $this->position = $array['Position'];
        $this->ordreDeJeu = $array['OrdreDeJeu'];
        $this->enPrison = $array['EnPrison'];
        $this->toursRestantEnPrison = $array['ToursRestants_Prison'];

    }
    
    // Static Factory
    
    public static function parComptePartie($compte, $partieId) {
        $mapper = new JoueurDataMapper();
        $joueur = $mapper->find(array($compte, $partieId));
        
        return $joueur;
    }
    
    public static function nouveauJoueur(array $array) {
        /*
		 * Ajoute un joueur dans la bd
         *
         * input
        *     un array associative contenant
        *     'UsagerCompte' : le compte usager associe a ce joueur ,
        *     'PartieEnCoursId' : l'id de la partie en cours
        *     'PionId' : l'id du pion
        *     'Position' : la position du joueur
        *     'OrdreDeJeu' : l'ordre de jeu
        *     'EnPrison' : un flag indiquant si le joueur est en prison
        *     'ToursRestants_Prison' : le nombre de tours restant au joueur a passer en prison
        *     'Billets' : une liste de billets
        *
        */
        
        $joueur = new Joueur($array);
        $mapper = new JoueurDataMapper();
        $mapper->insert($joueur);
        return $joueur;
    }
    
    public static function pourPartie($partieId) {
        $mapper = new JoueurDataMapper();
        return $mapper->findPourPartie($partieId);
    }
    
    // interface entreposageDatabase
    public function getDataMapper() {
        return new JoueurDataMapper();
    }
    
    public function sauvegarde() {
        $this->getDataMapper->insert($this);
    }
    
    /*TODO: obsolete ?
     * public function update() {
        $this->getDatamapper->update($this);
    }
    */
    
    //fonctions pour jouer
	public function brasseDes() {
	    //TODO: je crois que ca devrait tre ˆ la partie de brasser les dŽs. 
	    
		// Creation des des
		//FIXME: faire la vrai crŽation des dŽs
		$des1 = array('ID' => 0, 'Val' => 1);
		$des2 = array('ID' => 1, 'Val' => 1);
		
		//FIXME: on fait quoi quand y'a un double? faudrait mettre la partie dans un Žtat permettant ˆ ce joueur de rejouer
		// Ajustement de la position du joueur
		$this->setPosition($this->getPosition() + $des1['Val'] + $des2['Val']);
				
		// Creer et lancer une case de jeu		
		$uneCase = null;
		
		$partie = Partie::parId($this->getPartieId());
		$tableau = $partie->getTableau();
		$uneCase = $tableau->getCaseParPosition($this->getPosition());
		
		if ($uneCase == null) :
		    //TODO: changer pour afficher_erreur 
			echo "ATTENTION: Erreur lors de l'attribution de l'objet case achetable/case action par la position";
		endif;
		$uneCase->atterrirSur($this);
	}
	
	public function convertirMontantEnBillets( $montant ) {
	    /* converti un montant d'argent en le transformant en array de billets
	     * input
	     *     $montant : un entier representant le montant a encaisser
	     * output
	     *     un array contenant les billets optimaux pour representer le montant    
	     */
         //FIXME: la vraie facon de faire serait d'aller chercher une definition des billets disponibles pour cette definition de partie
         //       mais ca n'existe pas pour l'instant, donc on prend 1,5,10,20,50,100,500 
         //FIXME: cette conversion ne devrait pas etre fait par Joueur, ca devrait tre une fonction gŽnŽrique a laquelle on passerait l'array $coupuresDisponibles
         
	     $coupuresDisponibles =  array('1'=>1, '5'=>5, '10'=>10, '20'=>20, '50'=>50, '100'=>100, '500'=>500);
	     $clesCoupures = array('500', '100', '50', '20', '10', '5', '1'); //on commence par le plus gros billets
	     $coupuresFinales = array();
	     $i = 0;
	     while ($montant != 0) { //vue que le plus petit billet est un 1, c'est certain qu'on va arreter. 
	         $montantCoupure = $coupuresDisponibles[$clesCoupures[$i]]; //la valeur du billet a la position $i
	         
	         if ($montant >= $montantCoupure) { //y'a assez d'argent pour ce montant de billet
	             $qte = intval($montant/$montantCoupure); //combien de billets on peu generer
	             $coupuresFinales[$clesCoupures[$i]] = $qte;
	             $montant -= $qte * $montantCoupure; //on enleve la valeur des billets au montant. 
	         }
	         $i++;
	     }
	     
	     return $coupuresFinales;
	    
	}
	
	public function encaisse( $argent) {
	    /*input
	     * $billets: soit un array de billets (valeur et qte)
	     *           soit un int qui sera convertit en array de billets
	     */ 
	    if (is_array($argent)) {
	        //la fonction a recu un array (montant et qte)
	        $billets = $argent;
	    } else {
	        //la fonction a recu un int, on le convertit
	        $billets = $this->convertirMontantEnBillets($argent);
	    }
	    $monArgent = $this->getArgent();
        foreach ($billets as $valeur => $qte) {
            $monArgent[$valeur] += $qte; //TODO: verifier que les qte sont positives, ou accepter les nŽgatives mais planter si y'en a pas assez. La fonction ferait donc un encaisse et un dŽcaisse
        }	    
        $this->setArgent($monArgent);
	}

    public function paye($montant) {
                
		//Fonction aller chercher argent dans la database
		$argent = $this->getArgent();

        $montantCtr = 0;
        $argentCtr = 0;
        
        //verification argent
        //si le joueur a assez d'argent pour payer 
        foreach($argent as $billet=>$quantite){
                $argentCtr += intval($billet) * $quantite; 
        }
        echo "Le joueur a ".$argentCtr."$ et doit payer ".$montant."$";
        echo "</br>";
        
        if($argentCtr < $montant){
                echo "Le joueur n'a pas assez d'argent. ".($montant-$argentCtr)."$ de plus sont necessaire.";
        }
        else{
                echo "Argent du joueur avant : ".$argentCtr."<br/>";
                echo "Montant a payer: ".$montant."<br/>";
                
                $argentCtr -= $montant;
                echo "Argent du joueur apres: ".$argentCtr."<br/>";
                
                //creation de l'array de paiement exemple le joueur doit payer 350, il paye avec un 500
                // montantCtr = valeur que le joueur recupere
                // quantiteCtr = quantite de billet utilise
                foreach($argent as $billet=>$quantite){
                        if($quantite != 0){
                                if($montant > 0){
                                        //echo "Montant : ".$montant."</br>";
                                		$quantiteCtr = ceil($montant / intval($billet));
                                		if($quantiteCtr > $quantite)
                                			$quantiteCtr = $quantite;
                                        $montant -=  $quantiteCtr *intval($billet);
                                        //echo "Montant : ".$montant."</br>";
                                        $montantCtr = $montant;
                                        //echo "MontantCtr : ".$montantCtr."</br>";
                                        $quantite -= $quantiteCtr ; 
                                        if($montantCtr < 0){
                                                $montantCtr *= -1;
                                                //echo "MontantCtr : ".$montantCtr."</br>";
                                        }               
                                	//echo "Billet actuel : " . $billet . "</br>";
                                	//echo "quantite actuel : " . $quantiteCtr . "</br>";   
                                	//echo "montantctr : " . $montantCtr . "</br>";                                     
                                }
                                
                        } 
                 
                        $argent[$billet]=$quantite;     
                        
                }
                
                //creation de l'array que le joueur doit encaisser apres avoir payer
                //exemple il a payer 350 avec un billet de 500 donc il doit encaisser 150
                //update l'array d'argent total du joueur
                //montantCtr = valeur que le joueur recupere
                // quantiteCtr = quantite de billet recupere
                foreach($argent as $billet=>$quantite){
                	//echo "montantctr retour: ". $montantCtr . "</br>";
                        if($billet <= $montantCtr){
                                    $quantiteCtr = floor($montantCtr / intval($billet));
                                    $quantite += $quantiteCtr;
                                    
                                    //echo "Billet retour :".$billet."</br>";
                                    //echo "Quantite Retour : ".$quantiteCtr."</br>";
                                    
                                    if($quantiteCtr != 0){
                                            $montantCtr -= intval($billet) * $quantiteCtr;
                                            //echo "Montant Retour ".$montantCtr."</br>";
                                    }
                           
                               
                        }
                        $argent[$billet]=$quantite;
                }
                
        }
        //appel la fonction encaisse pour mettre a jour l'argent du joueur.
        $this->setArgent($argent);
        //return $argent; //TODO: devrait retourner l'argent utilisŽe pour payer. 
    }

	public function tenterAchat(CartePropriete $carte){
	    return true;
	}
	
	public function chargerLoyerA($locataire, $loyer){
	    $locataire->paye($loyer);
	    $this->encaisse($loyer);
	}
	

	// Getter & Setter
	
	public function getCompte() {
	    return $this->compte;
	}
	public function setCompte($value) {
	    $this->compte = $value;
	    $this->notifie("compte");
	}
	
	public function getArgent() {
	    if (count($this->argent) == 0) {
	        //lazy load
	        $this->argent = Coupure::pourJoueur($this);
	    }
	    return $this->argent;
	}
	
	public function setArgent($value) {
	    $this->argent = $value;
	    $this->notifie("argent");
	}
	
	public function getToursRestantEnPrison() {
	    return $this->toursRestantEnPrison;
	}
	public function setToursRestantEnPrison($value) {
	    $this->toursRestantEnPrison = $value;
	    $this->notifie("toursRestantEnPrison");
	}
	
	public function getEnPrison() {
	    return $this->enPrison;
	}
	public function setEnPrison($value) {
	    $this->enPrison = $value;
	    $this->notifie("enPrison");
	}

	public function getOrdreDeJeu() {
	    return $this->ordreDeJeu;
	}
	public function setOrdreDeJeu($value) {
	    $this->ordreDeJeu = $value;
	    $this->notifie("ordreDeJeu");
	}
	
	public function getPosition() {
	    return $this->position;
	}
	public function setPosition($value) {
	    $value = $value % 40; //TODO: remplacer 40 par le nombre de case du jeu
	    $this->position = $value;
	    $this->notifie("position");
	}
	
	public function getPionId() {
	    return $this->pionId;
	}
	public function setPionId($value) {
	    $this->pionId = $value;
	    $this->notifie("pionId");
	}
	
	public function getPartieId() {
	    return $this->partieId;
	}
	public function setPartieId($value) {
	    $this->partieId = $value;
	    $this->notifie("partieId");
	}
	
	public function getProprietes() {
	    return CartePropriete::pourJoueurs($this);
	}
	
}
<?php
require_once 'interface/entreposageDatabase.php';
require_once 'modele/objet.php';
require_once 'modele/caseDeJeu.php';
require_once 'modele/coupure.php';
/*
 * un joueur n'est pas un usager, un usager est identifié par son compte, un joueur est identifié par son compte et une partie. 
 * un joueur a un usager d'associé
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
        *     'ToursRestants_Prison' : le nombre de tours restant au joueur à passer en prison   
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
        *     'UsagerCompte' : le compte usager associé à ce joueur ,
        *     'PartieEnCoursId' : l'id de la partie en cours
        *     'PionId' : l'id du pion
        *     'Position' : la position du joueur
        *     'OrdreDeJeu' : l'ordre de jeu
        *     'EnPrison' : un flag indiquant si le joueur est en prison
        *     'ToursRestants_Prison' : le nombre de tours restant au joueur à passer en prison
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
		// Creation des des
		$des1 = array('ID' => 0, 'Val' => 3);
		$des2 = array('ID' => 1, 'Val' => 5);
		
		// Ajustement de la position du joueur
		$this->setPosition($this->getPosition() + $des1['Val'] + $des2['Val']);
				
		// Creer et lancer une case de jeu		
		$uneCase = null;
		
		foreach (CaseDeJeuAchetable::pourDefinitionPartie($this->getPartieId()) as $caseAchetable) :
			if ($caseAchetable->getPosition() == $this->getPosition()) :
				$uneCase = CaseDeJeuAchetable::parPositionCase($this->getPosition(), 1);
			endif;
		endforeach;
		
		if ($uneCase == null) :
			foreach (CaseDeJeuAction::pourDefinitionPartie($this->getPartieId()) as $caseAction) :
				if ($caseAction->getPosition() == $this->getPosition()) :
					$uneCase = CaseDeJeuAction::parPositionCase($this->getPosition(), 1);
				endif;
			endforeach;
		endif;
		
		if ($uneCase == null) :
			echo "ATTENTION: Erreur lors de l'attribution de l'objet case achetable/case action par la position";
		endif;
		
		$this->avanceSurCase($uneCase);
	}
	
	public function avanceSurCase(CaseDeJeu $uneCase) {
	     if ($uneCase->getType() == "achetable") :
	     	$uneCase->atterrirSur($this);
	     elseif ($uneCase->getType() == "action") :
	     	$uneCase->atterrirSur($this);
	     else :
	     	echo "ATTENTION: Erreur lors de l'identification du type de la case!";
	     endif;
	}
	
	public function encaisse( $billets) {
	    /*input
	     * $billets: un array de billets   coupures et qte
	     */ 
	    $monArgent = $this->getArgent();
        foreach ($billets as $valeur => $qte) {
            $monArgent[$valeur] += $qte; //TODO: verifier que les qte sont positives, ou accepter les n�gatives mais planter si y'en a pas assez. La fonction ferait donc un encaisse et un d�caisse
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
        echo "Le joueur à ".$argentCtr."$ et doit payer ".$montant."$";
        echo "</br>";
        
        if($argentCtr < $montant){
                echo "Le joueur n'a pas assez d'argent. ".($montant-$argentCtr)."$ de plus sont nécéssaire.";
        }
        else{
                echo "Argent du joueur avant : ".$argentCtr."<br/>";
                echo "Montant à payer: ".$montant."<br/>";
                
                $argentCtr -= $montant;
                echo "Argent du joueur après: ".$argentCtr."<br/>";
                
                //creation de l'array de paiement exemple le joueur doit payer 350, il paye avec un 500
                // montantCtr = valeur que le joueur recupere
                // quantiteCtr = quantite de billet utilisé
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
                // quantiteCtr = quantite de billet recuperé
                foreach($argent as $billet=>$quantite){
                	//echo "montantctr retour: ". $montantCtr . "</br>";
                        if($billet <= $montantCtr){
                                    $quantiteCtr = floor($montantCtr / intval($billet));
                                    $quantite += $quantiteCtr;
                                    
                                    //echo "Billet retour :".$billet."</br>";
                                    //echo "Quantité Retour : ".$quantiteCtr."</br>";
                                    
                                    if($quantiteCtr != 0){
                                            $montantCtr -= intval($billet) * $quantiteCtr;
                                            //echo "Montant Retour ".$montantCtr."</br>";
                                    }
                           
                               
                        }
                        $argent[$billet]=$quantite;
                }
                
        }
        //appel la fonction encaisse pour mettre a jour l'argent du joueur.
        $this->encaisse($argent);
        return $argent;
    }

	public function tenterAchat(CaseDeJeuAchetable $uneCase){
	    return true;
	}

	// Getter & Setter
	
	public function getCompte() {
	    return $this->compte;
	}
	public function setCompte($value) {
	    $this->compte = $value;
	    $this->notifie();
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
	    $this->notifie();
	}
	
	public function getToursRestantEnPrison() {
	    return $this->toursRestantEnPrison;
	}
	public function setToursRestantEnPrison($value) {
	    $this->toursRestantEnPrison = $value;
	    $this->notifie();
	}
	
	public function getEnPrison() {
	    return $this->enPrison;
	}
	public function setEnPrison($value) {
	    $this->enPrison = $value;
	    $this->notifie();
	}

	public function getOrdreDeJeu() {
	    return $this->ordreDeJeu;
	}
	public function setOrdreDeJeu($value) {
	    $this->ordreDeJeu = $value;
	    $this->notifie();
	}
	
	public function getPosition() {
	    return $this->position;
	}
	public function setPosition($value) {
	    $value = $value % 40; //TODO: remplacer 40 par le nombre de case du jeu
	    $this->position = $value;
	    $this->notifie();
	}
	
	public function getPionId() {
	    return $this->pionId;
	}
	public function setPionId($value) {
	    $this->pionId = $value;
	    $this->notifie();
	}
	
	public function getPartieId() {
	    return $this->partieId;
	}
	public function setPartieId($value) {
	    $this->partieId = $value;
	    $this->notifie();
	}
	
}
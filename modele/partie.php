<?php 
require_once "interface/entreposageDatabase.php";
require_once "modele/objet.php";
require_once "modele/coordonnateur.php";
require_once "dataMapper/partieDataMapper.php";
require_once "dataMapper/joueurDataMapper.php";
require_once "modele/tableau.php";
require_once "modele/definitionPartie.php";
require_once "modele/carteChance.php";
require_once "modele/carteCC.php";

//TODO: plutot que d'avoir ces constantes, on devrait avoir une fonction qui verifie l'etat
define("INTERACTION_ACHATPROPRIETE", 1);
define("INTERACTION_ACHATHOTEL",2);
define("INTERACTION_ACHATMAISON",3);
define("INTERACTION_VENTEPROPRIETE",4);
define("INTERACTION_VENDRECARTEACTION",5);
define("INTERACTION_HYPOTHEQUER",6);
define("INTERACTION_RACHETER",7);
define("INTERACTION_SORTIRDEPRISON",8);

class Partie extends Objet implements EntreposageDatabase {
    protected $id;
    protected $nom;
    protected $coordonnateur;
    protected $definitionPartieId; //l'id de la definition de partie
    protected $joueurTour;
    protected $debutPartie; //la date et heure du debut de la partie, en tant qu'objet Date
    
    protected $nombreJoueursActifs; // nombre de joueurs restants
    protected $tableau; // le tableau sur lequel se deroule la partie
    protected $banque;
    protected $premierDes;
    protected $deuxiemeDes;
    protected $cartesChance;
    protected $cartesCaisseCommune;
    protected $pions;
    protected $maisons;  //TODO: est-ce que ca devrait plutot appartenir a la banque
    protected $hotels;

    protected $definitionPartie = null; //l'objet representant la definition de partie. 
    protected $interactionId; //l'id de l'interation qui est presentement en cours. 
    protected $jouerEncore; //indique qu'un double vient d'etre joue et qu'on ne doit pas avancer le joueur
   
    public function __construct(array $array) {
        $this->id = $array["Id"];
        $this->nom = $array["Nom"];
        $this->coordonnateur = $array["Coordonnateur"];
        $this->definitionPartieId = $array["DefinitionPartieId"];
        $this->joueurTour = $array["JoueurTour"];
        $this->debutPartie = DateTime::createFromFormat('Y-m-d h:i:s', $array["DebutPartie"]);
        $this->interactionId = $array["InteractionId"];
        $this->nombreJoueursActifs = $array["NombreJoueurs"];
        $this->jouerEncore = $array["JouerEncore"];
        //TODO: ajouter dans la BD la position de la carte chance et CC presentement sur le top
    }
    
    // Static Factory
    
    public static function parId($id) {
        $partieMapper = new PartieDataMapper();
        return $partieMapper->find(array($id));
    }
    
    public static function pourCoordonnateur(Coordonnateur $coordonnateur) {
        /*
         * retourne la liste des parties associees a un coordonnateur
         */
        $partieMapper = new PartieDataMapper();
        //LISTEPARTIES 1.3.1.1.x : cette fonction est une factory. Utilise un datamapper pour extraire la liste des parties pour un coordonnateur.
        return $partieMapper->findPourCoordonnateur($coordonnateur->getCompte());
    }    
    
    // interface entreposageDatabase
    public function getDataMapper() {
        return new PartieDataMapper();
    }
    
    public function sauvegarde() {
        $this->getDataMapper()->insert($this);
    }
    
    // fonction de jeu
    
    public function ajouteJoueur($usager) {
        /*
         * ajoute un usager a la partie
         * l'usager devient donc un joueur
         * 
         * 
         */
        
        //TODO: ajouter le check si jamais ce joueur est deja dans la partie
       
        $ordre = count($this->getJoueurs())+1; //premier arrivee, premier a jouer
        
        $joueur = Joueur::nouveauJoueur(array('UsagerCompte'=>$usager->getCompte(),
                                    'PartieEnCoursId'=>$this->getId(),
                                    'PionId'=>0,
                                    'Position'=>0,
                                    'OrdreDeJeu'=>$ordre,
                                    'EnPrison'=>0,
                                    'ToursRestants_Prison'=>0,
                                    'Billets'=>array())); //les billets seront ajoutes quand la partie sera vraiment demarree
        
    }
    
    public function estDemarre() {
        /*
         * retourne vrai si la partie est demarree, faux si non
         */
        
        $heureDebut =$this->heureDebut();
        return  $heureDebut != 0;
    }
    
    public function pionsDisponibles() {
        $pions = $this->definitionPartie()->getPions();
        foreach($pions as $pion) {
            $pions2[$pion->getId()]=$pion;
        }
        $joueurs = $this->getJoueurs();
        foreach($joueurs as $joueur) {
            if (isset($pions2[$joueur->getPionId()])) {
                unset($pions2[$joueur->getPionId()]); //enleve le pion qu'un joueur a deja pris
            }
        }
        return $pions2;
    }
    
    public function heureDebut() {
    
        return $this->getDebutPartie();//->format('H:i');
    }
    
    public function demarrerPartie()
    {
        $id = $this->getDefinitionPartieId();
        $definition = DefinitionPartie::parId($id);
    
        foreach ($this->getJoueurs() as $joueur) :
            $joueur->setArgent($definition->getArgent());
        endforeach;
        
        // set la date de debut de partie au moment present. 
        $this->setDebutPartie(date('Y-m-d g:h:i'));
    }
    
    public function joueurPresent(Usager $usager) {
        /*
         * verifie si un joueur est deja dans cette partie
         */
        $joueurs = $this->getJoueurs();
        $present = false;
        foreach ($joueurs as $joueur) {
            if ($joueur->getCompte() == $usager->getCompte()) {
                $present = true;
            }
        }
        return $present;
    }
    
    //Getters & Setters
    public function getNom() {
        return $this->nom;
    }
    
    public function setNom($value) {
        $this->nom = $value;
        $this->notifie("nom");
    }
    
    public function getCoordonnateur() {
        return $this->coordonnateur;
    }
    
    public function setCoordonnateur($value) {
        $this->coordonnateur = $value;
        $this->notifie("coordonnateur");
    }
    
    public function getHotels() {
        return $this->hotels;
    }
    
    public function setHotels($value) {
        $this->hotels = $value;
        $this->notifie("hotels");
    }

    public function getMaisons() {
        return $this->maisons;
    }
    
    public function setMaisons($value) {
        $this->maisons = $value;        
        $this->notifie("maisons");
    }

    public function getPions() {
        return $this->pions;
    }
    
    public function setPions($value) {
        $this->pions = $value;
        $this->notifie("pions");
    }

    public function getCartesCaisseCommune() {
        return $this->cartesCaisseCommune;
        //TODO: lazy load a partir de PartieEnCours_CarteCC
    }
    
    public function setCartesCaisseCommune($value) {
        //FIXME: je crois pas qu'on doit avoir un set puisque que c'est loade
        $this->cartesCaisseCommune = $value;
        $this->notifie("cartesCaisseCommune");
    }


    public function getCartesChance() {
        return $this->cartesChance;
    }
    
    public function setCartesChance($value) {
        $this->cartesChance = $value;
        $this->notifie("cartesChance");
    }


    public function getBanque() {
        return $this->banque;
    }
    
    public function setBanque($value) {
        $this->banque = $value;
        $this->notifie("banque");
    }

    public function getPremierDes() {
    	return $this->premierDes;
    }
    
    public function setPremierDes($value) {
    	$this->premierDes = $value;
    }
    
    public function getDeuxiemeDes() {
    	return $this->deuxiemeDes;
    }
    
    public function setDeuxiemeDes($value) {
    	$this->deuxiemeDes = $value;
    }

    public function getJoueurs() {    
        return Joueur::PourPartie($this->getId());
    }
    
    /*
     * on ne set pas les joueurs, on ajouter 1 joueurs a la fois avec ajouteJoueur()
     * public function setJoueurs($value) {
        $this->joueurs = $value;
    }
    */
    
    public function getId() {
        return $this->id;
    }
    public function setId($value) {
        $this->id = $value;
        $this->notifie("id");
    }

    public function getTableau() {
        if ($this->tableau == null) {
            //lazy load
            $this->tableau=Tableau::pourDefinition($this->getDefinitionPartieId());
        }    
        return $this->tableau;
    }

    /*
     *  pas de setTableau puisqu'on va chercher le tableau dans la definition de partie
     */ 
	
	//Fonctions autres
    public function getProchaineCarteCC(){
        $cartes=CarteCC::pourDefinitionPartie($this->id);
        $prochaineCarte=CarteCC::parPositionCarte(1,$this->id);  // Carte au sommet de la pile
    
        if(!$prochaineCarte->getType=="CCg"){
            foreach($cartes as $carte){
                if($carte->getPosition()==1) {
                    $carte->setPosition(count($cartes));
                } else {
                     $carte->setPosition($carte->getPosition()-1);
                }
            }
        }
    
        return $prochaineCarte;
    }
    
    public function getProchaineCarteChance(){
        $cartes=CarteChance::pourDefinitionPartie($this->id);
        foreach($cartes as $carte){                               // Les cartes ne sont pas deplacees.
        	foreach($cartes as $carte){
        		if($carte->getPosition()==count($cartes)) {
            		$carte->setPosition(1);
        		} else {
            		$carte->setPosition($carte->getPosition()+1);
        		}
				$carte->sauvegarder();
        	}
       	}
    
        return $prochaineCarte;
    }
  
    public function casesDuGroupe($groupeDeCarteId) {
        //retourne les cases de jeu d'un groupe (train, service, couleur)
        //ATTENTION: les cases retournees ne sont pas positionnees sur le tableau. 
        
        //c'est juste les cases achetables qui font partie d'un groupe
        $casesAchetables =  CaseDeJeuAchetable::pourDefinitionPartie($this->getId()); 
        $casesDuGroupe = array();
        foreach ($casesAchetables as $case) {
            if ($case->getGroupeDeCaseId() == $groupeDeCarteId) {
                $casesDuGroupe[] = $case;
            }
        }
        
        return $casesDuGroupe;
    }
    
    public function tourDuJoueur ($joueur) {
    // Vérifie si c'est bien le tour du joueur '$joueur' à jouer

    	if ($this->joueurTour == $joueur->getOrdreDeJeu()) {
    		return true;
    	}
    	else {
    		return false;
    	}
    }
    
	public function jouerCoup($joueur) {
	// Joue un coup pour faire avancer un joueur	
		
		if ($this->tourDuJoueur($joueur)) {
		// Si c'est le tour de ce joueur, jouer le coup
			$joueur->avanceSurCase();
		}
		else {
			echo "Ce n'est pas votre tour."; //TODO: generer une exception
		}
	}
	
	public function avancerTour () {
	// Incremente la variable joueurTour pour que le prochain joueur puisse jouer
	    if ($this->getJouerEncore() == 0) { //on a pas eu un double
    		$this->setJoueurTour($this->getJoueurTour() + 1);
	    	if ($this->getJoueurTour() > $this->nombreJoueursActifs) {
		        // Si joueurTour dépasse le nombre de joueurs dans la partie, soustrait le nombre de joueurs actifs
			    $this->setJoueurTour($this->getJoueurTour() - $this->nombreJoueursActifs);
		    }
	    } else {
	        //on a eu un double: reset le flag pour indiquer qu'il a été traité
	        //TODO: s'assurer que le flag est reset aussi si jamais le joueur est elimine entre ses 2 coups. 
	        $this->setJouerEncore(0);
	    }
	}

    public function getDebutPartie() {
        return $this->debutPartie->format('Y-m-d h:i:s');
    }
    public function setDebutPartie($value) {
        $this->debutPartie = $value;
        $this->notifie("debutPartie");
    }
    
    public function getJoueurTour() {
        return $this->joueurTour;
    }
    public function setJoueurTour($value) {
        $this->joueurTour = $value;
        $this->notifie("joueurTour");
    }
    
    public function getDefinitionPartieId() {
        return $this->definitionPartieId;
    }
    public function setDefinitionPartieId($value) {
        $this->definitionPartieId = $value;
        $this->notifie("definitionPartieId");
    }
    
    public function definitionPartie() {
        if (is_null($this->definitionPartie)) {
           $this->definitionPartie= DefinitionPartie::parId($this->getDefinitionPartieId());
        }
        return $this->definitionPartie;
    }
    // pas de setter car la definition est charge a partir du Id
    
    public function setInteractionId($value) {
        $this->interactionId = $value;
        $this->notifie("interactionId");
    }
    
    public function getInteractionId() {
        return $this->interactionId;
    }
    
    public function setJouerEncore($value) {
        $this->jouerEncore = $value;
        $this->notifie("jouerEncore");
    }
    
    public function getJouerEncore() {
        return $this->jouerEncore;
    }
    
    public function genererValeursDes() {
    // Genere une valeur aleatoire entre 1 et 6 pour les 2 deux des
    	$this->premierDes = rand(1, 6); //TODO: utiliser les setters 
    	$this->deuxiemeDes = rand(1, 6);
    }
    
    public function desValeursIdentiques () {
    // Retourne un bool dependamment si les valeurs des des sont identiques
    	if ($this->premierDes == $this->deuxiemeDes) { //TODO: utiliser les getters
    		return true;
    	}
    	else {
    		return false;
    	}
    }
    
    // TODO : Get & Set de nombreJoueursActifs
}
?>

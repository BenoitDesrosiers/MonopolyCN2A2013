<?php
/* Cette classe gere l'instanciation des classes du modele
 * Elle utilise un array associatif ou la cle est le nom de la classe appelante et la cle unique representant un objet dans cette classe
 * et la valeur est l'objet. 
 * 
 */


class GestionInstance {
    static protected $inventaire = array(); //l'array associative contenant les objets

    private static function creerCle($appelant, array $cle){
        // concatene le nom de la classe appelant avec les champs de la cle pour obtenir une cle unique
        $cleUnique = get_class($appelant);
        foreach ($cle as $valeur) {
            $cleUnique = $cleUnique . $valeur;
        }
        return $cleUnique;
    } 
    
    public static function objetExiste($appelant, array $cle) {
        return (array_key_exists(self::creerCle($appelant, $cle), self::$inventaire));
    }
    
    public static function enregistre($appelant, array $cle, $objet) {
        /*
         *  $appelant : le nom de la classe appelante (mettre __CLASS__ dans l'appelant)
         *  $cle : l'array contenant les champs necessaire a la creation de l'objet
         */
        
        if (!self::objetExiste($appelant, $cle)) {
            self::$inventaire[$cleUnique] = $objet;
        }
        
    }   
    
    //TODO: faudrait une fonction pour de-enregistrer les objets afin que le garbage manager puisse les dŽtruires...
    

    public static function extraitObjet($appelant, array $cle) {
        $cleUnique = self::creerCle($appelant, $cle);
        $obj = null;
        if (self::objetExiste($appelant, $cle)) {
            $obj = self::$inventaire[$cleUnique];
        }
        return $obj;
    }
}

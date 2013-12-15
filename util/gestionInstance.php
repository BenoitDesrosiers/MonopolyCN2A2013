<?php
/* Cette classe gere l'instanciation des classes du modele
 * Elle utilise un array associatif ou la cle est le nom de la classe appelante et la cle unique representant un objet dans cette classe
 * et la valeur est l'objet. 
 * 
 */


class GestionInstance {
    static protected $inventaire = array(); //l'array associative contenant les objets

   
    
    public static function objetExiste($cleComposee) {
        return (array_key_exists($cleComposee, self::$inventaire));
    }
    
    public static function enregistre($cle, $objet) {
        /*
         *  $cle : l'array contenant les champs necessaire a la creation de l'objet
         */
        
        if (!self::objetExiste($cle)) {
            self::$inventaire[$cle] = $objet;
        }
        
    }   
    
    //TODO: faudrait une fonction pour de-enregistrer les objets afin que le garbage manager puisse les dŽtruires...
    

    public static function extraitObjet( $cle) {
        $obj = null;
        if (self::objetExiste($cle)) {
            $obj = self::$inventaire[$cle];
        }
        return $obj;
    }
}

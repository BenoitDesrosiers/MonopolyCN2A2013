<?php
/* Cette classe gere l'instanciation des classes du modele
 * Elle utilise un array associatif ou la cle est le nom de la classe appelante et la cle unique representant un objet dans cette classe
 * et la valeur est l'objet. 
 * 
 */

require_once 'dataMapper/mapper.php';

class GestionInstance {
    static protected $inventaire = array(); //l'array associative contenant les objets

    public static function enregistre($appelant, array $cle, Mapper $dm) {
        /*
         *  $appelant : le nom de la classe appelante (mettre __CLASS__ dans l'appelant)
         *  $cle : l'array contenant les champs necessaire a la creation de l'objet
         *  $dm : le datamapper qui doit etre appele si l'objet n'est pas deja cree
         */
        
        // concatene les champs de la cle pour obtenir une cle unique
        $cleUnique = $appelant;
        foreach ($cle as $valeur) {
            $cleUnique = $cleUnique . $valeur;
        } 
        
        //trouve l'objet dans l'array, ou le cree via le datamapper
        if (array_key_exists($cleUnique, self::$inventaire)) {
            $objet = self::$inventaire[$cleUnique];
        } else {
            $objet = $dm->find($cle);
            if (is_null($objet) ) {
                //TODO: generer une exception
            } else {
                self::$inventaire[$cleUnique] = $objet;
            }
        }
        return $objet;
    }      
}

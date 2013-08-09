<?php
/* Cette interface définit les functions nécessaire pour un objet qui 
 * s'enregistre dans une base de donné SQL
 */

interface EntreposageDatabase {
    public function sauvegarde();    //enregistre $this dans la database
    public function getDataMapper(); //retourne une instance d'une sous-classe de Mapper
    
}
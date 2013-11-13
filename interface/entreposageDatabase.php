<?php
/* Cette interface definit les functions necessaire pour un objet qui 
 * s'enregistre dans une base de donne SQL
 */

interface EntreposageDatabase {
    public function sauvegarde();    //enregistre $this dans la database
    public function getDataMapper(); //retourne une instance d'une sous-classe de Mapper
    
}
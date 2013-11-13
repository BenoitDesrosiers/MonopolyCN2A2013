<?php
/* Cette interface definit les functions necessaire pour un objet qui 
 * observe un autre objet
 */

interface Observateur {
    public function update($objet, $sujet);   
    
}
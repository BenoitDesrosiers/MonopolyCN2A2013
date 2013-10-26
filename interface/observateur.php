<?php
/* Cette interface définit les functions nécessaire pour un objet qui 
 * observe un autre objet
 */

interface Observateur {
    public function update($objet);   
    
}
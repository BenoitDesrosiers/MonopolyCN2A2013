<?php
/*
 -- Par Tommy Teasdale
*/
/* 
 * controlleur permettant de récupérer un message d'aide avec Ajax  
 */
require_once('../util/main.php');

// Obtenir le nombre de message d'aide dans la BD
function getNbAide(){
    $bd=Database::getDB();
    
    $nb=$bd->query('SELECT * FROM Aide');
    $ctr=0;
    while ($donb = $nb->fetch()){
        $ctr++;
    }
    
    return $ctr;
}

// Obtenir un message d'aide dans la BD
function getAide($a_numaide){
    $bd=Database::getDB();
    
    $statement=$bd->prepare('SELECT texte FROM Aide WHERE id=?');
    $statement->execute(array($a_numaide));
	
	while ($donnee = $statement->fetch()){
        $texte=$donnee['texte'];
    }
    
    return $texte;
}

if (isset($_POST['action'])) {
	$action=$_POST['action'];
} else if (isset($_GET['action'])) {
	$action=$_GET['action'];
}

switch ($action) {
    case 'getnbaide':
        $return=getNbAide();
        break;
    case 'getaide':
        $numAide=$_POST['aide'];
        $return=getAide($numAide);
        break;
}

if(isset($return))
    echo $return;


?>
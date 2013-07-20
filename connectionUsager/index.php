<?php
/*gestion du login */
require_once('../util/main.php');
require_once('util/secure_conn.php');

require_once('factories/usager_factory.php');

// Démarre la session pour conserver l'usager
session_start();

if (isset($_POST['action'])) {
    $action = $_POST['action'];
} elseif (isset($_GET['action'])) {
    $action = $_GET['action'];
} elseif (isset($_SESSION['user'])) {
    $action = 'voir_compte';
} else {
    $action = 'demande_de_connection';
}

$redirect=$_GET['redirect'];
if ($redirect=="") {
    $redirect="../index.php";
}
$titrePage = "Connection";
switch ($action) {
	case 'voir_compte':
		include 'voir_connection.php';
		break;
    case 'demande_de_connection':
    	//reset les factories  
    	//TODO: est-ce que c'est correct de faire ca? est-ce que je crée des objets sans parents
    	//TODO: et est-ce ici que ca devrait se faire?
    	$_SESSION['lesFactories']=null;
        include 'loginUsager.php';
        break;
    case 'view_register':
        include 'enregistrer_compte.php'; //TODO: à faire, demande toute l'info d'un usager
        
        break;
    case 'connection':
        $compte = $_POST['compte'];
        $password = $_POST['password'];
        unset($_SESSION['usager']);
        $usagerFactory = Usager_Factory::singleton();
        $usager = $usagerFactory->parComptePW($compte, $password);
        if ($usager <> null) {
            $_SESSION['usager'] = $usager;
            redirect($redirect);
        } else {
            affiche_erreur('Connection impossible, compte ou mot de passe invalide.');
        }
		redirect('.');
        break;
    
    case 'deconnection':
        unset($_SESSION['usagers']);
        redirect('.');
        break;
    default:
        affiche_erreur("Action inconnue: " . $action);
        break;
}
?>
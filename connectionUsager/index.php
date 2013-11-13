<?php
/*gestion du login */
require_once('../util/main.php');
require_once('util/secure_conn.php');

require_once('modele/usager.php');

// Demarre la session pour conserver l'usager
session_start();

if (isset($_POST['action'])) {
    //CONNECTION 1.2.3 : on revient ici après que le formulaire ait ete remplie. L'action etant mise a "connection"
    $action = $_POST['action'];
} elseif (isset($_GET['action'])) {
    $action = $_GET['action'];
} elseif (isset($_SESSION['user'])) {
    $action = 'voir_compte';
} else {
    //CONNECTION 1.2.1 : on arrive ici a partir de login.php
    $action = 'demande_de_connection';
}

$redirect=$_GET['redirect'];
if ($redirect=="") {
    $redirect="../index.php";
}
$titrePage = "Connection";
switch ($action) {
	case 'voir_compte':
		include 'voir_connection_view.php';
		break;
    case 'demande_de_connection':
        //CONNECTION 1.2.2.x: on affiche l'ecran de login
        include 'loginUsager_view.php';
        break;
    case 'view_register':
        include 'enregistrer_compte.php'; //TODO: a faire, demande toute l'info d'un usager
        break;
    case 'connection':    //CONNECTION 6b : on verifie l'identite de l'usager
        $compte = $_POST['compte'];
        $password = $_POST['password'];
        unset($_SESSION['usager']);
        //CONNECTION 1.2.4.x : cette methode essaye de creer un usager a partir de la bd 
        $usager = Usager::parComptePW($compte, $password);
        if ($usager <> null) {
            $_SESSION['usager'] = $usager; //CONNECTION 1.2.5a : on entrepose l'usager dans la session pour le recuperer a l'etape LISTEPARTIE 1.2
            redirect($redirect); //CONNECTION 1.2.5.x : l'usager a ete cree correctement, on retourne a la page qui nous a appele (mise dans $redirect)
        } else {
            //CONNECTION 1.2.4a : l'usager n'existe pas dans la bd
            affiche_erreur('Connection impossible, compte ou mot de passe invalide.');
            //TODO: permettre de se reessayer
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
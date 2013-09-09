<?php
/*gestion du login */
require_once('../util/main.php');
require_once('util/secure_conn.php');

require_once('modele/usager.php');

// Démarre la session pour conserver l'usager
session_start();

if (isset($_POST['action'])) {
    //CONNECTION 1.2.3 : on revient ici après que le formulaire ait été remplie. L'action étant mise à "connection"
    $action = $_POST['action'];
} elseif (isset($_GET['action'])) {
    $action = $_GET['action'];
} elseif (isset($_SESSION['user'])) {
    $action = 'voir_compte';
} else {
    //CONNECTION 1.2.1 : on arrive ici à partir de login.php
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
        //CONNECTION 1.2.2.x: on affiche l'écran de login
        include 'loginUsager_view.php';
        break;
    case 'view_register':
        include 'enregistrer_compte.php'; //TODO: à faire, demande toute l'info d'un usager
        break;
    case 'connection':    //CONNECTION 6b : on vérifie l'identité de l'usager
        $compte = $_POST['compte'];
        $password = $_POST['password'];
        unset($_SESSION['usager']);
        //CONNECTION 1.2.4.x : cette méthode essaye de créer un usager à partir de la bd 
        $usager = Usager::parComptePW($compte, $password);
        if ($usager <> null) {
            $_SESSION['usager'] = $usager; //CONNECTION 1.2.5a : on entrepose l'usager dans la session pour le récupérer à l'étape LISTEPARTIE 1.2
            redirect($redirect); //CONNECTION 1.2.5.x : l'usager a été créé correctement, on retourne à la page qui nous a appelé (mise dans $redirect)
        } else {
            //CONNECTION 1.2.4a : l'usager n'existe pas dans la bd
            affiche_erreur('Connection impossible, compte ou mot de passe invalide.');
            //TODO: permettre de se réessayer
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
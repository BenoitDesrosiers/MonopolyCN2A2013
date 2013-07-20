<?php
// la racine du serveur

$doc_root =  $_SERVER['DOCUMENT_ROOT'];

// le chemin vers le projet
$uri = $_SERVER['REQUEST_URI'];
$dirs = explode('/', $uri);
// app_path doit contenir le nombre de dirs nécessaire selon le path du dir de l'application à partir de DOCUMENT_ROOT
$app_path = '/' . $dirs[1] . '/'; // . $dirs[2] . '/';


// set le include path
set_include_path($doc_root . $app_path);

// inclut le gestionnaire de bd
require_once('modele/database.php');

// Defini quelque fonctions commune
function affiche_erreur_db($msg_erreur) {
    global $app_path;
    include 'erreurs/db_erreur.php';
    exit;
}

function affiche_erreur($msg_erreur) {
    global $app_path;
    include 'erreurs/erreur.php';
    exit;
}

function redirect($url) {
    session_write_close();
    header("Location: " . $url);
    exit;
}


?>

<?php

require_once('../../util/main.php');
require_once('../../modele/joueur.php');
require_once('../../modele/partie.php');

session_start(); // Résume la session

$partie = Partie::parId($_SESSION['partieId']); // Créé la partie

$nomPartie = $partie->getNom(); // Stock le nom de la partie (String)
$debutPartie = $partie->getDebutPartie(); // Stock le début de la partie (String)
$tourDuJoueur = $partie->getJoueurTour(); // Stock le tour du joueur (int)
$listeJoueurs = $partie->getJoueurs(); // Stock la liste des joueurs (array<Joueur>)

foreach ($listeJoueurs as $joueur) {
	$listeOrdonneeJoueurs[$joueur->getOrdreDeJeu()] = $joueur; // Ajoute le joueur à la liste
}

ksort($listeOrdonneeJoueurs); // Ordonne la liste des joueurs selon la 'key' de la liste

echo "<li>Nom de la partie: <span style=\"font-weight:normal;\">" . $nomPartie . "</span></li>"; // Élément contenant le nom de la partie
echo "<li>D&eacute;but de la partie: <span style=\"font-weight:normal;\">" . $debutPartie . "</span></li> <br/>"; // Élément contenant la date et l'heure de début
echo "<li>Liste des joueurs: </li>"; // Affichage de "Liste de joueurs: "
echo "<ul id=\"listeJoueurs\">"; // Affiche une liste de joueurs
foreach ($listeOrdonneeJoueurs as $joueur) {
	echo "<li style=\"font-weight: bold;margin-left: 15px;"; // Affichge du nom du joueur
	if ($joueur->getOrdreDeJeu() == $tourDuJoueur) { // Si c'est le tour de ce joueur
		echo " \" id=\"joueurJouant\">"; // Y mettre l'id "joueurJouant" pour pouvoir l'identifier
	}
	else { // Sinon
		echo "color: orange;\">"; // On met la couleur du nom orange pour dire que ce n'est pas son tour
	}
	echo $joueur->getCompte() . "</li>"; // On met le nom du joueur et referme la balise
}
echo "</ul>"; // Fermeture de la liste

?>
<?php 
/*
 * le joueur est en prison. 
 * Affiche le choix d'actions possibles au joueur avant de jouer son coup. 
 * 
 */?>

	<div id="navigation">
		<!--les boutons pour jouer: refresh, brasser, acheter Maison/hotel, quitter -->
		<ul id="choixNavigation" class="menuAvecBouton">
			<li><a href=".?action=JouerCoup"><b>Attendre</b></a></li>
            <li><a href=".?action=74"><b>Payer</b></a></li> <!--//TODO verifier si c'est au tour de ce joueur de jouer un coup. Si non, afficher un piton refresh au lieu de jouer -->
		</ul>
	</div> <!-- navigation -->

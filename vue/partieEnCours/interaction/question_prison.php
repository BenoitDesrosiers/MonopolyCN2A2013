<?php 
/*
 * le joueur est en prison. 
 * Affiche le choix d'actions possibles au joueur avant de jouer son coup. 
 * 
 */?>

	<div id="navigation">
		Vous &ecirc;tes en prison. </br>
		Que voulez-vous faire?
		<ul id="choixNavigation" class="menuAvecBouton">
			<li><a href=".?action=QuestionPrison&valeur=attendre"><b>Attendre</b></a></li>
            <li><a href=".?action=QuestionPrison&valeur=payer"><b>Payer</b></a></li>
            <li><a href=".?action=QuestionPrison&valeur=carte"><b>Carte</b></a></li>
		</ul>
	</div> <!-- navigation -->

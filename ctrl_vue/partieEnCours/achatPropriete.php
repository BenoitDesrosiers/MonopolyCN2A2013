<?php ?>
    <div id="navigation">
    <?php echo $texteQuestion;?>
			<!-- pose une question avec une reponse oui ou non. 
			     le ctrl peut recuperer la reponse sur l'action repondreouinon, et le champ valeur.  -->
			<div class="menuAvecBouton">
				<a href=".?action=repondreouinon&valeur=oui"><b>Oui</b></a>
				<a href=".?action=repondreouinon&valeur=non"><b>Non</b></a>
			</div>
	</div> <!-- navigation -->
<div id="interaction">
	<form id="menu-Form" action="index.php?action=AcheterHotel" method="post">
	<?php	
		$listeCasesId = $joueur->listeCasesHotelBatissable(); 
	
		if ($listeCasesId != null) { 
			foreach ($listeCasesId as $caseId) {
				$case = CaseDeJeuAchetable::parId($caseId);
	?>
				<button type="submit" name="caseId" value="<?php echo $caseId; ?>">Acheter un h&ocirc;tel</button> <!-- Cree un bouton avec l'id de la case comme valeur --> 
				<?php echo $case->getNom(); ?> <!-- Affiche le nom du terrain a cote du bouton -->
				<br/>
	<?php 
			}
		}
		else {
			echo "<p> Vous n'avez aucun terrain disponible pour acheter un h&ocirc;tel. </p>";
		} 
	?>
	</form>
</div> <!-- interactoin -->

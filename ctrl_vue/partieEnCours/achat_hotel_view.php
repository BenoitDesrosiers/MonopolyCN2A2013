	
<form id="menu-Form" action="index.php?action=AcheterHotel" method="post">
<?php	
	$listeCasesId = $joueur->getListeCases(); // Stockage d'un array d'id de cases

	if ($listeCasesId != null) { // Si l'array n'est pas vide
		foreach ($listeCasesId as $caseId) {
			$case = CaseDeJeuAchetable::parId($caseId); // Créé la case selon l'id de case
?>
			<button type="submit" name="caseId" value="<?php echo $caseId; ?>">Acheter un hôtel</button> <!-- Créé un bouton avec l'id de la case comme valeur --> 
			<?php echo $case->getNom(); ?> <!-- Affiche le nom du terrain à côté du bouton -->
			<br/>
<?php 
		}
	}
	else {
		echo "<p> Vous n'avez aucun terrain possible pour acheter un hôtel. </p>";
	} 
?>
</form>

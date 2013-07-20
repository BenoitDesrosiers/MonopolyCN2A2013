<?php 
// ENTRÉES:
// $partie: la partie à afficher. Peut-être vide pour une création, ou une partie existante pour une modification  
?>
<!DOCTYPE html>
<html>
<head>
    <?php include 'vue/headCommun.php'; ?>
    <link rel="stylesheet" type="text/css" href="<?php echo $GLOBALS['app_path'].'css/creationPartie.css'?>" />
    
    <script>
   
    </script>
    
</head>

<body>
    <?php include 'vue/enteteCommune.php'; ?>

    <div id="conteneur">
    	<form action="" method="post">
    	<input type="hidden" name="action" value="validerEtContinuer"/>
    	
    	<div id="section-Id-Partie">
    		<label for="idPartie">Id de la partie</label>
    		<input id="idPartie" name="idPartie" type="text" value="<?php echo $partie->getId();?>" maxlength="10" required size="50" />
    	</div>
    	
  >>>>>> a refaire au complet   	
    	    	<div class="debut-section" id="section-Cours-Groupe">
    		<p>Sélectionnez les classes pour ce test</p>
    		<!-- affiche la liste des classes (cours * période) -->
    		<div id="liste-Cours">
    			<table id="table-Liste-Cours" border="1">
    				<tr>
    					<th></th>
    					<th>Cours</th>
    					<th>Groupe</th>
    					<th>Nbr Étudiants</th>
    					<th>Local</th>
    					<th>Période</th>
    				</tr>
    				<?php 
    					$i = 0;
    					$totalEtudiants = 0; // le grand total du nombre d'étudiants dans toutes les classes.
    					$totalEtudiantsSelectionnes = 0; //le total du nombre d'étudiants pour les classes sélectionnées
    					foreach ($classesEnseignes as $uneClasse) :
    						$i = $i+1;
    					    $unGroupe = $uneClasse->getGroupeAssocie();
    						$coursAssocie = $unGroupe->getCoursAssocie();
    				?>
    				<tr>
    					<td> <input type="checkbox" name="classeSelecteur" value="<?php echo $i?>" onclick="calculEtudiantSelectionne(this.checked,<?php echo $unGroupe->getNombreEtudiants() ?>)" > </td>
    					<?php //TODO: ajouter le check si le groupe est déjà sélectionné pour ce test et additionner la valeur dans $totalEtudiantsSelectionnes  ?>
    					<td> <?php echo $coursAssocie->getNom(); ?> </td>
    					<td> <?php echo $unGroupe->getNumero(); ?> </td>
    					<td> <?php echo $unGroupe->getNombreEtudiants(); ?>	</td>
    					<?php //TODO: aller chercher le local pour ce cours groupe ?>
    					<td> <?php echo $uneClasse->getLocal(); ?> </td>
    					<td> <?php preg_match('/[0-9]*:[0-9]*/',$uneClasse->getHeureDebut(),$hDebut);
    					           preg_match('/[0-9]*:[0-9]*/',$uneClasse->getHeureFin(),$hFin);
    					   					echo $uneClasse->getNomJour() . " " . 
    					            $hDebut[0] . "-" . 
    					            $hFin[0]; ?> </td>
    				</tr>
    				<?php		
    					$totalEtudiants += $unGroupe->getNombreEtudiants(); //par certain que j'en ai encore de besoin
    				?>
    				<?php endforeach; ?>
    			</table>
    		</div>
    	
    		<div id="section-Total-Etudiant">
    			<p>total: <span id="total-etudiant"><?php echo $totalEtudiantsSelectionnes; ?></span></p>
    			<?php //TODO: une fct javascript pour changer cette valeur quand un checkmark est séléctionné ?>
    		</div>
    	</div> <!-- section-Cours-Groupe -->
    	
    	
    	<div id="section-Heure-Debut" class="debut-section">
    		<label  for="heure-Debut">Date et heure de début</label>
    		<input id="heure-Debut" name="heureDebut" type="text" value="<?php echo $test->getDebut();?>" maxlength="255" required size="50" />
    	</div>
    	
    	<div id="section-Type-Test" class="debut-section">
    		<p>Type de test</p>
    		<label id="label-Dateheure" for="type-Dateheure">date/heure</label>
    			<input class="radio-Typetest" id="type-Dateheure" type="radio" name="type-Test" value="dateheure" 
    			        <?php if (!$test->estChronometre()) { echo "checked";} ?>
    			        onclick="toggleSections('section-Test-Date-Heure', 'section-Test-Duree')">
    			        
    		<label for="type-Chronometre">chronométré</label>
    			<input class="radio-Typetest" id="type-Chronometre" type="radio" name="type-Test" value="chronometre" 
    		            <?php if ($test->estChronometre()) { echo "checked";} ?>
    		            onclick="toggleSections('section-Test-Duree', 'section-Test-Date-Heure' )">
    		
    		
    		<div id="section-Test-Date-Heure" class="debut-section"   >
    			<label  for="heure-Fin">Date et heure de fin</label>
    			<input id="heure-Fin" name="heureFin" type="text" value="<?php echo $test->getFin();?>" maxlength="255" required size="50" />
    		</div>
    		
    		<div id="section-Test-Duree" class="debut-section"  >
    			<label  for="duree">Durée</label>
    			<input id="duree" name="duree" type="text" value="<?php echo $test->getDuree();?>" maxlength="255" required size="50" />
    		</div>
    		
    		<script>
    	            
    	        document.getElementById("section-Test-Date-Heure").style.display="<?php if ($test->estChronometre()) {echo "none";} else {echo "block";} ?>";
    	        document.getElementById("section-Test-Duree").style.display="<?php if (!$test->estChronometre()) {echo "none";} else {echo "block";} ?>";;
    	        
    		</script>
    	</div>
    	
    	<div id="section-locaux" class="debut-section">
    		<p>Sélectionnez les locaux pour ce test</p>
    		<div id="liste-Locaux">
    			<table id="table-Liste-Locaux" border="1">
    				<tr>
    					<th></th>
    					<th>Local</th>
    					<th>Nbr places</th>
    					<th>Nbr ordinateurs</th>
    				</tr>
    				<?php 
    					$i = 0;
    					$totalPlaces = 0;
    					$totalPlacesSelectionnees = 0;
    					foreach ($locauxDisponibles as $unLocal) :
    						$i = $i+1;
    				?>
    				<tr>
    					<td> <input type="checkbox" name="locaux" value="<?php echo $i?>" 
    							<?php
    								// si ce local est déjà utilisé pour ce test, le checkmark est allumé 
    								if($test->utiliseLocal($unLocal->getNumero())) {
    									echo "checked";
    									$totalPlacesSelectionnees += $unLocal->getNbrPlace();
    								}
    							?>
    						    	
    						    onclick = "calculPlaceSelectionneesVsRequises(this.checked, <?php echo  $unLocal->getNbrPlace(); ?>)"
    							
    							> </td>
    					<td> <?php echo $unLocal->getNumero(); ?> </td>
    					<td> <?php echo $unLocal->getNbrPlace(); ?>	</td>
    					<td> <?php echo $unLocal->getNbrOrdi(); ?>	</td>
    				</tr>
    				<?php		
    					$totalPlaces += $unLocal->getNbrPlace(); //par certain que j'en ai encore de besoin
    				?>
    				<?php endforeach; ?>
    			</table>
    		</div>
    		<div id="section-Places-Selectionnees-Vs-Requises">
    			<p>total: <span id="total-places-selectionnees"><?php echo $totalPlacesSelectionnees; ?></span>
    			          (
    			          <span id="total-places-requises"><?php echo  $totalPlacesSelectionnees-$totalEtudiantsSelectionnes ?></span> )</p>
    			<?php //TODO: une fct javascript pour changer cette valeur quand un checkmark est séléctionné ?>
    		</div>
    	</div> <!-- section-locaux  -->
    	
    	
    	
    	
    	
    	<div id="section-Soumission" class="debut-section">
    		<button type="submit">Sauvegarder et continuer</button>
    	</div>
    	</form>
    </div> <!-- conteneur -->

<?php include 'vue/piedpage.php'; ?>
    
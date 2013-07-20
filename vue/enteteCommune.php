<!-- l'entête commune à toutes les views -->
<div id="page">
	<div id="entete">
		<h1>Monopoly</h1>
		
		<?php
				$usager_url = $GLOBALS['app_path'] .'/connectionUsager';
				$deconnection_url = $usager_url . '?action=deconnection';
				
				 if (isset($_SESSION['usager'])) : ?>
		 	<p>Bienvenue <?php echo $_SESSION['usager']->getNom()?></p>
		 	<ul>
        		<li><a href="<?php echo $usager_url; ?>">Mon compte</a></li>
        		<li><a href="<?php echo $deconnection_url; ?>">Déconnection</a></li>
        	</ul>
    	<?php endif; ?>
		
	</div>
<!-- la div page est fermée dans piedPage.php  -->
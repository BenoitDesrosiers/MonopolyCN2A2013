<?php 
/*
 * l'entete commune a toutes les views
 * 
 * input
 *     $_SESSION['usager']: un objet de la classe Usager
 */
?>
<div id="conteneur">
    <div id="entete">
	       <img id="logoCegep" src="<?php echo $GLOBALS['app_path']."/images/logoCegep.jpg"?>" alt="logoCegep"><br/>
	       <img id="logoJeu" src="<?php echo $GLOBALS['app_path']."/images/monopoly_logo.png"?>" alt="Banniere">    
	</div> <!-- entete -->
	
		<?php
				$usager_url = $GLOBALS['app_path'] .'/connectionUsager';
				$deconnection_url = $usager_url . '?action=deconnection';
				
				 if (isset($usager)) : ?>
		 	<p>Bienvenue <?php echo $usager->getNom()?></p>
		 	<ul>
        		<li><a href="<?php echo $usager_url; ?>">Mon compte</a></li>
        		<li><a href="<?php echo $deconnection_url; ?>">Deconnection</a></li>
        	</ul>
    	<?php endif; ?>
		
<!-- la div conteneur est fermee dans piedPage.php  -->
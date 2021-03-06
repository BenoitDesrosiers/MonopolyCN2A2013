<!DOCTYPE html>
<html>
<head>
    <?php include 'vue/headCommun.php'; ?>
</head>

<body>
    <?php include 'vue/enteteCommune.php'; ?>
    
    <div id="main">			
    	<form id="menu-Form" action="." method="post">
    		<input type="hidden" name="action" value="menu"/>
     		<button type="submit" name="Ajout">Creer une nouvelle partie</button>
     		<button type="submit" name="AfficherTableauTommy">Afficher le tableau de jeu de Tommy</button>
     		<button type="submit" name="AfficherTableauVero">Afficher le tableau de jeu de Vero</button>
     		<button type="submit" name="AfficherTableauSam">Afficher le tableau de jeu de Sam</button>
     		<button type="submit" name="AfficherTableauDavid">Afficher le tableau de jeu de David</button>
     		<button type="submit" name="AfficherTableauEtienne">Afficher le tableau de jeu d'Etienne</button>
     		
			<button type="submit" name="JouerCoup">Jouer un coup</button>
			<button type="submit" name="AtterirSur">Atterir sur une case non Achete</button>
     		<button type="submit" name="PaiementParBatiment">Tester Paiement Par Batiment</button>
     		<button type="submit" name="FairePayerJoueur">Tester faire payer joueur</button>
     	
     		<?php //LISTEJOUEUR 1 vous pouvez ajouter le bouton pour lister les joueurs ici ?>
     	</form>
    	<h1>Liste des parties disponibles</h1>
	    <form action="." method="post">
	    <input type="hidden" value="demarrerPartie" name="action" />
    	<table border="1">
    		<tr>
    			<td>id </td>
    			<td>nom</td>
    			<td>coordonnateur</td>
    			<td>participants</td>
    		</tr>
    		<?php //LISTPARTIE 1.4.1 affiche toutes les parties pour ce coordonnateur?>
    		<?php  foreach ($parties as $partie) : ?>
    			<tr>
    				<td><?php echo $partie->getId();?></td>
    				<td><?php echo $partie->getNom(); ?></td>
    				<td><?php echo $partie->getCoordonnateur(); ?></td>
    				<td>
	    				<p><?php foreach ($partie->getJoueurs() as $joueur) : //Va chercher les joueurs et les affiche ?>
	    					<?php echo $joueur->getCompte();?>
	    				<?php endforeach?></p>
    				</td>
    				<td>
	    					<button type="submit" name="Demarrer" value="<?php echo $partie->getId()?>">Demarrer la partie</button>
	    			</td>
    			</tr>
    		<?php endforeach; ?>
    	</table>
	    </form>
    	<br/>
        </form-->
    </div>
    <?php include 'vue/piedpage.php'; ?>

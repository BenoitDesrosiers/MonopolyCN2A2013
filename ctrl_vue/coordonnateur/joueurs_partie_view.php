<!DOCTYPE html>
<html>
<head>
    <?php include 'vue/headCommun.php'; ?>
</head>

<body>
    <?php include 'vue/enteteCommune.php'; ?>
    
    <div id="main">
    	<h1>Liste des joueurs de la partie <?php echo $partie->getId();?></h1>
	    <form action="." method="post">
	    <input type="hidden" value="liste_parties" name="action" />
    	<table border="1">
    		<tr>
    			<td>id </td>
    			<td>nom</td>
    			<td>argent</td>
    		</tr>
    		<?php //LISTPARTIE 1.4.1 affiche toutes les parties pour ce coordonnateur?>
    		<?php  foreach ($partie->getJoueurs() as $joueur) : ?>
    			<tr>
    				<td><?php echo $joueur->getPionId();?></td>
    				<td><?php echo $joueur->getCompte(); ?></td>
    				<td>
	    				<p><?php foreach ($joueur->getArgent() as $montant=>$quantite) : //Va chercher les joueurs et les affiche ?>
	    					<?php echo "Montant :" . $montant . " Quantite : " . $quantite;?>
	    				<?php endforeach?></p>
    				</td>
    			</tr>
    		<?php endforeach; ?>
    	</table>
	    		<button type="submit" name="Retour" >Retour au menu principal</button>
	    </form>
    	<br/>
        </form-->
    </div>
    <?php include 'vue/piedpage.php'; ?>

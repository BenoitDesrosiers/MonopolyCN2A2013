<!DOCTYPE html>
<html>
<head>
    <?php include 'vue/headCommun.php'; ?>
</head>

<body>
    <?php include 'vue/enteteCommune.php'; ?>
    
    <div id="main">			
    	<form id="ajout-Form" action="." method="post">
    		<input type="hidden" name="action" value="ajouterPartie"/>
     		<button type="submit" name="Ajout">Créer une nouvelle partie</button>
     		<?php //LISTEJOUEUR 1 vous pouvez ajouter le bouton pour lister les joueurs ici ?>
     	</form>
    	<h1>Liste des parties disponibles</h1>
    	<table border="1">
    		<tr>
    			<td>id </td>
    			<td>nom</td>
    			<td>coordonnateur</td>
    		</tr>
    		<?php //LISTPARTIE 1.4.1 affiche toutes les parties pour ce coordonnateur?>
    		<?php  foreach ($parties as $partie) : ?>
    			
    			<tr>
    				<td><?php echo $partie->getId();?></td>
    				<td><?php echo $partie->getNom(); ?></td>
    				<td><?php echo $partie->getCoordonnateur(); ?></td>
    				
    				<td><?php echo "nom participants.... "; ?></td>			
    			</tr>
    		<?php endforeach; ?>
    	</table>
    	<br/>
        </form-->
    </div>
    <?php include 'vue/piedpage.php'; ?>

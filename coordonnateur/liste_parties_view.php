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
     		<button type="submit" name="Ajout">Démarrer une nouvelle partie</button>
     	</form>
    	<h1>Liste des parties disponibles</h1>
    	<table border="1">
    		<tr>
    			<td>id </td>
    			<td>début</td>
    			<td>participants</td>
    		</tr>
    		<?php  foreach ($parties as $partie) : ?>
    			
    			<tr>
    				<td><?php echo $test->getId();?></td>
    				<td><?php echo $test->getDebut(); ?></td>
    				<td><?php echo "nom participants.... "; ?></td>			
    			</tr>
    		<?php endforeach; ?>
    	</table>
    	<br/>
        </form-->
    </div>
    <?php include 'vue/piedpage.php'; ?>

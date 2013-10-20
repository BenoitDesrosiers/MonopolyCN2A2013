<!DOCTYPE html>
<?php
    /* l'écran d'acceuil d'un usager
     * cet écran lui présente la liste des parties qu'il peut rejoindre.
     * 
     * input:
     *     $usager : l'usager affichant cette page. classe Usager
     *     $coordonnateurs : une liste de coordonnateurs proposant des parties auxquelles l'usager peut se joindre. array d'objet de la classe Coordonnateur
     */


?>

<html>
<head>
    <?php include 'vue/headCommun.php'; ?>
</head>

<body>
    <?php include 'vue/enteteCommune.php'; ?>
    
    <div id="main">			
    	
    	<h1>Liste des parties disponibles</h1>
    	<form id="joindrePartie" action="." method="post">
    	    <input type="hidden" name="action" value="joindrePartie"/>
        	<table border="1">
        		<tr>
        		    <td>coordonnateur</td>
        		    <td>id </td>
        			<td>nom</td>
        			<td>joindre</td>
        		</tr>
        		<?php  foreach ($coordonnateurs as $coordonnateur) : 
        		            $parties = $coordonnateur->getPartiesEnCours();
        		            foreach ($parties as $partie) :?>
                                <tr>
                    			    <td><?php echo $partie->getCoordonnateur(); ?></td>
                    				<td><?php echo $partie->getId();?></td>
                    				<td><?php echo $partie->getNom(); ?></td>
                    				<td><button type="submit" name="joindre" value="<?php echo $partie->getId() ?>">joindre</button></td>
                    		    </tr>
                    		<?php endforeach; //parties ?>
                    		<tr></tr> <!-- une ligne vide pour séparer les coordonnateur -->
        		<?php endforeach; //coordonnateur ?>
        	</table>
    	</form>
    	
    	<br/>
    </div>
    <?php include 'vue/piedpage.php'; ?>

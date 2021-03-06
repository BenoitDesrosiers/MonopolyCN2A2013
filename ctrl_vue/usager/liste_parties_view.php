<!DOCTYPE html>
<?php
    /* l'ecran d'acceuil d'un usager
     * cet ecran lui presente la liste des parties qu'il peut rejoindre.
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
        		            $parties = $coordonnateur->getPartiesEnCours();  //TODO: generer, dans le ctrl,  un array de celle ou l'usager est deja afin de ne pas permettre de joindre un partie ou il est deja. 
        		            foreach ($parties as $partie) :?>
                                <tr>
                    			    <td><?php echo $partie->getCoordonnateur(); ?></td>
                    				<td><?php echo $partie->getId();?></td>
                    				<td><?php echo $partie->getNom(); ?></td>
                    				<td><button type="submit" name="joindre" value="<?php echo $partie->getId() ?>">
                    				              <?php if($partie->joueurPresent($usager)) {echo "re";}?>joindre</button></td>
                    		    </tr>
                    		<?php endforeach; //parties ?>
                    		<tr></tr> <!-- une ligne vide pour separer les coordonnateur -->
        		<?php endforeach; //coordonnateur ?>
        	</table>
    	</form>
    	
    	<br/>
    </div>
    <?php include 'vue/piedpage.php'; ?>

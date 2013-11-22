
<?php 
/*
 * Page permettant au joueur de choisir son pion. 
 * 
 * input: 
 *     $pions : une liste contenant les pions disponibles
 *     
 */
?>
<!DOCTYPE html>
<html>
<head>
    <?php include 'vue/headCommun.php'; ?>
</head>

<body>
    <?php include 'vue/enteteCommune.php'; ?>
    
    <div id="main">	
        <p><?php echo $msg ?></p>		
    	<form id="menu-Form" action="." method="post">
    		<input type="hidden" name="action" value="demandePion"/>
     		<input type="hidden" name="partieId" value="<?php echo $partie->getId()?>"/>
     		<?php foreach ($pions as $pion) : php?>
     		<input type="radio" name="pion" value="<?php echo $pion->getId()?>"><?php echo $pion->getNom()?><br>
     		<?php endforeach;?>
     		
     		<button type="submit" name="choisirPion">Choisir</button>
     	</form>
    	
    </div>
    <?php include 'vue/piedpage.php'; ?>

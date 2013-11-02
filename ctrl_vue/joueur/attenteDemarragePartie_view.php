<!DOCTYPE html>
<html>
<head>
    <?php include 'vue/headCommun.php'; ?>
</head>

<body>
    <?php include 'vue/enteteCommune.php'; ?>
    
    <div id="main">	
        <p>La partie n'est pas encore commencée... </p>		
    	<form id="menu-Form" action="." method="post">
    		<input type="hidden" name="action" value="attenteConnectionPartie"/>
    		<input type="hidden" name="partieId" value="<?php echo $partieId?>"/>
     		<button type="submit" name="reessayer">Ré-essayer</button>
     		<button type="submit" name="quitter">Quitter</button>
     	</form>
    	
    </div>
    <?php include 'vue/piedpage.php'; ?>

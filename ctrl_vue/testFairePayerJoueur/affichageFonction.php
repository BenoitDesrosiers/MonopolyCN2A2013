<!DOCTYPE html>
<html>
<head>
    <?php include 'vue/headCommun.php'; ?>
</head>

<body>
    <?php include 'vue/enteteCommune.php'; ?>
    
    <div id="main">			
    	
    	<h1>essai</h1>
    	<?php
    	echo "le joueur est ".$mike->getCompte()."</br>";
    	foreach ($mike->getArgent() as $montant=>$quantite)
    	{
    		echo $quantite. " billet de ".$montant."</br>";
    	}
    	?>
    	
    	<br/>
        </form-->
    </div>
    <?php include 'vue/piedpage.php'; ?>

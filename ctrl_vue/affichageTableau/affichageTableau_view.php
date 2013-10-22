<!DOCTYPE html>
<html>
<head>
    <?php include 'vue/headCommun.php'; ?>
</head>

<body>
    <?php include 'vue/enteteCommune.php'; ?>
    
    <div id="main">			
    	
    	<h1>Tableau de jeu</h1>
    		<?php  foreach ($tableauDeJeu->getCases() as $case) : ?>
    			<p>
    			<?php echo $case->getId();?>
    			<?php echo $case->getPosition();?>
    			<?php echo $case->getNom();?>
    			
    			</p>
    			
    		<?php endforeach; ?>
    	<br/>

    </div>
    <?php include 'vue/piedpage.php'; ?>

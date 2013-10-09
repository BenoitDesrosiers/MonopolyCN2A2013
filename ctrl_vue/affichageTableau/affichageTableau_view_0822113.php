<!DOCTYPE html>
<html>
<head>
    <?php include 'vue/headCommun.php'; ?>
    		<!--  <link href="../../css/reset.css" rel="stylesheet" type="text/css" />-->
			<link href="../../css/styles.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <?php include 'vue/enteteCommune.php'; ?>
    
    <div id="main">			
    	
    	<h1>Tableau de jeu</h1> 
		<table>	
			<?php for ($i = 0; $i <10; $i++){
				$case[$i] = $tableauDeJeu->getCasesParPosition($i); 
				if($case[$i] == null)
					$i++;
				else{
				?>
					<td class="caseH"><svg viewbox="0 0 75 100" xmlns="http://www.w3.org/2000/svg" version="1.1">
						<rect x="0px" y="70px" width="75px" height="30px" style="fill:<?php $case[$i]->getCouleurHTML();?>;stroke:black;"/>
							<text class="titreP" x="5px" y="15px" transform="rotate(180 38,35)">
								<?php echo $case[$i]->getNom(); ?></text>
							<text class="montant" x="32px" y="55px" transform="rotate(180 38,35)"><?php echo $case[$i]->getPrix();?></text></svg></td>
			<?php }
			}?>
    		<?php  foreach ($tableauDeJeu->getCases() as $case) : ?>
    			<p>
					<?php echo $case->getId();?>
					<?php echo $case->getPosition();?>
					<?php echo $case->getNom();?>
    			</p>
    		<?php endforeach; ?>
    	</table>
    	<br/>
    </div>
    <?php include 'vue/piedpage.php'; ?>

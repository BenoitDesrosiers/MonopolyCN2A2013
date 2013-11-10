<!DOCTYPE html>
<html>
<head>
    <?php include 'vue/headCommun.php'; ?>
	<link href="<?php echo $GLOBALS['app_path'].'css/styleTableauEtienne.css'?>" rel="stylesheet" type="text/css" />
</head>

<body>
    <?php include 'vue/enteteCommune.php'; ?>
    
    <div id="main">			
    	
    	<h1>Tableau de jeu</h1>
    	<table>
			<tr>
				<td>
						<svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="100"
						height="100">
							<rect width="100" height="100"/>
						</svg>
				</td>
				<td>
					<?php for($x=21;$x<=29;$x++){ ?>
						<svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="75"
						height="100" >
							<rect width="75" height="100"/>
							
							<?php 
							foreach ($tableauDeJeu->getCases() as $case) :
								if($x == $case->getPosition()){ 
									if($case->getCouleur()!="service" and $case->getCouleur()!="train"){ 
							?>
										<rect width="75" height="25" y="75"
										style="fill:<?php echo $case->getCouleurHTML() ?>;"/>
										
							<?php
									}
							?>
									<text x="50" y="90" fill="black" transform="rotate(180 50,50)">
									<?php echo $case->getPrix() ?> $</text>
									
									<text class="nom" x="70" y="60" fill="black" transform="rotate(180 70,60)">
									<?php echo $case->getNom() ?></text>
							<?php 
								}
							endforeach;
							?>
						</svg>
					<?php } ?>
				</td>
				<td>
					<svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="100"
					height="100">
						<rect width="100" height="100"/>
					</svg>
				</td>
			</tr>
			<tr>
				<td width="100">
					<?php 
						for($x=19;$x>=11;$x--){
					?>
						<svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="100"
						height="75" style="padding-bottom: 5;">
							<rect width="100" height="75"/>
							
							<?php 
							foreach ($tableauDeJeu->getCases() as $case) :
								if($x == $case->getPosition()){ 
									if($case->getCouleur()!="service" and $case->getCouleur()!="train"){
							?>
										<rect width="25" height="75" x="75"
										style="fill:<?php echo $case->getCouleurHTML() ?>;"/>
							<?php
									}
									
							?>
									<text x="10" y="20" fill="black" transform="rotate(90 10,20)">
									<?php echo $case->getPrix() ?> $</text>
									
									<text class="nom" x="60" y="5" fill="black" transform="rotate(90 60,5)">
									<?php echo $case->getNom() ?></text>
							<?php 
									
								}
							endforeach;
							?>
							
						</svg>
					<?php } ?>
				</td>
				<td width="708" height="708">
				</td>
				<td width="100">
					<?php 
					for($x=31;$x<=39;$x++){
					?>
						<svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="100"
						height="75" style="padding-bottom: 5;">
							<rect width="100" height="75"/>
							<?php 
							foreach ($tableauDeJeu->getCases() as $case) :
								if($x == $case->getPosition()){ 
									if($case->getCouleur()!="service" and $case->getCouleur()!="train"){
							?>
										<rect width="25" height="75"
										style="fill:<?php echo $case->getCouleurHTML() ?>;"/>
							<?php
									}
									
							?>
									<text x="90" y="50" fill="black" transform="rotate(270 90,50)">
									<?php echo $case->getPrix() ?> $</text>
									
									<text class="nom" x="40" y="70" fill="black" transform="rotate(270 40,70)">
									<?php echo $case->getNom() ?></text>
							<?php 
								}
							endforeach;
							?>
							
						</svg>
					<?php } ?>
				</td>
			</tr>
			<tr>
				<td>
						<svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="100"
						height="100">
							<rect width="100" height="100"/>
						</svg>
				</td>
				<td>
					<?php 
					for($x=9;$x>=1;$x--){
					?>
							<svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="75"
							height="100" >
								<rect width="75" height="100"/>
								
								<?php 
								foreach ($tableauDeJeu->getCases() as $case) :
									if($x == $case->getPosition()){ 
										if($case->getCouleur()!="service" and $case->getCouleur()!="train"){
								?>
										<rect width="75" height="25"
										style="fill:<?php echo $case->getCouleurHTML() ?>;"/>
								<?php
										}
								?>
										<text x="25" y="90" fill="black" >
										<?php echo $case->getPrix() ?> $</text>
										
										<text class="nom" x="5" y="40" fill="black">
										<?php echo $case->getNom() ?></text>
								<?php 
									}
								endforeach;
								?>
							</svg>
					<?php } ?>
				</td>
				<td>
						<svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="100"
						height="100">
							<rect width="100" height="100"/>
						</svg>
				</td>
			</tr>
		</table>
    	<br/>
        </form-->
    </div>
    <?php include 'vue/piedpage.php'; ?>

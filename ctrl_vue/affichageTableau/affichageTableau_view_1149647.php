<!DOCTYPE html>
<html>
<head>
    <?php include 'vue/headCommun.php'; ?>
	<link rel="stylesheet" type="text/css" href="<?php echo $GLOBALS['app_path']; ?>css/mainStyle.css" />
</head>

<body>
    <?php include 'vue/enteteCommune.php'; ?>
	
    <div id="main">
    	
    	<h1>Tableau de jeu</h1>
		<table cellspacing="0" border="0">
			<?php $currentPosition = 0;
				$maxTextLength = 12; ?>
			<tr>
				<?php while ($currentPosition != 11) : ?>
					<td 
						<?php if ($currentPosition == 0 || $currentPosition == 10) : ?>
							class = "cornerCase">
							<svg width="100px" height="100px" width="100px" height="100px" xmlns="http://www.w3.org/2000/svg" version="1.1">
								<text x="38px" y="40px" transform="rotate(180 50,50)"> <?php echo $tableauDeJeu->getCaseByPosition($currentPosition)->getNom(); ?>
						<?php else : ?>
							class = "verticalCase">
							<svg width="75px" height="100px" xmlns="http://www.w3.org/2000/svg" version="1.1">
								<?php if ($tableauDeJeu->getCaseByPosition($currentPosition)->getType() == "achetable") : ?>
									<rect x="0" y="70" width="75" height="30" style="fill: <?php echo $tableauDeJeu->getCaseByPosition($currentPosition)->getCouleurHTML(); ?>;stroke:rgb(0,0,0);" />
								<?php endif; ?>
								<text x="38px" y="45px" transform="rotate(180 38,50)"> 
								<?php	$caseName =  $tableauDeJeu->getCaseByPosition($currentPosition)->getNom();
										$lastSpaceIndex = 0;
										$spaceCounter = 0;
										if (strlen($caseName) > $maxTextLength) : 
											while(strpos(substr($caseName, $lastSpaceIndex + 1), ' ') != false && $spaceCounter < 3) :
												$lastSpaceIndex = $lastSpaceIndex + strpos(substr($caseName, $lastSpaceIndex + 1), ' ') + 1;
												$spaceCounter++;
											endwhile;
											if (strlen(substr($caseName, 0, $lastSpaceIndex)) > $maxTextLength) :
												echo substr(substr($caseName, 0, $lastSpaceIndex), 0, strpos(substr($caseName, 0, $lastSpaceIndex), ' ')); ?>
												<tspan x="38px" y="57px"> <?php echo substr(substr($caseName, 0, $lastSpaceIndex), strpos(substr($caseName, 0, $lastSpaceIndex), ' '), $lastSpaceIndex); ?></tspan>
												<tspan x="38px" y="69px"> <?php echo substr($caseName, $lastSpaceIndex + 1); ?></tspan>
									<?php	else :
												echo substr($caseName, 0, $lastSpaceIndex); ?>
												<tspan x="38px" y="57px"> <?php echo substr($caseName, $lastSpaceIndex + 1); ?></tspan>
									<?php	endif;
										else :
											echo $tableauDeJeu->getCaseByPosition($currentPosition)->getNom();
										endif; 
								?>
								</text>
								<?php if ($tableauDeJeu->getCaseByPosition($currentPosition)->getType() == "achetable") : ?>
								<text x="38px" y="90px" transform="rotate(180 38,50)"> <?php echo $tableauDeJeu->getCaseByPosition($currentPosition)->getPrix(); ?> $
								<?php endif; ?>
						<?php endif; ?>
							</text>
						</svg>
					</td>
					<?php $currentPosition++; ?>
				<?php endwhile; ?>
			</tr>
			
			<?php while ($currentPosition != 20) : ?>
				<tr>
					<td class="horizontalCase">	
						<svg width="100px" height="75px" xmlns="http://www.w3.org/2000/svg" version="1.1">
							<?php if ($tableauDeJeu->getCaseByPosition($currentPosition)->getType() == "action") : ?> 
								<text x="38px" y="10px" transform="rotate(90 38,38)"> case action
							<?php else : ?>
								<?php if ($tableauDeJeu->getCaseByPosition($currentPosition)->getType() == "achetable") : ?>
								<rect x="70" y="0" width="30" height="75" style="fill: <?php echo $tableauDeJeu->getCaseByPosition(50 - $currentPosition)->getCouleurHTML(); ?>;stroke:rgb(0,0,0);" />
								<?php endif; ?>
								<text x="38px" y="25px" transform="rotate(90 38,38)">
								<?php	$caseName =  $tableauDeJeu->getCaseByPosition(50 - $currentPosition)->getNom();
										$lastSpaceIndex = 0;
										$spaceCounter = 0;
										if (strlen($caseName) > $maxTextLength) : 
											while(strpos(substr($caseName, $lastSpaceIndex + 1), ' ') != false && $spaceCounter < 3) :
												$lastSpaceIndex = $lastSpaceIndex + strpos(substr($caseName, $lastSpaceIndex + 1), ' ') + 1;
												$spaceCounter++;
											endwhile;
											if (strlen(substr($caseName, 0, $lastSpaceIndex)) > $maxTextLength) :
												echo substr(substr($caseName, 0, $lastSpaceIndex), 0, strpos(substr($caseName, 0, $lastSpaceIndex), ' ')); ?>
												<tspan x="38px" y="37px"> <?php echo substr(substr($caseName, 0, $lastSpaceIndex), strpos(substr($caseName, 0, $lastSpaceIndex), ' '), $lastSpaceIndex); ?></tspan>
												<tspan x="38px" y="49px"> <?php echo substr($caseName, $lastSpaceIndex + 1); ?></tspan>
									<?php	else :
												echo substr($caseName, 0, $lastSpaceIndex); ?>
												<tspan x="38px" y="37px"> <?php echo substr($caseName, $lastSpaceIndex + 1); ?></tspan>
									<?php	endif;
										else :
											echo $tableauDeJeu->getCaseByPosition(50 - $currentPosition)->getNom();
										endif; 
								?>
								</text>
								<text x="38px" y="70px" transform="rotate(90 38,38)"> <?php echo $tableauDeJeu->getCaseByPosition(50 - $currentPosition)->getPrix(); ?> $
							<?php endif; ?>					
							</text>
						</svg>
					</td>
					<?php if ($currentPosition == 11) : ?>
						<td colspan="9" rowspan="9" class="centerCase"> 
							<p> Monopoly </p>
							<form id="menu-Form" action="index.php" method="post">
								<button type="submit" name="JouerCoup">Jouer un coup</button>
							</form>
						</td>
					<?php endif; ?>
					<td class="horizontalCase">	
						<svg width="100px" height="75px" xmlns="http://www.w3.org/2000/svg" version="1.1">
							<?php if ($tableauDeJeu->getCaseByPosition($currentPosition)->getType() == "action") : ?> 
								<text x="38px" y="10px" transform="rotate(270 38,38)"> case action
							<?php else : ?>
								<rect x="0" y="0" width="30" height="75" style="fill: <?php echo $tableauDeJeu->getCaseByPosition($currentPosition)->getCouleurHTML(); ?>;stroke:rgb(0,0,0);" />
								<text x="38px" y="45px" transform="rotate(270 38,38)">
								<?php	$caseName =  $tableauDeJeu->getCaseByPosition($currentPosition)->getNom();
										$lastSpaceIndex = 0;
										$spaceCounter = 0;
										if (strlen($caseName) > $maxTextLength) : 
											while(strpos(substr($caseName, $lastSpaceIndex + 1), ' ') != false && $spaceCounter < 3) :
												$lastSpaceIndex = $lastSpaceIndex + strpos(substr($caseName, $lastSpaceIndex + 1), ' ') + 1;
												$spaceCounter++;
											endwhile;
											if (strlen(substr($caseName, 0, $lastSpaceIndex)) > $maxTextLength) :
												echo substr(substr($caseName, 0, $lastSpaceIndex), 0, strpos(substr($caseName, 0, $lastSpaceIndex), ' ')); ?>
												<tspan x="38px" y="57px"> <?php echo substr(substr($caseName, 0, $lastSpaceIndex), strpos(substr($caseName, 0, $lastSpaceIndex), ' '), $lastSpaceIndex); ?></tspan>
												<tspan x="38px" y="69px"> <?php echo substr($caseName, $lastSpaceIndex + 1); ?></tspan>
									<?php	else :
												echo substr($caseName, 0, $lastSpaceIndex); ?>
												<tspan x="38px" y="57px"> <?php echo substr($caseName, $lastSpaceIndex + 1); ?></tspan>
									<?php	endif;
										else :
											echo $tableauDeJeu->getCaseByPosition($currentPosition)->getNom();
										endif; 
								?>
								</text>
								<text x="38px" y="90px" transform="rotate(270 38,38)"> <?php echo $tableauDeJeu->getCaseByPosition($currentPosition)->getPrix(); ?> $
							<?php endif; ?>					
							</text>
						</svg>
					</td>
				</tr>
				<?php $currentPosition++; ?>
			<?php endwhile; ?>
			
			<tr>
				<?php while ($currentPosition <= 30) : ?>
					<td 
						<?php if ($currentPosition == 20 || $currentPosition == 30) : ?>
							class = "cornerCase">
							<svg width="100px" height="100px" xmlns="http://www.w3.org/2000/svg" version="1.1">
								<text x="38px" y="50px"> case action
						<?php elseif ($tableauDeJeu->getCaseByPosition($currentPosition)->getType() == "action") : ?>
							class = "verticalCase">
							<svg width="75px" height="100px" xmlns="http://www.w3.org/2000/svg" version="1.1">
								<text x="38px" y="10px"> case action
						<?php else : ?>
							class = "verticalCase">
							<svg width="75px" height="100px" xmlns="http://www.w3.org/2000/svg" version="1.1">
								<rect x="0" y="0" width="75" height="30" style="fill: <?php echo $tableauDeJeu->getCaseByPosition(50 - $currentPosition)->getCouleurHTML(); ?>;stroke:rgb(0,0,0);" />
								<text x="38px" y="45px"> 
								<?php	$caseName =  $tableauDeJeu->getCaseByPosition(50 - $currentPosition)->getNom();
										$lastSpaceIndex = 0;
										$spaceCounter = 0;
										if (strlen($caseName) > $maxTextLength) : 
											while(strpos(substr($caseName, $lastSpaceIndex + 1), ' ') != false && $spaceCounter < 3) :
												$lastSpaceIndex = $lastSpaceIndex + strpos(substr($caseName, $lastSpaceIndex + 1), ' ') + 1;
												$spaceCounter++;
											endwhile;
											if (strlen(substr($caseName, 0, $lastSpaceIndex)) > $maxTextLength) :
												echo substr(substr($caseName, 0, $lastSpaceIndex), 0, strpos(substr($caseName, 0, $lastSpaceIndex), ' ')); ?>
												<tspan x="38px" y="60px"> <?php echo substr(substr($caseName, 0, $lastSpaceIndex), strpos(substr($caseName, 0, $lastSpaceIndex), ' '), $lastSpaceIndex); ?></tspan>
												<tspan x="38px" y="75px"> <?php echo substr($caseName, $lastSpaceIndex + 1); ?></tspan>
									<?php	else :
												echo substr($caseName, 0, $lastSpaceIndex); ?>
												<tspan x="38px" y="60px"> <?php echo substr($caseName, $lastSpaceIndex + 1); ?></tspan>
									<?php	endif;
										else :
											echo $tableauDeJeu->getCaseByPosition(50 - $currentPosition)->getNom();
										endif; 
								?>
								</text>
								<text x="38px" y="95px"> <?php echo $tableauDeJeu->getCaseByPosition(50 - $currentPosition)->getPrix(); ?> $
						<?php endif; ?>
							</text>
						</svg>
					</td>
					<?php $currentPosition++; ?>
				<?php endwhile; ?>
			</tr>
		</table>
		<br/>
    </div>
    <?php include 'vue/piedpage.php'; ?>

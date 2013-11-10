<!DOCTYPE html>
<html>
<head>
    <?php include 'vue/headCommun.php'; ?>
</head>

<body>
    <?php include 'vue/enteteCommune.php'; ?>
    
    <div id="main">			
    	
    	<h1>Tableau de jeu</h1>
    	
    		<?php 
    		//boucle qui passe les 40 cases du jeu
    		for($x = 1; $x<40;$x++)
    		{
    			$case = $tableauDeJeu->getCaseParPosition($x);
    			if( $case != null)
    			{
    				$array[$x-1]=$case;
    			}
    			else
    				$array[$x-1]=null;
    		}
    		?>
    		
    			<table class="table" border="1">
				<tr class="tr">
				<td class="coin"></td>
   			 <?php
    
    //Boucle de creation de la ligne du haut
    for($x=1; $x<10;$x++)
		{
			if($array[$x-1]!=null)
			{
				$c = $array[$x-1]->getPosition();
				if ($c==$x)
				{
					?>
						<td class="haut">
						<svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 75 100" >
						<?php
						if ($array[$x-1]->getCouleurHTML() != "#000000")
						{
						?>
							<rect x="0" y="75" width="75" height="30" style="fill:
						<?php
							echo $array[$x-1]->getCouleurHTML();
						}
						?>
						"/>
						<text x="0" y="0">
						<tspan x="38" y="5" >
						<?php
							//affichage du texte sur plusieurs ligne en fonction de la longueur du texte
							if(strpos($array[$x-1]->getNom(), " ") != false)
								echo strchr($array[$x-1]->getNom()," ",true);
							else
								echo $array[$x-1]->getNom();
						?>
						</tspan>

						<?php
							$ligne2 = strchr($array[$x-1]->getNom()," ");
							$ligne2F =  substr($ligne2, 1);
							if (strlen($ligne2F)>17)
								{
						?>
									<tspan x="38" y="20">
									<?php
										echo strchr($ligne2F," ", true);
									?>
									</tspan>										
									<tspan x="38" y="35">
									<?php
										echo strchr($ligne2F," ");
									?>
									</tspan>										
									<?php
								}
							else
								{
									?>
										<tspan x="38" y="20">
									<?php
										echo strchr($ligne2," ");
									?>
										</tspan>
									<?php 
								}
									?>
    							<tspan x="38" y="60">
    							<?php
									echo $array[$x-1]->getPrix();
									echo " $";			
								?>
    							</tspan>
							</text>
							</svg>
							</td>
							<?php
				}

			}
    		else
    			{
    				?>
    				<td class="haut"></td>
    				<?php
    			}
		}		
//Boucle de creation des ligne 2 a 9
	$caseG = 39;
	$flag=false;
	$flag2=false;
	$caseD = 11;
    for($x=0; $x<9;$x++)
		{
			$caseG = $caseG-$x;
			$caseD = $caseD+$x;
			?>
				<tr>
			<?php
			//creation de la case de gauche (par ligne)
		for($y=$caseG;$y>30;$y--)
				{
				if($array[$y-1]!=null && $flag == false)
					{
					$c = $array[$y-1]->getPosition();
						if ($c==$caseG)
							{
								$flag=true;
								?>
								<td class="gauche">
								<svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 100 75" >
								<?php
								if ($array[$y-1]->getCouleurHTML() != "#000000")
								{
									?>
									<rect x="69" y="0" width="30" height="75" style="fill:
									<?php
									echo $array[$y-1]->getCouleurHTML();
								}
								?>
								"/>
								<text x="0" y="-40" transform="rotate(90 0,0)">
								<tspan x="38" y="-65" >
								<?php
								//affichage du texte sur plusieurs ligne en fonction de la longueur du texte
								if(strpos($array[$y-1]->getNom(), " ") != false)
									echo strchr($array[$y-1]->getNom()," ",true);
								else
									echo $array[$y-1]->getNom();
								?>
								</tspan>
								<?php
								$ligne2 = strchr($array[$y-1]->getNom()," ");
								$ligne2F =  substr($ligne2, 1);
								if (strlen($ligne2F)>17)
									{
										?>
										<tspan x="38" y="-50">
										<?php
											echo strchr($ligne2F," ", true);
										?>
										</tspan>										
										<?php
										?>
										<tspan x="38" y="-35">
										<?php
											echo strchr($ligne2F," ");
										?>
										</tspan>										
										<?php
									}
								else
									{
										?>
										<tspan x="38" y="-50">
										<?php
										echo strchr($ligne2," ");
										?>
										</tspan>
										<?php 
									}
										?>
    							<tspan x="38" y="-15">
    							<?php
								echo $array[$y-1]->getPrix();
								echo " $";			
								?>
    							</tspan>
								</text>
								</svg>
								</td>
						<?php
						}
					}
				else
					{
						if($flag == false)
							{
								?>
								<td class="gauche"><p></p></td>
								<?php
								$flag=true;
							}
					
					}
					
			}
			?>
				<td class="vide" colspan="9" rowspan="1"></td>
			<?php
			
			//creation de la case de droite (par ligne)
			for($z=$caseD;$z<20;$z++)
			{
					if($array[$z-1]!=null && $flag2 == false)
						{
							$c = $array[$z-1]->getPosition();
							if ($c==$caseD)
								{
									?>
									<td class="droite">
									<svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 100 75" >
									
									<?php
									if ($array[$z-1]->getCouleurHTML() != "#000000")
									{
										?>
										<rect x="1" y="0" width="30" height="75" style="fill:
										<?php 
										echo $array[$z-1]->getCouleurHTML();
									}
									?>
									"/>
									<text x="0" y="0" transform="rotate(-90 0,0)" >
									<tspan x="-38" y="35" >
									<?php
									//affichage du texte sur plusieurs ligne en fonction de la longueur du texte
									if(strpos($array[$z-1]->getNom(), " ") != false)
										echo strchr($array[$z-1]->getNom()," ",true);
									else
										echo $array[$z-1]->getNom();
									?>
									</tspan>
									<?php
									$ligne2 = strchr($array[$z-1]->getNom()," ");
									$ligne2F =  substr($ligne2, 1);
									if (strlen($ligne2F)>17)
										{
											?>
											<tspan x="-38" y="50">
											<?php
											echo strchr($ligne2F," ", true);
											?>
											</tspan>										
											<?php
											?>
											<tspan x="-38" y="65">
											<?php
											echo strchr($ligne2F," ");
											?>
											</tspan>										
											<?php
										}
									else
										{
											?>
											<tspan x="-38" y="50">
											<?php
											echo strchr($ligne2," ");
											?>
											</tspan>
											<?php 
										}
									?>
    								<tspan x="-38" y="85">
    								<?php
									echo $array[$z-1]->getPrix();
									echo " $";			
									?>
    								</tspan>
								</text>
								</svg>
								</td>
								<?php
								$flag2=true;
							}
						}
					else
						{
							if($flag2 == false)
								{
									?>
									<td class="droite"><p></p></td>
									<?php
									$flag2=true;
								}
					
						}
				}
				$flag=false;
				$flag2=false;
				$caseG = 39;
				$caseD = 11;
				?>
				</tr>
				<?php
				
	}
	


	?>


	<tr class="tr">
	<td class="coin"></td>
    <?php
    //Boucle de creation de la ligne du bas
    for($x=29; $x>20;$x--)
		{
			if($array[$x-1]!=null)
				{
					$c = $array[$x-1]->getPosition();
					if ($c==$x)
						{
							?>
							<td class="bas"><svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 75 100" >
							
							<?php
							if($array[$x-1]->getCouleurHTML() != "#000000")
							{
								?>
								<rect x="0" y="0" width="75" height="30" style="fill:
								<?php
								echo $array[$x-1]->getCouleurHTML();
								
							}
							?>
							"/>
							<text x="0" y="0">
							<tspan x="38" y="35" >
							<?php
							//affichage du texte sur plusieurs ligne en fonction de la longueur du texte
							if(strpos($array[$x-1]->getNom(), " ") != false)
								echo strchr($array[$x-1]->getNom()," ",true);
							else
								echo $array[$x-1]->getNom();
							?>
							</tspan>
							<?php
							$ligne2 = strchr($array[$x-1]->getNom()," ");
							$ligne2F =  substr($ligne2, 1);
							if (strlen($ligne2F)>17)
								{
									?>
									<tspan x="38" y="50">
									<?php
									echo strchr($ligne2F," ", true);
									?>
									</tspan>										
									<?php
									?>
									<tspan x="38" y="65">
									<?php
									echo strchr($ligne2F," ");
									?>
									</tspan>										
									<?php
								}
							else
								{
									?>
									<tspan x="38" y="50">
									<?php
									echo strchr($ligne2," ");
									?>
									</tspan>
									<?php 
								}
							?>
    						<tspan x="38" y="85">
    						<?php
							echo $array[$x-1]->getPrix();
							echo " $";			
							?>
    						</tspan>
							</text>
							</svg>
							</td>
							<?php
						}

				}
    		else
    			{
    				?>
    				<td class="bas"></td>
    				<?php
    			}
		}		




	?>
	<td class="coin"></td>
	</tr>
    </table>
    <br/>
    </form-->
    </div>
    <?php include 'vue/piedpage.php'; ?>

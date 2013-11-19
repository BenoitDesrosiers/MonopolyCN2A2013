
<table id="plateau" cellspacing="0" border="0">
<tr>
<?php $i =0;
while($i != 11) :
$case = $tableauDeJeu->getCaseParPosition($i);
$LongueurMax = 12;
	    			 	if($i == 0 || $i == 10) :?>
	    			 		 <td class="caseCoin">
	    			 		 	<svg width="100px" height="100px" xmlns="http://www.w3.org/2000/svg" version="1.1">
									<text class="titreP" x="45px" y="40px" transform="rotate(180 50,50)">
										<?php echo $case->getNom();?></text>
								</svg>
	    			 		 </td>
	    				<?php elseif ($case == null) :?>
		    				<td class="caseH">
		    					<svg width="75px" height="100px" xmlns="http://www.w3.org/2000/svg" version="1.1">
									<text class="titreP" x="38px" y="15px" transform="rotate(180 38,35)">
										Case action</text>
								</svg>
							</td> 
	    				
	    				<?php else : 
	    					if($case->getCouleur() == "service" || $case->getCouleur() =="train") :?>
	    						<td class="caseH">
			    					<svg width="75px" height="100px" xmlns="http://www.w3.org/2000/svg" version="1.1">
										<text class="titreP" x="38px" y="5px" transform="rotate(180 38,35)">
											<?php $nomCase = $case->getNom();
											$dernierEspace =0;
											$compteurEsp =0; 
											if(strlen($nomCase)> $LongueurMax):
												while(strpos(substr($nomCase, $dernierEspace +1), ' ') != false && $compteurEsp< 3) :
													$dernierEspace= $dernierEspace + strpos(substr($nomCase, $dernierEspace +1), ' ') + 1;
													$compteurEsp++;
												endwhile;
												if(strlen(substr($nomCase, 0, $dernierEspace)) > $LongueurMax) :
													echo substr(substr($nomCase, 0, $dernierEspace), 0, strpos(substr($nomCase, 0, $dernierEspace), ' '));?>
													<tspan class="titreP" x="38px" y="15px"> <?php echo substr(substr($nomCase, 0, $dernierEspace), strpos(substr($nomCase, 0, $dernierEspace), ' '), $dernierEspace);?></tspan>
													<tspan class="titreP" x="38px" y="25px"><?php echo substr($nomCase, $dernierEspace + 1);?></tspan>
												<?php else :
													echo substr($nomCase, 0, $dernierEspace);?>
													<tspan class="titreP" x="38px" y="15px"><?php echo substr($nomCase, $dernierEspace + 1);?></tspan>
												
												<?php endif;
												 else :
												 	 echo $case->getNom();
												 endif;?></text>
										<text class="montant" x="38px" y="55px" transform="rotate(180 38,35)"><?php echo $case->getPrix();?> $</text>
									</svg>
								</td>
							<?php else :?>
			    				<td class="caseH">
			    					<svg width="75px" height="100px" xmlns="http://www.w3.org/2000/svg" version="1.1">
										<rect x="0px" y="70px" width="75px" height="30px" style="fill:<?php echo $case->getCouleurHTML();?>;"/>
										<text class="titreP" x="38px" y="5px" transform="rotate(180 38,35)">
											<?php $nomCase = $case->getNom();
											$dernierEspace =0;
											$compteurEsp =0; 
											if(strlen($nomCase)> $LongueurMax):
												while(strpos(substr($nomCase, $dernierEspace +1), ' ') != false && $compteurEsp< 3) :
													$dernierEspace= $dernierEspace + strpos(substr($nomCase, $dernierEspace +1), ' ') + 1;
													$compteurEsp++;
												endwhile;
												if(strlen(substr($nomCase, 0, $dernierEspace)) > $LongueurMax) :
													echo substr(substr($nomCase, 0, $dernierEspace), 0, strpos(substr($nomCase, 0, $dernierEspace), ' '));?>
													<tspan class="titreP" x="38px" y="15px"> <?php echo substr(substr($nomCase, 0, $dernierEspace), strpos(substr($nomCase, 0, $dernierEspace), ' '), $dernierEspace);?></tspan>
													<tspan class="titreP" x="38px" y="25px"><?php echo substr($nomCase, $dernierEspace + 1);?></tspan>
												<?php else :
													echo substr($nomCase, 0, $dernierEspace);?>
													<tspan class="titreP" x="38px" y="15px"><?php echo substr($nomCase, $dernierEspace + 1);?></tspan>
												
													<?php endif;
												 else :?>
												 	<?php echo $case->getNom();
												 endif;?></text>
										<text class="montant" x="38px" y="55px" transform="rotate(180 38,35)"><?php echo $case->getPrix();?> $</text>
									</svg>
								</td>
							<?php endif;?>
						<?php endif;?>
						<?php $i++;?>
	    		<?php endwhile;?>
	    		</tr>
	    		<?php while($i != 20) :?>
	    			<tr>
	    			<?php $case = $tableauDeJeu->getCaseParPosition(50-$i);
	    			if ($case == null) :?>
		    				<td class="caseCote">
								<svg width="100px" height="75px" xmlns="http://www.w3.org/2000/svg" version="1.1">
									<text class="titreP" x="38px" y="5px" transform="rotate(90 38,35)">
										Case action</text>
								</svg>
							</td> 
	    				<?php else :
	    					if($case->getCouleur() == "service" || $case->getCouleur() =="train") :?> 
	    					<td class="caseCote">
		    					<svg width="100px" height="75px" xmlns="http://www.w3.org/2000/svg" version="1.1">
									<text class="titreP" x="38px" y="5px" transform="rotate(90 38,35)">
										<?php $nomCase = $case->getNom();
											$dernierEspace =0;
											$compteurEsp =0; 
											if(strlen($nomCase)> $LongueurMax):
												while(strpos(substr($nomCase, $dernierEspace +1), ' ') != false && $compteurEsp< 3) :
													$dernierEspace= $dernierEspace + strpos(substr($nomCase, $dernierEspace +1), ' ') + 1;
													$compteurEsp++;
												endwhile;
												if(strlen(substr($nomCase, 0, $dernierEspace)) > $LongueurMax) :
													echo substr(substr($nomCase, 0, $dernierEspace), 0, strpos(substr($nomCase, 0, $dernierEspace), ' '));?>
													<tspan class="titreP" x="38px" y="15px"> <?php echo substr(substr($nomCase, 0, $dernierEspace), strpos(substr($nomCase, 0, $dernierEspace), ' '), $dernierEspace);?></tspan>
													<tspan class="titreP" x="38px" y="25px"><?php echo substr($nomCase, $dernierEspace + 1);?></tspan>
												<?php else :
													echo substr($nomCase, 0, $dernierEspace);?>
													<tspan class="titreP" x="38px" y="15px"><?php echo substr($nomCase, $dernierEspace + 1);?></tspan>
												
												<?php endif;
												 else :?>
												 <?php echo $case->getNom();
												 endif;?></text>
									<text class="montant" x="38px" y="55px" transform="rotate(90 38,35)"><?php echo $case->getPrix();?> $</text>
								</svg>
							</td>
							<?php else: ?>
		    				<td class="caseCote">
		    					<svg width="100px" height="75px" xmlns="http://www.w3.org/2000/svg" version="1.1">
									<rect x="70px" y="0px" width="30px" height="75px" style="fill:<?php echo $case->getCouleurHTML();?>;"/>
									<text class="titreP" x="38px" y="5px" transform="rotate(90 38,35)">
										<?php $nomCase = $case->getNom();
											$dernierEspace =0;
											$compteurEsp =0; 
											if(strlen($nomCase)> $LongueurMax):
												while(strpos(substr($nomCase, $dernierEspace +1), ' ') != false && $compteurEsp< 3) :
													$dernierEspace= $dernierEspace + strpos(substr($nomCase, $dernierEspace +1), ' ') + 1;
													$compteurEsp++;
												endwhile;
												if(strlen(substr($nomCase, 0, $dernierEspace)) > $LongueurMax) :
													echo substr(substr($nomCase, 0, $dernierEspace), 0, strpos(substr($nomCase, 0, $dernierEspace), ' '));?>
													<tspan class="titreP" x="38px" y="15px"> <?php echo substr(substr($nomCase, 0, $dernierEspace), strpos(substr($nomCase, 0, $dernierEspace), ' '), $dernierEspace);?></tspan>
													<tspan class="titreP" x="38px" y="25px"><?php echo substr($nomCase, $dernierEspace + 1);?></tspan>
												<?php else :
													echo substr($nomCase, 0, $dernierEspace);?>
													<tspan class="titreP" x="38px" y="15px"><?php echo substr($nomCase, $dernierEspace + 1);?></tspan>
												
												<?php endif;
												else :?>
												 <?php echo $case->getNom();
												 endif;?></text>
									<text class="montant" x="38px" y="55px" transform="rotate(90 38,35)"><?php echo $case->getPrix();?> $</text>
								</svg>
							</td>
							<?php endif;?>
						<?php endif;?>
						<?php if($i == 11):?>
							<td id="centre"colspan="9" rowspan="9">
								<svg x="0px" y="0px" width="700px" height="700px" xmlns="http://www.w3.org/2000/svg" version="1.1">
  									<rect x="250" y="150" width="100" height="150" stroke="black" stroke-width="2" stroke-dasharray="3" fill="RGB(203,233,225)" transform="rotate(220 200,200)"/>
  									<text x="130" y="185" width="100" height="150" transform="rotate(130 150,150)">CHANCE</text>
  									<rect x="-50" y="0" rx="20" ry="20" width="120" height="420" stroke="white" stroke-width="2" fill="red" transform="rotate(220 200,200)" />
  									<rect x="-40" y="10" rx="20" ry="20" width="100" height="400" stroke="white" stroke-width="2" fill="red" transform="rotate(220 200,200)" />
  									<text x="160" y="385" width="100" height="150" style="fill:white; stroke:black; font-size:52px;"transform="rotate(310 150,150)">MONOPOLY</text>
  									<rect x="-350" y="75" width="100" height="150" stroke="black" stroke-width="2" stroke-dasharray="3" fill="RGB(203,233,225)" transform="rotate(220 200,200)"/>
  									<text x="95" y="725" width="100" height="150" transform="rotate(310 150,150)">Caisse Commune </text>
								</svg> 
							</td>
						<?php endif;?>
						<?php $case = $tableauDeJeu->getCaseParPosition($i);
	    		
	    					if ($case == null) :?>
			    				<td class="caseCote">
									<svg width="100px" height="75px" xmlns="http://www.w3.org/2000/svg" version="1.1">
									<text class="titreP" x="38px" y="5px" transform="rotate(270 38,35)">
										Case action</text>
								</svg>
								</td> 
	    					<?php else : ?>
	    						<?php if($case->getCouleur() == "service" || $case->getCouleur() == "train") :?>
		    						<td class="caseCote">
				    					<svg width="100px" height="75px" xmlns="http://www.w3.org/2000/svg" version="1.1">
											<text class="titreP" x="38px" y="30px" transform="rotate(270 38,35)">
												<?php $nomCase = $case->getNom();
											$dernierEspace =0;
											$compteurEsp =0; 
											if(strlen($nomCase)> $LongueurMax):
												while(strpos(substr($nomCase, $dernierEspace +1), ' ') != false && $compteurEsp< 3) :
													$dernierEspace= $dernierEspace + strpos(substr($nomCase, $dernierEspace +1), ' ') + 1;
													$compteurEsp++;
												endwhile;
												if(strlen(substr($nomCase, 0, $dernierEspace)) > $LongueurMax) :
													echo substr(substr($nomCase, 0, $dernierEspace), 0, strpos(substr($nomCase, 0, $dernierEspace), ' '));?>
													<tspan class="titreP" x="38px" y="40px"> <?php echo substr(substr($nomCase, 0, $dernierEspace), strpos(substr($nomCase, 0, $dernierEspace), ' '), $dernierEspace);?></tspan>
													<tspan class="titreP" x="38px" y="50px"><?php echo substr($nomCase, $dernierEspace + 1);?></tspan>
												<?php else :
													echo substr($nomCase, 0, $dernierEspace);?>
													<tspan class="titreP" x="38px" y="40px"><?php echo substr($nomCase, $dernierEspace + 1);?></tspan>
												
												<?php endif;
												 else :?>
												 <?php echo $case->getNom();
												 endif;?></text>
											<text class="montant" x="38px" y="80px" transform="rotate(270 38,35)"><?php echo $case->getPrix();?> $</text>
										</svg>
									</td>
								<?php else :?>
				    				<td class="caseCote">
				    					<svg width="100px" height="75px" xmlns="http://www.w3.org/2000/svg" version="1.1">
											<rect x="0px" y="0px" width="30px" height="75px" style="fill:<?php echo $case->getCouleurHTML();?>;"/>
											<text class="titreP" x="38px" y="30px" transform="rotate(270 38,35)">
												<?php $nomCase = $case->getNom();
											$dernierEspace =0;
											$compteurEsp =0; 
											if(strlen($nomCase)> $LongueurMax):
												while(strpos(substr($nomCase, $dernierEspace +1), ' ') != false && $compteurEsp< 3) :
													$dernierEspace= $dernierEspace + strpos(substr($nomCase, $dernierEspace +1), ' ') + 1;
													$compteurEsp++;
												endwhile;
												if(strlen(substr($nomCase, 0, $dernierEspace)) > $LongueurMax) :
													echo substr(substr($nomCase, 0, $dernierEspace), 0, strpos(substr($nomCase, 0, $dernierEspace), ' '));?>
													<tspan class="titreP" x="38px" y="40px"> <?php echo substr(substr($nomCase, 0, $dernierEspace), strpos(substr($nomCase, 0, $dernierEspace), ' '), $dernierEspace);?></tspan>
													<tspan class="titreP" x="38px" y="50px"><?php echo substr($nomCase, $dernierEspace + 1);?></tspan>
												<?php else :
													echo substr($nomCase, 0, $dernierEspace);?>
													<tspan class="titreP" x="38px" y="40px"><?php echo substr($nomCase, $dernierEspace + 1);?></tspan>
												
												<?php endif;
												 else :?>
												 <?php echo $case->getNom();
												 endif;?></text>
											<text class="montant" x="38px" y="80px" transform="rotate(270 38,35)"><?php echo $case->getPrix();?> $</text>
										</svg>
									</td>
								<?php endif;?>
							<?php endif;?>
						<?php $i++;?>
						</tr>
	    			<?php endwhile;?>
	    			<?php while($i <= 30) :
	    		 		$case = $tableauDeJeu->getCaseParPosition(20+(30-$i)); 
	    				if ($i == 20 || $i == 30) :?>
	    			   		<td class="caseCoin">
	    			  	 		<svg width="100px" height="100px" xmlns="http://www.w3.org/2000/svg" version="1.1">
									<text class="titreP" x="35px" y="40px" >
										<?php echo $case->getNom();?></text>
								</svg>
	    			    	</td>
	    				<?php elseif($case == null) :?>
		    				<td class="caseH">
								<svg width="75px" height="100px" xmlns="http://www.w3.org/2000/svg" version="1.1">
									<text class="titreP" x="38px" y="40px" >
										Case action</text>
								</svg>
							</td> 
	    			
	    				<?php else : 
	    					if($case->getCouleur() == "service" || $case->getCouleur() =="train") :?>
		    					<td class="caseH">
			    					<svg width="75px" height="100px" xmlns="http://www.w3.org/2000/svg" version="1.1">
										<text class="titreP" x="38px" y="30px">
											<?php $nomCase = $case->getNom();
											$dernierEspace =0;
											$compteurEsp =0; 
											if(strlen($nomCase)> $LongueurMax):
												while(strpos(substr($nomCase, $dernierEspace +1), ' ') != false && $compteurEsp< 3) :
													$dernierEspace= $dernierEspace + strpos(substr($nomCase, $dernierEspace +1), ' ') + 1;
													$compteurEsp++;
												endwhile;
												if(strlen(substr($nomCase, 0, $dernierEspace)) > $LongueurMax) :
													echo substr(substr($nomCase, 0, $dernierEspace), 0, strpos(substr($nomCase, 0, $dernierEspace), ' '));?>
													<tspan class="titreP" x="38px" y="40px"> <?php echo substr(substr($nomCase, 0, $dernierEspace), strpos(substr($nomCase, 0, $dernierEspace), ' '), $dernierEspace);?></tspan>
													<tspan class="titreP" x="38px" y="50px"><?php echo substr($nomCase, $dernierEspace + 1);?></tspan>
												<?php else :
													echo substr($nomCase, 0, $dernierEspace);?>
													<tspan class="titreP" x="38px" y="40px"><?php echo substr($nomCase, $dernierEspace + 1);?></tspan>
												
												<?php endif;
												 else :?>
												 <?php echo $case->getNom();
												 endif;?></text>
										<text class="montant" x="38px" y="80px"><?php echo $case->getPrix();?> $</text>
									</svg>
								</td>
	    				<?php else :?>
		    				<td class="caseH">
		    					<svg width="75px" height="100px" xmlns="http://www.w3.org/2000/svg" version="1.1">
									<rect x="0px" y="0px" width="75px" height="30px" style="fill:<?php echo $case->getCouleurHTML();?>;"/>
									<text class="titreP" x="38px" y="30px">
										<?php $nomCase = $case->getNom();
											$dernierEspace =0;
											$compteurEsp =0; 
											if(strlen($nomCase)> $LongueurMax):
												while(strpos(substr($nomCase, $dernierEspace +1), ' ') != false && $compteurEsp< 3) :
													$dernierEspace= $dernierEspace + strpos(substr($nomCase, $dernierEspace +1), ' ') + 1;
													$compteurEsp++;
												endwhile;
												if(strlen(substr($nomCase, 0, $dernierEspace)) > $LongueurMax) :
													echo substr(substr($nomCase, 0, $dernierEspace), 0, strpos(substr($nomCase, 0, $dernierEspace), ' '));?>
													<tspan class="titreP" x="38px" y="40px"> <?php echo substr(substr($nomCase, 0, $dernierEspace), strpos(substr($nomCase, 0, $dernierEspace), ' '), $dernierEspace);?></tspan>
													<tspan class="titreP" x="38px" y="50px"><?php echo substr($nomCase, $dernierEspace + 1);?></tspan>
												<?php else :
													echo substr($nomCase, 0, $dernierEspace);?>
													<tspan class="titreP" x="38px" y="40px"><?php echo substr($nomCase, $dernierEspace + 1);?></tspan>
												
												<?php endif;
												else :?>
												 <?php echo $case->getNom();
												 endif;?></text>
									<text class="montant" x="38px" y="80px"><?php echo $case->getPrix();?> $</text>
								</svg>
							</td>
						<?php endif;?>
						<?php endif;?>
						<?php $i++;?>
	    		<?php endwhile;?>
	    		</table>
<!DOCTYPE html>
<html>
<head>
    <?php include 'vue/headCommun.php'; ?>
</head>

<body>
    <?php include 'vue/enteteCommune.php'; ?>
    
    <div id="main">			
    	
    	<h1>Tableau de jeu</h1>    	
    	<table>
    		<tr>
	    		<?php for ($i = 0; $i < 11; $i++){
					foreach ($tableauDeJeu->getCases() as $case) : 
		    			if($case->getPosition() == $i){?>
		    				<td>
								<svg xmlns="http://www.w3.org/2000/svg"	version="1.1" width="60" height="60">
									<?php if ($case->getType() != "action") { 	
										if ($case->getCouleur() != "train" && $case->getCouleur() != "service") { ?>
											<rect	width="60"	height="10" y="50" style="fill:<?php echo $case->getCouleurHTML();?>; stroke-width:1; stroke:black"/>
											<rect	width="60"	height="50" style="fill:white;	stroke-width:1;	stroke:black"/>
										<?php } else{ ?>
											<rect	width="60"	height="60" style="fill:white;	stroke-width:1;	stroke:black"/>
										<?php } ?>
										<text	x="5"	y="10" fill="black" font-family="Verdana" font-size="8px">
											<?php echo $case->getNom();?>
										</text>
										<text	x="5"	y="20" fill="black" font-family="Verdana" font-size="8px">
											Prix <?php echo $case->getPrix();?>
										</text>
									<?php } else{ ?>
										<rect	width="60"	height="60" style="fill:white;	stroke-width:1;	stroke:black"/>
										<text	x="5"	y="10" fill="black" font-family="Verdana" font-size="8px">
											<?php echo $case->getNom();?>
										</text>
									<?php } ?>
								</svg>
							</td>
						<?php  break;
						}
	    			endforeach;
	    		}?>
    		</tr>
				<?php for ($i = 39; $i >= 31; $i--){
					foreach ($tableauDeJeu->getCases() as $case) : 
		    			if($case->getPosition() == $i){?>
		    				<tr>
								<td>
									<svg xmlns="http://www.w3.org/2000/svg"	version="1.1" width="60" height="60">
										<?php if ($case->getType() != "action") { 	
											if ($case->getCouleur() != "train" && $case->getCouleur() != "service") { ?>
												<rect	width="10"	height="60" x="50" style="fill:<?php echo $case->getCouleurHTML();?>; stroke-width:1; stroke:black"/>
												<rect	width="50"	height="60" style="fill:white;	stroke-width:1;	stroke:black"/>
											<?php } else{ ?>
												<rect	width="60"	height="60" style="fill:white;	stroke-width:1;	stroke:black"/>
											<?php } ?>
											<text	x="5"	y="30" fill="black" font-family="Verdana" font-size="8px">
												<?php echo $case->getNom();?>
											</text>
											<text	x="5"	y="40" fill="black" font-family="Verdana" font-size="8px">
												Prix <?php echo $case->getPrix();?>
											</text>
										<?php } else{ ?>
											<rect	width="60"	height="60" style="fill:white;	stroke-width:1;	stroke:black"/>
											<text	x="5"	y="30" fill="black" font-family="Verdana" font-size="8px">
												<?php echo $case->getNom();?>
											</text>
										<?php }?>
									</svg>
								</td>
						<?php  
							foreach ($tableauDeJeu->getCases() as $case) : 
								if($case->getPosition() == 50 - $i){ ?>
									<td colspan="9" ></td>
									<td>
										<svg xmlns="http://www.w3.org/2000/svg"	version="1.1" width="60" height="60">
											<?php if ($case->getType() != "action") { 	
												if ($case->getCouleur() != "train" && $case->getCouleur() != "service") { ?>
													<rect	width="10"	height="60" style="fill:<?php echo $case->getCouleurHTML();?>; stroke-width:1; stroke:black"/>
													<rect	width="50"	height="60" x="10" style="fill:white;	stroke-width:1;	stroke:black"/>
												<?php } else{ ?>
													<rect	width="60"	height="60" style="fill:white;	stroke-width:1;	stroke:black"/>
												<?php } ?>
												<text	x="12"	y="30" fill="black" font-family="Verdana" font-size="8px">
													<?php echo $case->getNom();?>
												</text>
												<text	x="12"	y="40" fill="black" font-family="Verdana" font-size="8px">
													Prix <?php echo $case->getPrix();?>
												</text>
											<?php } else{ ?>
												<rect	width="60"	height="60" style="fill:white;	stroke-width:1;	stroke:black"/>
												<text	x="12"	y="30" fill="black" font-family="Verdana" font-size="8px">
													<?php echo $case->getNom();?>
												</text>
											<?php }?>
										</svg>
									</td>
									</tr>
						<?php	break;
								}
							endforeach;
							break;
						}
	    			endforeach;
	    		}?>
    		<tr>
	    		<?php for ($i = 30; $i >= 20; $i--){
					foreach ($tableauDeJeu->getCases() as $case) : 
		    			if($case->getPosition() == $i){?>
		    				<td>
								<svg xmlns="http://www.w3.org/2000/svg"	version="1.1" width="60" height="60">
									<?php if ($case->getType() != "action") { 	
										if ($case->getCouleur() != "train" && $case->getCouleur() != "service") { ?>
											<rect	width="60"	height="10" style="fill:<?php echo $case->getCouleurHTML();?>; stroke-width:1; stroke:black"/>
											<rect	width="60"	height="50" y="10" style="fill:white;	stroke-width:1;	stroke:black"/>
										<?php } else{ ?>
											<rect	width="60"	height="60" style="fill:white;	stroke-width:1;	stroke:black"/>
										<?php } ?>
										<text	x="5"	y="17" fill="black" font-family="Verdana" font-size="8px">
											<?php echo $case->getNom();?>
										</text>
										<text	x="5"	y="27" fill="black" font-family="Verdana" font-size="8px">
											Prix <?php echo $case->getPrix();?>
										</text>
									<?php } else{ ?>
										<rect	width="60"	height="60" style="fill:white;	stroke-width:1;	stroke:black"/>
										<text	x="5"	y="17" fill="black" font-family="Verdana" font-size="8px">
											<?php echo $case->getNom();?>
										</text>
									<?php } ?>
								</svg>
							</td>
						<?php  break;
						}
	    			endforeach;
	    		}?>
    		</tr>
    	</table>
    	<br/>
        </form>
    </div>
    <?php include 'vue/piedpage.php'; ?>

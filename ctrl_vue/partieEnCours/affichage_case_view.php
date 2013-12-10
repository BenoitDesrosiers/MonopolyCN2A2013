<!-- Doit avoir comme paramètre d'entrée les valeur suivante 
		$classe pour le type de case ou la position de la case.
		$Longueur max pour la longueur maximum du text-->
<?php   $x = 38; 
		$y = 40;
	// Switch pour déterminer le type de case qu'il soit en haut, a gauche, a droite, en bas ou simplement un coin
	// pour déterminer tout les valeurs pour la case a afficher.
	switch($classe){
		case 'coin':
			$classeCss = "caseCoin";
			$width = 100; // La longueur de la case
			$height = 100; // La hauteur de la case
			$xrotate = 37; // l’abscisse du centre de rotation 
			$yRotate = 50; //l’ordonnée
			$rotation = 180; // Degrée de rotation
		    break;
		case 'haut':
			$classeCss = "caseH";
			$width = 75;
			$height = 100;
			$widthRect = 75; //Longueur du rectangle de couleur
			$heightRect =30; //Hauteur du rectangle de couleur
			$xRect =0; 		// Position X du rectangle de couleur
			$yRect =70;		// Position Y du rectangle de couleur
			$xrotate = 37;
			$yRotate = 50;
			$rotation = 180;
			break;
		case 'coteGauche':
			$classeCss = "caseCote";
			$width = 100;
			$height = 75;
			$widthRect = 30;
			$heightRect =75;
			$xRect =70;
			$yRect =0;
			$xrotate = 50;
			$yRotate = 50;
			$rotation = 90;
			break;
		case 'coteDroit':
			$classeCss = "caseCote";
			$width = 100;
			$height = 75;
			$widthRect = 30;
			$heightRect =75;
			$xRect =0;
			$yRect =0;
			$xrotate = 38;
			$yRotate = 37;
			$rotation = 270;
			break;
		case 'bas':
			$classeCss = "caseH";
			$width = 75;
			$height = 100;
			$widthRect = 75;
			$heightRect =30;
			$xRect =0;
			$yRect =0;
			$xrotate = 0;
			$yRotate = 0;
			$rotation = 0;
			break;
	}?>
	<!--  Chaque case de jeu -->
	<td class="<?php echo $classeCss?>">
		<svg width="<?php echo $width ?>px" height="<?php echo $height ?>px" xmlns="http://www.w3.org/2000/svg" version="1.1">
			<!-- Si c'est une case achetable du type propriété affichage du rectangle de couleur -->
			<?php if($case->getType() == "propriete"){?>	
				<rect x="<?php echo $xRect?>px" y="<?php echo $yRect?>px" width="<?php echo $widthRect ?>px" height="<?php echo $heightRect ?>px" style="fill:<?php echo $case->getCouleurHTML();?>;"/>
			<?php }?>
			<!-- Affichage du nom de la case et méthode pour couper le nom en deux ou trois partie 
			si le nom est trop long. Coupage au espace avec une longueur maximum défini dans l'index-->
			<text class="titreP" x="<?php echo $x?>px" y="<?php echo $y-10?>px" transform="rotate(<?php echo $rotation?> <?php echo $xrotate ?>,<?php echo $yRotate ?>)">
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
		   			<tspan class="titreP" x="<?php echo $x?>px" y="<?php echo $y?>px"> <?php echo substr(substr($nomCase, 0, $dernierEspace), strpos(substr($nomCase, 0, $dernierEspace), ' '), $dernierEspace);?></tspan>
		   			<tspan class="titreP" x="<?php echo $x?>px" y="<?php echo $y+10?>px"><?php echo substr($nomCase, $dernierEspace + 1);?></tspan>
		   		<?php else :
		   			echo substr($nomCase, 0, $dernierEspace);?>
		   			<tspan class="titreP" x="<?php echo $x?>px" y="<?php echo $y?>px"><?php echo substr($nomCase, $dernierEspace + 1);?></tspan>									
		   		<?php endif;
		   	else :?>
		   		<?php echo $case->getNom();
		   	endif;?></text>
		   	<!-- Affichage du pion  avec le pionId du joueur stocker dans l'array défini dans l'index.-->
		   	<?php if(array_key_exists($case->getPosition(), $ar_joueur)){
		   		$couleur = $ar_joueur[$case->getPosition()]->getPionId();
		   		include 'pion_view.php';
					}?>
			<!-- Affichage du prix si c'est une case achetable du type propriété, train ou service public. -->
		   	<?php if($case->getType() == "propriete" || $case->getType() == "ServicePublic" || $case->getType() == "train"){?>
		   	 <text class="montant" x="<?php echo $x?>px" y="<?php echo $y+44?>px" transform="rotate(<?php echo $rotation?> <?php echo $xrotate ?>,<?php echo $yRotate ?>)"><?php echo $case->getPrix();?> $</text>
		   	 <?php }?>
   		 </svg>
	</td> 
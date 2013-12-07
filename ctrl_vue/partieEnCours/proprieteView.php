
<svg width="75px" height="110px" xmlns="http://www.w3.org/2000/svg" version="1.1">
	<rect x="0px" y="0px" width="75px" height="30px" style="fill:<?php echo $case->getCouleurHTML();?>;"/>
	<text class="titreP" x="38px" y="40px">
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
					<tspan class="titreP" x="38px" y="50px"> <?php echo substr(substr($nomCase, 0, $dernierEspace), strpos(substr($nomCase, 0, $dernierEspace), ' '), $dernierEspace);?></tspan>
					<tspan class="titreP" x="38px" y="60px"><?php echo substr($nomCase, $dernierEspace + 1);?></tspan>
				<?php else :
					echo substr($nomCase, 0, $dernierEspace);?>
					<tspan class="titreP" x="38px" y="50px"><?php echo substr($nomCase, $dernierEspace + 1);?></tspan>
												
				<?php endif;
					else :?>
				<?php echo $case->getNom();
					endif;?></text>
	<text class="montant" x="38px" y="90px"><?php echo $case->getPrix();?> $</text>
</svg>

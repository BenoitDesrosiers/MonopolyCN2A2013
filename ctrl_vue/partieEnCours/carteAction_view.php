<?php
$laCarte; ?>


<svg xmlns="http://www.w3.org/2000/svg"	version="1.1" width="195" height="100">
	<rect	width="195"	height="100" style="fill:white;	stroke-width:1;	stroke:black"/>
	<text style="text-anchor: start" y="20" fill="black" font-family="Verdana" font-size="8px">
	<?php $description = explode("/n", $laCarte->getDescription());
			foreach ($description as $someshit){ ?>
			<tspan x="5" dy="10">
				<?php
					echo $someshit;
				?>
			</tspan>
			<?php }?>
	</text>
</svg>
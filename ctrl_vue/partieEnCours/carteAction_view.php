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

<?php 
	if($partie->getInteractionId() == INTERACTION_VENDRECARTEACTION && $carteActionId == $carte->getId()) {
		echo '<form action="." method="post">';
		echo '<input type="hidden" name="action" value="VendreCarteS"/>';
		echo 'Choisir un joueur : ';
		echo '<select name="compteJoueur">';
		foreach ($partie->getJoueurs() as $joueurListe) {
			if($joueur->getCompte() != $joueurListe->getCompte()){
				echo '<option value="' . $joueurListe->getCompte() . '">' . $joueurListe->getCompte() . '</option>';
			}
		}
		echo '</select> <br/>';
		echo 'Montant de vente : ';
		echo '<input type="text" name="montantVente" value="" style="width:50px"> <br/>';
		echo '<button type="submit" name="btnSoumettre" value="' . $carte->getId() . '">Soumettre</button>';
		echo '</form>';
	} else {
		echo '<a href=".?action=VendreCarteAction&carteActionId=' . $carte->getId() . '">Vendre</a>';
	}

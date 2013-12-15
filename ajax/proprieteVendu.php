<?php
require_once('../util/main.php');
require_once('modele/usager.php');
require_once('modele/joueur.php');
require_once('modele/partie.php');

	$partieId=$_GET['partie'];
	$partie = Partie::parId($partieId);
	
	foreach ($partie->getJoueurs() as $joueur) {
		echo $joueur->getCompte();
		?>
		</br>
		<?php 
		$carte = $joueur->getProprietes();
		foreach ($carte as $caseA) {
			echo $caseA->getCaseAssociee()->getNom();
			?>
			</br>
			<?php 
		}
	}
	
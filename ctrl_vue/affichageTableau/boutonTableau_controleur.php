<!DOCTYPE html>
<html>
<head>
    <?php include 'vue/headCommun.php'; ?>
</head>

<body>
    <?php 
		include 'vue/enteteCommune.php';
		include 'vue/piedpage.php';
	
		$joueurActuel = new Joueur($_SESSION['usager']->getPassword(), $_SESSION['usager']->getCompte(), $_SESSION['usager']->getNom());
		$joueurActuel->setPosition(47);
		$joueurActuel->brasseDes();
		
		
		
		//$avancement = $valeurDes1 + $valeurDes2;
		
		//$nouvellePos = $joueurActuel['PosAct'] + $avancement;
		//$joueurActuel['PosAct'] = $nouvellePos;
		//$tableauDeJeu->getCaseByPosition($joueurActuel['PosAct'])->getNom();
		
	?>
		

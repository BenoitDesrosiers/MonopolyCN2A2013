<!DOCTYPE html>
<html>
<head>
    <?php include 'vue/headCommun.php'; ?>
</head>

<body>
    <?php include 'vue/enteteCommune.php'; ?>
    		
  <?php $Joueur = new Joueur($_SESSION['usager']->getPassword(), $_SESSION['usager']->getCompte(), $_SESSION['usager']->getNom());
  	$Joueur->paye(600);
    	?>

    <?php include 'vue/piedpage.php'; ?>

<?php 

/* affiche l'info sur une partie existante
 * 
 * ENTRÉES:
 * $partie: la partie à afficher.  
 */
 
?>
<!DOCTYPE html>
<html>
<head>
    <?php 
        $titrePage = "Liste des parties en cours";
        include 'vue/headCommun.php'; 
    ?>
    <link rel="stylesheet" type="text/css" href="<?php echo $GLOBALS['app_path'].'css/creationPartie.css'?>" />
    
</head>

<body>
    <?php include 'vue/enteteCommune.php'; ?>

    <div id="conteneur">
    	<p>Id de la partie: <?php echo $partie->getId();?></p>
    	<p>Nom de la partie: <?php echo $partie->getNom();?></p>
    	<p>Coordonnateur de la partie:<?php echo $partie->getCoordonnateur();?></p>
    </div> <!-- conteneur --> 
    
    <div id="navigation">
        <a href="../../index.php">Retour au menu principale</a>
    </div>

<?php include 'vue/piedpage.php'; ?>
    
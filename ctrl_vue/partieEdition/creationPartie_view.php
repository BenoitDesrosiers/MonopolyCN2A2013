<?php 
// ENTRÉES:
// $partie: la partie a afficher. Peut-etre vide pour une creation, ou une partie existante pour une modification  
?>
<!DOCTYPE html>
<html>
<head>
    <?php include 'vue/headCommun.php'; ?>
    <link rel="stylesheet" type="text/css" href="<?php echo $GLOBALS['app_path'].'css/creationPartie.css'?>" />
    
    <script>
   
    </script>
    
</head>

<body>
    <?php include 'vue/enteteCommune.php'; ?>

    <div id="conteneur">
    	<form action="" method="post">
    	<input type="hidden" name="action" value="validerEtContinuer"/>
    	
    	<div id="section-info-Partie">

    	    <label for="nomPartie">Nom de la partie</label>
    		<input id="nomPartie" name="nomPartie" type="text" value="<?php echo $partie->getNom();?>" maxlength="40" required size="40" />
        </div>
    	
    	
    	<div id="section-Soumission" class="debut-section">
    		<button type="submit">Sauvegarder et continuer</button>
    	</div>
    	</form>
    	
    	
    </div> <!-- conteneur --> 
    

<?php include 'vue/piedpage.php'; ?>
    
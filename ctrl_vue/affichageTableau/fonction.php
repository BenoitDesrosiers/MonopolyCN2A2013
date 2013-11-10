<!DOCTYPE html>
<html>
<head>
    <?php include 'vue/headCommun.php'; ?>
    <link rel="stylesheet" href="<?php echo $GLOBALS['app_path'];?>css/table.css">
</head>

<body>
    <?php include 'vue/enteteCommune.php'; ?>
    
    <div id="main">			
        <?php
                    
            // Execution
                        
            // Dans l'execution de la fonction, la carte 31 sera pigée
            $joueur=new Joueur(array("UsagerCompte" => "benoit", "PartieEnCoursId" => 1));
            $case=CaseDeJeuAction::parPositionCase(7,1);
            $case->atterirSur($joueur);
                    
        ?>
        <form method="get">
    	    <input type="hidden" name="action" value="afficher"/>
    	    <input type="submit" value="Retour au tableau"/>
        </form>
     </div>
    <br/>
    <?php include 'vue/piedpage.php'; ?>
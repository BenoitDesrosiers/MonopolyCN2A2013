<?php 

/* affiche un message d'erreur
 * 
 * ENTRÉES:
 * $msg_erreur: le message à afficher.  
 */
 
?>
<!DOCTYPE html>
<html>
<head>
    <?php 
        $titrePage = "Erreur";
        include 'vue/headCommun.php'; 
    ?>    
</head>

<body>
    <?php include 'vue/enteteCommune.php'; ?>
    <div id="contenue">
        <h2>Erreur</h2>
        <p><?php echo $msg_erreur; ?></p>
    </div>
<?php include 'vue/piedpage.php'; ?>
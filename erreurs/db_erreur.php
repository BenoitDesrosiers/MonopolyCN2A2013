<?php 

/* affiche un message d'erreur de base de donnés
 * 
 * ENTRÉES:
 * $msg_erreur: le message à afficher.  
 */
?>
<!DOCTYPE html>
<html>
<head>
    <?php  
        $titrePage = "Erreur Base de Donnés";
        include 'vue/headCommun.php'; 
    ?>
</head>

<body>
    <div id="contenue">
        <?php include 'vue/enteteCommune.php'; ?>
        <h1>Erreur de base de donnés</h1>
        <p>Une erreur c'est produite avec la BD.</p>
        <p>Message: <?php echo $msg_erreur; ?></p>
        <p>&nbsp;</p>
    </div>
<?php include 'vue/piedpage.php'; ?>
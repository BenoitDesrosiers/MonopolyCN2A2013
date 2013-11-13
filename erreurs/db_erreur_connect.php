<?php 

/* affiche un message d'erreur lors de la connection a la bd
 *
* ENTRÉES:
* $msg_erreur: le message a afficher.
*/

?>
<!DOCTYPE html>
<html>
<head>
    <?php
        $titrePage = "Erreur connection";
        include 'vue/headCommun.php'; 
    ?>
</head>
<body>
    <?php include 'vue/enteteCommune.php'; ?>

    <div id="contenue">
        <h1>Erreur de connection a la base de donnees</h1>
        <p>Une erreur s'est produite lors de la connection a la BD.</p>
        <p>Message: <?php echo $msg_erreur; ?></p> 
        <p>&nbsp;</p>
    </div>
<?php include 'vue/piedpage.php'; ?>
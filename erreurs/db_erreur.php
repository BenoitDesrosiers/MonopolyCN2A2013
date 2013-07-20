<?php 
$titrePage = "Erreur Base de Donnés";
include 'vue/entete.php'; ?>
<div id="contenue">
    <h1>Erreur de base de donnés</h1>
    <p>Une erreur c'est produite avec la BD.</p>
    <p>Message: <?php echo $msg_erreur; ?></p>
    <p>&nbsp;</p>
</div>
<?php include 'vue/piedpage.php'; ?>
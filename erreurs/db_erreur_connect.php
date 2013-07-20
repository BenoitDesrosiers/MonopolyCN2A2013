<?php 
$titrePage = "Erreur connection";
include 'vue/entete.php'; ?>

<div id="contenue">
    <h1>Erreur de connection à la base de données</h1>
    <p>Une erreur s'est produite lors de la connection à la BD.</p>
    <p>Message: <?php echo $msg_erreur; ?></p> 
    <p>&nbsp;</p>
</div>

<?php include 'vue/piedpage.php'; ?>
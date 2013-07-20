<?php
if (!isset($_SESSION['usager'])) {
    $redirect = $_SERVER['PHP_SELF'];
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <?php include 'vue/headCommun.php';
        echo '<META HTTP-EQUIV="Refresh" Content="0; URL='.$app_path.'/connectionUsager/index.php?redirect='.$redirect.'">';
        ?>
    </head>
    
    <body>
    <?php
    echo "Vous allez être redirigé sur la page d'identification. <br>";
    echo "(si votre navigateur ne supporte pas cette fonctionnalité," . "<a href =\"$app_path./connectionUsager/index.php?redirect=$redirect\">cliquez ici</a><br>";
    die();
}
?>

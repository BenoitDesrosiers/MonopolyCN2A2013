<?php
//CONNECTION 1.1 : si l'usager est deja connecte, on saute cette procedure
if (!isset($_SESSION['usager'])) {
    $redirect = $_SERVER['PHP_SELF'];  //PHP_SELF contient le path (a partir de la racine du site) du fichier qui s'execute presentement (c.a.d. celui qui a inclut login.php). 
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <?php include 'vue/headCommun.php';
        //CONNECTION 1.2.x : l'usager doit se connecter, on redirige vers l'ecran de connection
        echo '<META HTTP-EQUIV="Refresh" Content="0; URL='.$app_path.'/connectionUsager/index.php?redirect='.$redirect.'">';
        ?>
    </head>
    
    <body>
    <?php
    //CONNECTION 1.2a : certain navigateur ne supporte pas la redirection. On affiche ce message et l'usager peut faire la redirection manuellement.
    echo "Vous allez être redirige sur la page d'identification. <br>";
    echo "(si votre navigateur ne supporte pas cette fonctionnalite," . "<a href =\"$app_path./connectionUsager/index.php?redirect=$redirect\">cliquez ici</a><br>";
    die();
}
?>

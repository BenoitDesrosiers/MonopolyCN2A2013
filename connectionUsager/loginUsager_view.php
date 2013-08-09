<!DOCTYPE html>
<html>
<head>
    <?php 
        $titrePage = "Login";
        include 'vue/headCommun.php'; 
    ?>
</head>

<body>    
    <?php include 'vue/enteteCommune.php'; ?>
    <div id="contenue">
    
        <h1>Connection</h1>
        <form action="" method="post" id="login_form">
            <input type="hidden" name="action" value="connection" />
    
            <label>Compte:</label>
            <input type="text" name="compte" size="30" />
            <br />
    
            <label>Mot de passe:</label>
            <input type="password" name="password" size="30" />
            <br />
    
            <label>&nbsp;</label>
            <input type="submit" value="Login" />
        </form>
    </div>
<?php include 'vue/piedpage.php'; ?>

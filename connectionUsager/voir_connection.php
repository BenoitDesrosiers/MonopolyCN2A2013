<!DOCTYPE html>
<html>
<head>
    <?php include 'vue/headCommun.php'; ?>
</head>

<body>
    <?php include 'vue/enteteCommune.php'; ?>
    
    <div id="contenue">
        <h1 class="top">Mon compte</h1>
        
        <p><?php echo $_SESSION['usager']->getNom() . ' (' . $_SESSION['usager']->getCompte() . ')'; ?></p>
        <p>Téléphone: <?php echo  $_SESSION['usager']->getTelephone()?></p>
        <p>Role: <?php echo  $_SESSION['usager']->role()?></p>
       
        <form action="" method="post">
            <input type="hidden" name="action" value="voir_connection_edit" />
            <input type="submit" value="Edit compte" />
        </form>
    
    </div>
    <?php include '../vue/piedpage.php'; ?>

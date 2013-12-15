<!DOCTYPE html>
<html>
<head>
    <?php include 'vue/headCommun.php'; ?>
</head>

<body>
    <?php include 'vue/enteteCommune.php'; ?>
    
    <div id="contenue">
        <h1 class="top">Mon compte</h1>
        
        <p><?php echo $usager->getNom() . ' (' . $usager->getCompte() . ')'; ?></p>
        <p>Role: <?php echo  $usager->getRole()?></p>
       
        <form action="" method="post">
            <input type="hidden" name="action" value="voir_connection_edit" />
            <input type="submit" value="Edit compte" />
        </form>
    
    </div>
    <?php include '../vue/piedpage.php'; ?>

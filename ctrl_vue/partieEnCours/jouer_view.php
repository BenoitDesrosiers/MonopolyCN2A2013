<?php 
/*
 * la partie est dmarre. 
 * Affiche le tableau et l'info des joueurs. 
 * 
 */?>

<!DOCTYPE html>
<html>
<head>
    <?php include 'vue/headCommun.php'; ?>
</head>

<body>
    <?php include 'vue/enteteCommune.php'; ?>
    
    <div id="main">                        
            <form id="menu-Form" action="." method="post">
                    <input type="hidden" name="action" value="menu"/>
                     <button type="submit" name="JouerCoup">Jouer un coup</button>
             </form>
            <h1>Tableau de jeu</h1>
            
            
                    <?php  foreach ($tableauDeJeu->getCases() as $case) : ?>
                            <p>
                            <?php echo $case->getId();?>
                            <?php echo $case->getPosition();?>
                            <?php echo $case->getNom();?>
                            
                            </p>
                            
                    <?php endforeach; ?>
            </table>
            <br/>
        </form-->
    </div>
    <?php include 'vue/piedpage.php'; ?>
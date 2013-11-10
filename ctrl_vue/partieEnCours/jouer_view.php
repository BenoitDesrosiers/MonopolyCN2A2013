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
    
    <?php //TODO ajouter une section pour le menu, l'interaction , pour les cartes, pour l'info du joueur, ... ?>
    
    <div id="main">                        
            <form id="menu-Form" action="." method="post">
                    <input type="hidden" name="action" value="menu"/>
                     <button type="submit" name="JouerCoup">Jouer un coup</button> <?php //TODO verifier si c'est au tour de ce joueur de jouer un coup. Si non, afficher un piton refresh au lieu de jouer?>
             </form>
            <h1>Tableau de jeu</h1>            
                    <?php include 'tableauDeJeu_view.php' ?>
            </table>
            <br/>
        </form-->
    </div>
    <?php include 'vue/piedpage.php'; ?>
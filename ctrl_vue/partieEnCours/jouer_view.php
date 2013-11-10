<?php 
/*
 * la partie est dŽmarrŽe. 
 * Affiche le tableau et l'info des joueurs. 
 * 
 */?>

<!DOCTYPE html>
<html>
<head>
    <?php include 'vue/headCommun.php'; ?>
    
<script type='text/javascript'>
    var xhr = null; 
    function getXhr()
    {
         if(window.XMLHttpRequest)xhr = new XMLHttpRequest(); 
        else if(window.ActiveXObject)
          { 
          try{
             xhr = new ActiveXObject("Msxml2.XMLHTTP");
             } catch (e) 
             {
             xhr = new ActiveXObject("Microsoft.XMLHTTP");
             }
          }
        else 
          {
          alert("Votre navigateur ne supporte pas les objets XMLHTTPRequest..."); 
          xhr = false; 
          } 
    }
     
    function DemoAjax()
    {
        getXhr();
        xhr.onreadystatechange = function()
            {
             if(xhr.readyState == 4 && xhr.status == 200)
             {
             document.getElementById('demoAjax').innerHTML=xhr.responseText;
             }
            }
        xhr.open("GET","<?php echo $GLOBALS['app_path']."/ajax/demoajax.php"?>",true);
        xhr.send(null);
    }
 
</script>
    
</head>

<body>
    <?php include 'vue/enteteCommune.php'; ?>
    
    <?php //TODO ajouter une section pour le menu, l'interaction , pour les cartes, pour l'info du joueur, ... ?>
    
    <div id="main">                        
            <form id="menu-Form" action="." method="post">
                    <input type="hidden" name="action" value="menu"/>
                     <button type="submit" name="JouerCoup">Jouer un coup</button> <?php //TODO verifier si c'est au tour de ce joueur de jouer un coup. Si non, afficher un piton refresh au lieu de jouer?>
                     
                     <button type="button" name="TestAJAX" onClick="DemoAjax()">Demo AJAX</button> 
             </form>
             <div id="demoAjax">
             </div>
            <h1>Tableau de jeu</h1>            
                    <?php include 'tableauDeJeu_view.php' ?>
            </table>
            <br/>
        </form-->
    </div>
    
    <?php include 'vue/piedpage.php'; ?>
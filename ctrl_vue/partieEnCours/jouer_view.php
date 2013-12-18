<?php 
/*
 * la partie est demarree. 
 * Affiche le tableau et l'info des joueurs. 
 * 
 * TODO: renommer cette view partieEnCours_view.php
 * 
 */
 ?>

<!DOCTYPE html>
<html>
<head>
    <?php include 'vue/headCommun.php'; ?>
    <link rel="stylesheet" type="text/css" href="<?php echo $GLOBALS['app_path'].'css/Structure.css'?>">
	<link rel="stylesheet" type="text/css" href="<?php echo $GLOBALS['app_path'].'css//Menu.css'?>">
	<link rel="stylesheet" type="text/css" href="<?php echo $GLOBALS['app_path'].'css/Button.css'?>">
	    
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
    function ListeProprieteVendu(partieId)
    {
        getXhr();
        xhr.onreadystatechange = function()
            {
             if(xhr.readyState == 4 && xhr.status == 200)
             {
                
             	document.getElementById('proprieteVendu').innerHTML=xhr.responseText;
             }
            }
        xhr.open("GET","<?php echo  $GLOBALS['app_path']."/ajax/proprieteVendu.php?partie="?>"+partieId,true);
        xhr.send(null);
    }
 
</script>
    
</head>
<?php
	$compteUsager = $usager->getCompte(); //TODO: envoyer cette declaration dans info_partie_viewphp
?>
<body onload="activationRafraichissement('<?php echo $compteUsager;?>')"> <!-- Lance l'affichage automatique des informations de la partie dès que le body s'affiche -->
<?php //TODO: remplacer ce onload par un window.onload = function() dans info_partie_view.php ?>
    <?php include 'vue/enteteCommune.php'; ?>
    
    <?php //TODO ajouter une section pour le menu, l'interaction , pour les cartes, pour l'info du joueur, ... ?>
    
	<div id="enveloppe">
	<div id="contenu">
	    
        <div id="divTableau">
                 <div id="demoAjax">
                 </div>
                 
                 <div id="proprieteVendu"> <!-- pour ajax de vero -->
     			 </div>
                
                <?php include 'tableauDeJeu_view.php'
				 ?>
                
                
        </div>
    </div> <!-- contenu -->
    </div> <!-- enveloppe -->
    <div id="navigation">
           <?php //TODO mettre le bouton disable dependamment de l'interaction en cours ?>
			<!--les boutons pour jouer: refresh, brasser, acheter Maison/hotel, quitter -->
			<ul id="choixNavigation" class="menuAvecBouton">
				<li><a href="."><b>Rafraichir</b></a></li>
	            <li><a href=".?action=JouerCoup"><b>Jouer</b></a></li> <!--//TODO verifier si c'est au tour de ce joueur de jouer un coup. Si non, afficher un piton refresh au lieu de jouer -->
				<li><a href="#nogo" onClick="DemoAjax()"><b>demo Ajax</b></a></li>
				<li><a href="#nogo" onClick="ListeProprieteVendu(<?php echo $partieId?>)"><b>Propri&eacute;t&eacute;s vendues</b></a></li>
	            <li><a href="#nogo"><b>Achat Maison</b></a></li>
				<li><a href=".?action=GenererAchatHotel"><b>Achat Hotel</b></a></li>
				<li><a href="#nogo"><b>Quitter</b></a></li>
			</ul>
	</div> <!-- navigation -->

	<?php require_once 'info_partie_view.php';?>

	<div id="argent">
		<!-- afficher l'argent du joueur ici -->
	</div> <!-- argent -->

	<div id="propriete">
        <!-- afficher les proprietes du joueur ici -->  
    </div> <!-- propriete -->
    
    <?php if( $partie->getInteractionId() == INTERACTION_ACHATPROPRIETE){ 
    		include 'achatPropriete.php';
    }?>
	<?php include 'vue/piedpage.php'; ?>
    
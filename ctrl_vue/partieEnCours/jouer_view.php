<?php 
/*
 * la partie est d�marr�e. 
 * Affiche le tableau et l'info des joueurs. 
 * 
 */?>

<!DOCTYPE html>
<html>
<head>
    <?php include 'vue/headCommun.php'; ?>
    <link rel="stylesheet" type="text/css" href="<?php echo $GLOBALS['app_path'].'css/Structure.css'?>">
	<link rel="stylesheet" type="text/css" href="<?php echo $GLOBALS['app_path'].'css//Menu.css'?>">
	<link rel="stylesheet" type="text/css" href="<?php echo $GLOBALS['app_path'].'css/Button.css'?>">
	<link rel="stylesheet" type="text/css" href="<?php echo $GLOBALS['app_path'].'css/table.css'?>">
	    
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
    
    function AfficherInfo(Id, partieId)
    {

        getXhr();
        xhr.onreadystatechange = function()
            {
             if(xhr.readyState == 4 && xhr.status == 200)
             {
             document.getElementById('infoCase').innerHTML=xhr.responseText;
             }
            }
        xhr.open("GET","<?php echo $GLOBALS['app_path']."/js/AfficherInformation.php?carteId="?>"+Id+"&partieId="+partieId,true);
        xhr.send(null);
    }
 
</script>
    
</head>

<body>

    <?php include 'vue/enteteCommune.php'; ?>
    
    <?php //TODO ajouter une section pour le menu, l'interaction , pour les cartes, pour l'info du joueur, ... ?>
    
	<div id="enveloppe">
	<div id="contenu">
	    
        <div id="divTableau">
                 <div id="demoAjax">
                 </div>
                
                <?php include 'tableauDeJeu_view.php' ?>
        </div>
    </div> <!-- contenu -->
    </div> <!-- enveloppe -->
    <div id="navigation">
			<!--les boutons pour jouer: refresh, brasser, acheter Maison/hotel, quitter -->
			<ul id="choixNavigation" class="menuAvecBouton">
				<li><a href="."><b>Rafraichir</b></a></li>
	            <li><a href=".?action=JouerCoup"><b>Jouer</b></a></li> <!--//TODO verifier si c'est au tour de ce joueur de jouer un coup. Si non, afficher un piton refresh au lieu de jouer -->
				<li><a href="#nogo" onClick="DemoAjax()"><b>demo Ajax</b></a></li>
	            <li><a href="#nogo"><b>Achat Maison</b></a></li>
				<li><a href="#nogo"><b>Achat Hotel</b></a></li>
				<li><a href="#nogo"><b>Quitter</b></a></li>
			</ul>
	</div> <!-- navigation -->

	<div id="argent">
		<!-- afficher l'argent du joueur ici -->
	</div> <!-- argent -->
	<div>
	 <?php if ($partie->getInteractionId()==12345) {?>
	 	<p>Voulez vous vraiment hypothequer la case:
	 	<?php
	 	echo $nomCarte." ?";
	 	include('./hypothequer.php');
	 }
	 else if ($partie->getInteractionId()==54321)
	 {?>
	 <p>Voulez vous vraiment racheter la case:
	 	<?php
	 	echo $nomCarte." ?";
	 	include('./racheter.php');
	 
	 }?>
	</div>
	 
	<div id="propriete">
	<?php 
			$carteP = $joueur->getProprietes();
			$partieId = $joueur->getPartieId();
			?>
			<table border=1>
			<tr>
			<?php
			foreach ( $carteP as $propriete ) :
				?>
				<td class="carte2" >
				<?php
				$case = $propriete->getCaseAssociee();
				$Id = $propriete->getCaseId();
				
				include './proprieteView.php';
				//echo $Id;
				?>
				<ul>
			<?php 
				//$carte = CartePropriete::pourCasePartie($Id, $partieId);
				$valeurHypo = $propriete->getHypotheque();
				if ($valeurHypo==1)
					{
						?>
						<li><a href=".?action=racheter&carteId=<?php echo $Id?>"><b>Racheter</b></a></li>
						<?php
					}
				else
				{
			?>
				<li><a href=".?action=hypothequer&carteId=<?php echo $Id?>"><b>Hypoth�quer</b></a></li>
				<?php 
				}
				?>
	            <li><a href="#nogo" onClick="AfficherInfo(<?php echo $Id?>, <?php echo $partieId?>)"><b>Informations</b></a></li>
	            </ul>
				</td>
				
				<?php
				
			endforeach;
			
			?>
			</tr>
			</table>
        <div id ="infoCase">
    
    </div>
    </div> <!-- propriete -->
   
	<?php include 'vue/piedpage.php'; ?>
    
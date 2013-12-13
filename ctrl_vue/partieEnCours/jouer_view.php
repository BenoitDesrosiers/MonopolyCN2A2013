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

    function detailJoueur(idPartie){
    	if (window.XMLHttpRequest){
    		xmlhttp=new XMLHttpRequest();
    	}
    	else{
    		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    	}

    	xmlhttp.onreadystatechange=function(){
    		if(xmlhttp.readyState==4 && xmlhttp.status==200){
    			document.getElementById("argent").innerHTML=xmlhttp.responseText;
    		}
    	};

    	xmlhttp.open("GET","<?php echo $GLOBALS['app_path']."/ajax/detail_joueur.php"?>?idPartie="+idPartie,true);
    	xmlhttp.send();
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
	
	<div id="cartesAction" style="margin-left:40px">
		<?php
			foreach ($joueur->getListeCartes() as $carte) {
				$laCarte = $carte;
				include 'carteAction_view.php';
				if($partie->getInteractionId() == 27 && $carteActionId == $carte->getId()) {
					echo '<form action="." method="post">';
					echo '<input type="hidden" name="action" value="VendreCarteS"/>';
					echo 'Choisir un joueur : ';
					echo '<select name="compteJoueur">';
					foreach ($partie->getJoueurs() as $joueurListe) {
						if($joueur->getCompte() != $joueurListe->getCompte()){
							echo '<option value="' . $joueurListe->getCompte() . '">' . $joueurListe->getCompte() . '</option>';
						}
					}
					echo '</select> <br/>';
					echo 'Montant de vente : ';
					echo '<input type="text" name="montantVente" value="" style="width:50px"> <br/>';
					echo '<button type="submit" name="btnSoumettre" value="' . $carte->getId() . '">Soumettre</button>';
					echo '</form>';
				}
				else {
					echo '<a href=".?action=VendreCarteAction&carteActionId=' . $carte->getId() . '">Vendre</a>';
				}
			}
		?>
	</div>

	<div id="argent">
		<button type="button"  onclick="detailJoueur(<?php echo $partie->getId(); ?>)"> Afficher le detail des joueurs</button>
	</div>

	<div id="propriete">
        <!-- afficher les proprietes du joueur ici -->  
    </div> <!-- propriete -->
	<?php include 'vue/piedpage.php'; ?>
    
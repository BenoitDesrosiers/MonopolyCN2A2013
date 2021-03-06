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
	<link rel="stylesheet" type="text/css" href="<?php echo $GLOBALS['app_path'].'css/Menu.css'?>">
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
    
    function ListeProprieteNonVendu(partieId)
    {
        getXhr();
        xhr.onreadystatechange = function()
            {
             if(xhr.readyState == 4 && xhr.status == 200)
             {
                
                     document.getElementById('proprieteNonVendu').innerHTML=xhr.responseText;
             }
            }
        xhr.open("GET","<?php echo  $GLOBALS['app_path']."/ajax/proprieteNonVendu.php?partie="?>"+partieId,true);
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
    
    function AfficherInfoPropriete(caseId)
    {
        getXhr();
        xhr.onreadystatechange = function()
            {
             if(xhr.readyState == 4 && xhr.status == 200)
             {
             document.getElementById('affichageInfos').innerHTML=xhr.responseText;
             }
            }
        xhr.open("GET","<?php echo $GLOBALS['app_path']."/ajax/afficherinfopropriete.php?case=" ?>"+caseId,true);
        xhr.send(null);
    }
</script>
<script src="<?php echo $GLOBALS['app_path'];?>ajax/aideajax.js"></script>
  
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
                 
                 <div id="proprieteVendu"> <!-- pour ajax de vero -->
     			 </div>
     			 <div id="proprieteNonVendu"> <!-- pour ajax de sam -->
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
				<li><a href="#nogo" onClick="ListeProprieteVendu(<?php echo $partieId?>)"><b>Propri&eacute;t&eacute;s&nbsp;vendues</b></a></li>
				<li><a href="#nogo" onClick="ListeProprieteNonVendu(<?php echo $partieId?>)"><b>ProprieteNonVendu</b></a></li>	           
	            <li><a href=".?action=AchatMaison"><b>Achat Maison</b></a></li>
				<li><a href=".?action=GenererAchatHotel"><b>Achat Hotel</b></a></li>
				<li><a href=".?action=questionVtPropriete"><b>Vente Propriété</b></a></li><!-- Tommy Teasdale -->
				<li><a id="help"><b>Aide</b></a></li>
				<li><a href="#nogo"><b>Quitter</b></a></li>
			</ul>
	</div> <!-- navigation -->
	
	<div id="affichageInfos">
	</div>
	
	<!-- div id="cartesAction" style="margin-left:40px"-->
		<?php
			foreach ($joueur->getListeCartes() as $carte) {
				$laCarte = $carte;
				include 'carteAction_view.php';
				
			}
		?>
	<!--  /div-->

	<?php require_once 'info_partie_view.php';?>

	<div id="argent">
		<button type="button"  onclick="detailJoueur(<?php echo $partie->getId(); ?>)"> Afficher le detail des joueurs</button>
	</div>

	<div id="propriete">
        <!-- afficher les proprietes du joueur ici -->  
    </div> <!-- propriete -->
    
    <div id="interaction">
    <?php 
        switch ($partie->getInteractionId()) {
            case INTERACTION_ACHATPROPRIETE: 
        		include './interaction_questionOuiNon_view.php';
        		break;
        	case INTERACTION_ACHATHOTEL:
        		include('./interaction_achat_hotel_view.php');
        		break;
            case INTERACTION_ACHATMAISON:
            	include('./interaction_achat_maison_view.php');
            	break;
            case INTERACTION_VENTEPROPRIETE:
            	include('./interaction_vente_prop_view.php');
            	break;
            case INTERACTION_HYPOTHEQUER:
            	include('./interaction_questionOuiNon_view.php');
            	break;
            case INTERACTION_RACHETER:
            	include('./interaction_questionOuiNon_view.php');
            	break;
            case INTERACTION_SORTIRDEPRISON:
            	include('./question_prison.php');
            	break;
            default:
                //fait rien
        }
    ?>
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
				
				$case = $propriete->getCaseAssociee();
				$Id = $propriete->getCaseId();
				$classe = "bas";
				$LongueurMax = 12; 
				include './affichage_case_view.php';
				?>
				<td>
				<?php
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
				<li><a href=".?action=hypothequer&carteId=<?php echo $Id?>"><b>Hypoth&ecirc;quer</b></a></li>
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
    
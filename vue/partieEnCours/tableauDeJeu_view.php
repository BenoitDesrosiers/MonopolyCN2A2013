<!-- Affiche le tableau de jeu
     input:
         $tableauDeJeu : une instance de la classe Tableau
         
  -->


<table id="plateau" cellspacing="0" border="0">
<tr>

<?php 
    //Boucle creant un tableau des joueurs selon leur position. Utilisee pour l'affichage des pions
    foreach ($partie->getJoueurs() as $joueurListe) {
        $joueurPos = $joueurListe->getPosition();
        $ar_joueur[$joueurListe->getPosition()]=$joueurListe;
    }

    $i =0;
    $LongueurMax = 12;
			//Boucle pour afficher la ligne du haut
			
			while($i != 11) :
				$case = $tableauDeJeu->getCaseParPosition($i);
    			 if($i == 0 || $i == 10) {
  					$classe = "coin";
					include 'affichage_case_view.php';
					
    			  } 
    			  else { 
					$classe = "haut";
					include 'affichage_case_view.php';
    			  };
    			  $i++;
    		 endwhile;?>
	    		</tr>
	    	<!-- Boucle pour afficher les deux lignes du cotes plus le centre du plateau de jeu -->
    		<?php while($i != 20) :?>
    			<tr>
    			<?php $case = $tableauDeJeu->getCaseParPosition(50-$i);
						$classe = "coteGauche";
						include 'affichage_case_view.php';
						
						if($i == 11):?>
							<td id="centre"colspan="9" rowspan="9">
								<svg x="0px" y="0px" width="700px" height="700px" xmlns="http://www.w3.org/2000/svg" version="1.1">
  									<rect x="250" y="150" width="100" height="150" stroke="black" stroke-width="2" stroke-dasharray="3" fill="RGB(203,233,225)" transform="rotate(220 200,200)"/>
  									<text x="130" y="185" width="100" height="150" transform="rotate(130 150,150)">CHANCE</text>
  									<rect x="-50" y="0" rx="20" ry="20" width="120" height="420" stroke="white" stroke-width="2" fill="red" transform="rotate(220 200,200)" />
  									<rect x="-40" y="10" rx="20" ry="20" width="100" height="400" stroke="white" stroke-width="2" fill="red" transform="rotate(220 200,200)" />
  									<text x="160" y="385" width="100" height="150" style="fill:white; stroke:black; font-size:52px;"transform="rotate(310 150,150)">MONOPOLY</text>
  									<rect x="-350" y="75" width="100" height="150" stroke="black" stroke-width="2" stroke-dasharray="3" fill="RGB(203,233,225)" transform="rotate(220 200,200)"/>
  									<text x="95" y="725" width="100" height="150" transform="rotate(310 150,150)">Caisse Commune </text>
								</svg> 
							</td>

						<?php endif;
						$case = $tableauDeJeu->getCaseParPosition($i);
    					$classe = "coteDroit";
						include 'affichage_case_view.php';
						
						$i++;?>
					</tr>
    		<?php endwhile;?>
				<!-- Boucle pour afficher la ligne du bas -->
    			<?php while($i <= 30) :
    		 		$case = $tableauDeJeu->getCaseParPosition(20+(30-$i)); 
    				if ($i == 20 || $i == 30) {
						 $classe = "coin"; 
						 include 'affichage_case_view.php';
						 
					 }
    				else{
    				$classe = "bas";
    				include 'affichage_case_view.php';
    				
    				}
    				 $i++;
    			endwhile;?>
	    		</table>
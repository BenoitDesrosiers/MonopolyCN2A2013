<?php 

echo '<!DOCTYPE html>';
echo '<html>';

echo '<head>';
     include 'vue/headCommun.php'; 
echo '</head>';

echo '<body>';
     include 'vue/enteteCommune.php'; 
    
    echo '<div id="main">';			
    	
    	echo '<h1>Tableau de jeu</h1>';
    	
    	//stockage des cases dans un array pour faciliter le travail ultérieur
    		for($x = 1; $x<40;$x++)
    		{
    			$case = $tableauDeJeu->getCaseParPosition($x);
    			if( $case != null)
    			{
    				$array[$x-1]=$case;
    			}
    			else
    				$array[$x-1]=null;
    		}
    		


    		
    		
    echo '<table class="table" border="1">';
	echo '<tr class="tr">';
	echo '<td class="coin"></td>';
 
 //Boucle pour la ligne du haut
    $x=1;
    for($x=1; $x<10;$x++)
		{
			if($array[$x-1]!=null)
			{
				$c = $array[$x-1]->getPosition();
				if ($c==$x)
				{
					echo '<td class="haut"><svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 75 100" >';
					echo '<rect x="0" y="75" width="75" height="30" style="fill:';
						
					echo $array[$x-1]->getCouleurHTML();

					echo '"/>';
					
					echo '<text x="0" y="60" fill="red" font-size="12px" >';
							
					echo $array[$x-1]->getNom();
					
					echo '</text><text x="30" y="10" fill="red" font-size="12px" >';
					
					echo $array[$x-1]->getPrix();
						
					echo '</text></svg></td>';			
				}
			}
    		else
    			{	
    				echo '<td class="haut"></td>';	
    			}
		}		

	$caseG = 39;
	$flag=false;
	$flag2=false;
	$caseD = 11;
	
   for($x=0; $x<9;$x++)   //Boucle pour les côtés
		{
			$caseG = $caseG-$x;
			$caseD = $caseD+$x;
			
			echo '<tr>';
			
			for($y=$caseG;$y>30;$y--) //boucle pour la gauche
				{
					if($array[$y-1]!=null && $flag == false)
						{
							$c = $array[$y-1]->getPosition();
								if ($c==$caseG)
								{
									$flag=true;
						
									echo '<td class="gauche"><svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 100 75" >';
									echo '<rect x="69" y="0" width="30" height="75" style="fill:';
						
									echo $array[$y-1]->getCouleurHTML();
						
									echo '"/>';
									echo '<text x="55" y="0" fill="red" font-size="12px" transform="rotate(90 55,0)" >';
						
									echo $array[$y-1]->getNom();
									
									echo '</text><text x="5" y="30" fill="red" font-size="12px" transform="rotate(90 5,30)" >';
									
									echo $array[$y-1]->getPrix();	
						
									echo '</text></svg></td>';						
								}
						}
					else
					{
						if($flag == false)
						{
							echo '<td class="gauche"><p></p></td>';
					
							$flag=true;
						}
					
					}
					
				} //fin de la boucle de gauche
				
				
				//la grande case vide qui rempli le milieu
				echo '<td class="vide" colspan="9" rowspan="1"></td>';
			
			
		
			for($z=$caseD;$z<20;$z++) //boucle pour la droite
			{
					if($array[$z-1]!=null && $flag2 == false)
					{
						$c = $array[$z-1]->getPosition();
						
						if ($c==$caseD)
						{
							
							echo '<td class="droite"><svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 100 75" >';
							echo '<rect x="1" y="0" width="30" height="75" style="fill:';
						
							echo $array[$z-1]->getCouleurHTML();
						
							echo '"/>';
							echo '<text x="45" y="75" fill="red" font-size="12px" transform="rotate(270 45,75)" >';
						
							echo $array[$z-1]->getNom();
							
							echo '</text><text x="95" y="40" fill="red" font-size="12px" transform="rotate(270 95,40)" >';
							
							echo $array[$z-1]->getPrix();	
						
							echo '</text></svg></td>';
						
							$flag2=true;
						}
					}
					else
					{
						if($flag2 == false)
						{
					
							echo '<td class="droite"><p></p></td>';
					
							$flag2=true;
						}
					
					}
			} //fin de la boucle du côté droit
			
			$flag=false;
			$flag2=false;
			$caseG = 39;
			$caseD = 11;
			
			echo '</tr>';
			
				
	} //fin de la grande boucle
	
echo '<tr class="tr">';
echo '<td class="coin"></td>';
    
    for($x=29; $x>20;$x--)  //Boucle de creation de la ligne du bas
		{
			if($array[$x-1]!=null)
			{
				$c = $array[$x-1]->getPosition();
					if ($c==$x)
					{
					
						echo '<td class="bas"><svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 75 100" >';
						echo '<rect x="0" y="0" width="75" height="30" style="fill:';
						
						echo $array[$x-1]->getCouleurHTML();
							
						echo '"/>';
						
						echo '<text x="0" y="50" fill="red" font-size="12px" >';
							
						echo $array[$x-1]->getNom();
						
						echo '</text><text x="30" y="95" fill="red" font-size="12px" >';
						
						echo $array[$x-1]->getPrix();			
							
						echo '</text></svg></td>';
							
					}

			}
    		else
    			{
    				echo '<td class="bas"></td>';
    			}
		}		


echo '<td class="coin"></td>';
echo '</tr>';

    	echo '</table>';
    	echo '<br/>';
        echo '</form-->';
        
    echo '</div>';
    
    include 'vue/piedpage.php'; 
    ?>

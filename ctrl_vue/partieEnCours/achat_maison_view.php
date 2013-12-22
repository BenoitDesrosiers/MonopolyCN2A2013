<div id="interaction">
<?php        	
    $Proprietes = $joueur->getProprietesBatissable($partie);         	
    echo "<table>";?>
    <form action="." method="post" id="build">
    	<input type="hidden" name="action" value="AcheterMaison" />
    <?php 
   		foreach ($Proprietes as $case){	
        	echo "<tr>";	
 	    	echo $case->getCaseAssociee()->getNom();
	        echo "</br>";
	        echo "<label>Maison a construire:</label>"; ?>
       			<input type="text" name="case<?php echo $case->getCaseAssociee()->getId()?>" size="30" />		
           	<?php
           	echo "</tr>";            	
        }
        echo "</table>";
        ?>
        <label>&nbsp;</label>
        <input type="submit" value="Build" />
    </form>
</div> <!-- interactoin -->

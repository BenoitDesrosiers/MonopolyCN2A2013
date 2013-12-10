<?php
/*
 -- Par Tommy Teasdale
*/
?>
<h3>Forcer la vente d'une propriété</h3>
<form action="./index.php?action=vtPropriete" method="post">
    <label>Propriétés à vendre</label>
    <select name="propriete">
        <option selected disabled>Choisissez une propriété à vendre</option>
        <?php
            foreach($joueur->getProprietes() as $prop){
                ?>
                <option value="<?php print $prop->getCaseAssociee()->getId()?>"><?php print $prop->getCaseAssociee()->getNom()?></option>
                <?php
            }
        ?>
        
    </select>
    <label>Joueur</label>
    <select name="joueur">
        <option selected disabled>Choisissez à qui forcer l'achat</option>
        <?php
            foreach($partie->getJoueurs() as $joue){
                if($joue->getCompte()!=$joueur->getCompte()){
                ?>
                <option value="<?php print $joue->getCompte()?>"><?php print $joue->getCompte()?></option>
                <?php
                }
            }
        ?>
        
    </select>
    <button type="submit">Forcer la vente</button>
</form>
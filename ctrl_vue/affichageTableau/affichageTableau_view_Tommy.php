<!DOCTYPE html>
<html>
<head>
    <?php include 'vue/headCommun.php'; ?>
    <link rel="stylesheet" href="<?php echo $GLOBALS['app_path'];?>css/table.css">
</head>

<body>
    <?php include 'vue/enteteCommune.php'; ?>
    
    <div id="main">			
    	
    	<h1 class="title">Tableau de jeu</h1>
    	<br/>
    	<div class="tableau">
    	    <?php
    	    for($i=0;$i<count($lignes);$i++){
                ?>
                <div class="<?php echo $lignes[$i]['type'];?>">
                <?php
                for($j=$lignes[$i]['start'];($lignes[$i]['compare']($j,$lignes[$i]['end']));$j=$lignes[$i]['inc']($j)){
                    $case=$tableauDeJeu->getCaseParPosition($j);
                    
                    if(($lignes[$i]['coin'])&&($j==$lignes[$i]['start']||$j==$lignes[$i]['dec']($lignes[$i]['end']))){
                        ?>
                        <div class="coin" id="<?php echo $case->getId();?>">
                            <svg viewBox="<?php echo $lignes[$i]['viewBox'];?>" xmlns="http://www.w3.org/2000/svg" version="1.1">
                        <?php
                    }else{
                        ?>
                        <div class="<?php echo $lignes[$i]['carte']?>" id="<?php echo $case->getId();?>">
                            <svg viewBox="<?php echo $lignes[$i]['viewBox'];?>" xmlns="http://www.w3.org/2000/svg" version="1.1">
                                <?php
                                if($case->getType()=='achetable'){
                                ?>
                                <rect width="<?php echo $lignes[$i]['rectW'];?>" height="<?php echo $lignes[$i]['rectH'];?>" x="<?php echo $lignes[$i]['rectX'];?>" y="<?php echo $lignes[$i]['rectY'];?>" style="fill:<?php echo $case->getCouleurHTML();?>; stroke-width:1; stroke:black"></rect>
                                <text x="<?php echo $lignes[$i]['prixX'];?>" y="<?php echo $lignes[$i]['prixY'];?>" fill="black" transform="<?php echo $lignes[$i]['prixTransform'];?>">
                                    <tspan x="37.5" dy="1.2em"><?php echo $case->getPrix();?>&yen;</tspan>
                                </text>
                        <?php
                        }
                    }
                    ?>
                    <text x="<?php echo $lignes[$i]['nomX'];?>" y="<?php echo $lignes[$i]['nomY'];?>" fill="black" transform="<?php echo $lignes[$i]['nomTransform'];?>">
                    <?php
                    if(strlen($case->getNom())<14){
                        ?>
                        <tspan x="37.5" dy="1.2em"><?php echo $case->getNom();?></tspan>
                        <?php  
                    }else{
                        $ar_str_nom=null;
                        switch(substr_count($case->getNom()," ")){
                            case 1:
                                $ar_str_nom=explode(" ",$case->getNom(),2);
                                break;
                            case 2:
                                $last_space=strripos($case->getNom()," ");
                                $ar_str_nom[]=substr($case->getNom(),0,$last_space);
                                $ar_str_nom[]=substr($case->getNom(),$last_space+1,strlen($case->getNom()));
                                break;
                            default:
                                $ar_str_nom=explode(" ",$case->getNom(),2);
                                if(strlen($ar_str_nom[1])>14){
                                    $last_space=strripos($ar_str_nom[1]," ");
                                    $ar_str_nom2[0]=$ar_str_nom[0];
                                    $ar_str_nom2[1]=substr($ar_str_nom[1],0,$last_space);
                                    $ar_str_nom2[2]=substr($ar_str_nom[1],$last_space+1,strlen($ar_str_nom[1]));
                                    $ar_str_nom=$ar_str_nom2;
                                }
                        }
                        
                        foreach($ar_str_nom as $str){
                            ?>
                            <tspan x="37.5" dy="1.2em"><?php echo $str;?></tspan>
                            <?php
                        }
                    }
                    
                    ?>
                            </text>
                        </svg>
                    </div>
                    <?php
                }
                ?>
                </div>
                <?php
            }
    	    ?>
    	</div>
    	<form method="get">
    	    <input type="hidden" name="action" value="fonction"/>
    	    <input type="submit" value="Atterir sur une case action et payer 50$ aux autres joueurs"/>
        </form>
    	<br/>
    </div>
    <?php include 'vue/piedpage.php'; ?>

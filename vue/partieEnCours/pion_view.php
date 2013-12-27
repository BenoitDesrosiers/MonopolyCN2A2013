<?php 
switch ($couleur){
	case '1':
		$couleur = "#FF0101"; //rouge
		break;
	case '2':
		$couleur = "#010101"; //noir
		break;
	case '3':
		$couleur = "#FFFFFF"; // orange pale
		break;
	case '4':
		$couleur = "#FFFF00"; // jaune
		break;
	case '5':
		$couleur = "#40FF00"; // vert
		break;
	case '6':
		$couleur = "#00FFFF"; //turquoise
		break;
	case '7':
		$couleur = "#819FF7"; //bleu pale
		break;
	case '8':
		$couleur = "#0000FF"; // bleu 
		break;
	case '9':
		$couleur = "#BF00FF"; // mauve
		break;
	case '10':
		$couleur = "#FF00FF"; // rose
		break;
	case '11':
		$couleur = "#FF0040"; // rose fonce
		break;
	case '12':
		$couleur = "#848484"; // gris
		break;
}
?>

<!-- Pion de jeu avec la couleur -->	
<circle cx="40" cy="50" r="12" stroke="black" stroke-width="" fill="<?php echo $couleur?>" />
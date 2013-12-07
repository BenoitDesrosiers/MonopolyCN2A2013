<?php 
switch ($couleur){
	case '1':
		$couleur = "#AEEE00";
		break;
	case '2':
		$couleur = "#01B0F0";
		break;
	case '3':
		$couleur = "#FF0000";
		break;
	case '4':
		$couleur = "#FF8900";
		break;
	case '5':
		$couleur = "#6B1A6A";
		break;
	case '6':
		$couleur = "#191919";
		break;
	case '7':
		$couleur = "#FF73BF";
		break;
	case '8':
		$couleur = "#EACFB8";
		break;
}
?>

	<svg height="25" width="25" xmlns="http://www.w3.org/2000/svg" version="1.1">
		<circle cx="13" cy="13" r="12" stroke="black" stroke-width="" fill="<?php echo $couleur?>" />
	</svg>
<script>
	var nom;
	var averti;
	
	function activationRafraichissement (compte) {
	// Active le rafraichissement
	
		nom = compte; // Stock le nom du joueur connecté
		averti = false; // Met la variable à false pour que le joueur soit averti si c'est son tour
		afficherInformationsPartie(); // Lance la fonction d'affichage d'infos. de la partie
		rafraichissementAuto(); // Démarre la fonction de rafraichissement automatique
	}
	function rafraichissementAuto () {
	// Rafraichissement automatique par interval
	
		setInterval(function () { // Applique un interval de 0.5 secondes avant de relancer la fonction pour afficher les infos. de la partie
			afficherInformationsPartie();
		}, 500);
	}
	
	function rafraichirInfosParBouton () {
	// Rafraichit les informations quand le joueur appuie sur le bouton rafraichir
	
		averti = false; // Remet l'avertissement à false pour que le joueur se fasse avertir que c'est son tour
		afficherInformationsPartie ();
	}
	
	function afficherInformationsPartie () {
	// Affiche les informations de la partie et la liste des joueurs
		
		var requeteAjax;

		requeteAjax = new XMLHttpRequest();
		
		requeteAjax.onreadystatechange = function () {
		// S'active lorsque la requête change de statut
		
			if (requeteAjax.readyState==4 && requeteAjax.status==200) {
			// Si la requête est terminée et a reçu une réponse
			
				document.getElementById("listeInfosPartie").innerHTML = requeteAjax.responseText; // Incorpore la réponse dans la liste "listeInfosPartie"
				if (document.getElementById("joueurJouant").innerHTML == nom && averti == false) {
				// Si le nom du joueur connecté est le même que le nom du joueur à jouer et que l'avertissement n'a pas été fait
				
					alert("C'est à votre tour de jouer au Monopoly sur ce site avec votre compte usagé qui est présentement connecté à ce site qui est sur le localhost de cet ordinateur dans cette pièce de ce batîment de cette ville de ce pays de ce continent de cette planète de cet univers qui est égal à 42."); // Averti le joueur que c'est son tour
					averti = true; // Met la variable à true pour dire qu'il a été averti
				}
				else if (document.getElementById("joueurJouant").innerHTML != joueur.nom) {
				// Si le nom du joueur connecté n'est pas le même que le nom du joueur à jouer
				
					averti = false; // Remet l'avertissement à false pour que le joueur connecté soit averti à son tour
				}
			}
		}
		
		requeteAjax.open("GET", "informations_partie.php", true); // Ouvre le fichier php pour en extraire les informations
		requeteAjax.send(); // Envoi la requête
		
	}
</script>

<div id="sectionInfosPartie"> <!-- Div contenant les informations de la partie, et la liste des joueurs -->

	<button onclick="rafraichirInfosParBouton('<?php echo $compteUsager?>')" id="btnInfosPartie">Rafraichir</button>
	<ul id="listeInfosPartie">
	</ul>

</div>
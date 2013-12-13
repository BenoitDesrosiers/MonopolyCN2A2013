<?php
$idPartie = intval($_GET['idPartie']);

$db = new PDO('mysql:host=localhost;dbname=monopoly',
		'root',
		'',
		array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

$queryTxt = "SELECT u.Nom as Joueur, p.Nom as Pion, j.Position, a.Argent FROM joueurpartie j
LEFT JOIN pion p ON j.PionId = p.Id
LEFT JOIN usager u ON j.UsagerCompte = u.Compte
LEFT JOIN(
    SELECT JoueurPartieUsagerCompte,JoueurPartiePartieEnCoursId, sum(ArgentMontant*Quantite) as Argent from joueurpartie_argent
	GROUP BY JoueurPartieUsagerCompte, JoueurPartiePartieEnCoursId
) a on a.JoueurPartieUsagerCompte = j.UsagerCompte and a.JoueurPartiePartieEnCoursId = j.PartieEnCoursId
WHERE j.PartieEnCoursId = :id";
$query = $db->prepare($queryTxt);
$query->bindValue(':id', $idPartie);
$query->setFetchMode(PDO::FETCH_ASSOC);
$query->execute();

echo "<p>Detail des joueurs</p>
<table border='1'>
<tr>
<th>Joueur</th>
<th>Position</th>
<th>Pion</th>
<th>Argent</th>
</tr>";

foreach($query as $row) {
	echo "<tr>";
	echo "<td>" . $row['Joueur'] . "</td>";
	echo "<td>" . $row['Position'] . "</td>";
	echo "<td>" . $row['Pion'] . "</td>";
	echo "<td>" . $row['Argent'] . "</td>";
	echo "<tr>";
}
?>
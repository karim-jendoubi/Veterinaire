<?php
	// Initialiser la session
	session_start();
	// Définit la durée de validité du cookie de session à 3 jours
	$expiration = time() + (3 * 24 * 60 * 60); // temps en secondes
	session_set_cookie_params($expiration);
	// Vérifiez si l'utilisateur est connecté, sinon redirigez-le vers la page de connexion
	if(!isset($_SESSION["email"])){
		header("Location: ../connexion/connexion.php");
		exit(); 
	}
	require('../connexion/config.php');
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Accueil</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
	<header>
		<nav>
			<input id="menu-toggle" type="checkbox" />
    			<label class='menu-button-container' for="menu-toggle">
    			<article class='menu-button'></article>
    			</label>
			<ul class="menu">
				<li class="onglet">
					<a href="site.php">Liste fiche animal</a>
				</li>
			</ul>
		</nav>
		<a class="titre" href="site.php">
			Vétérinaire&co
		</a><a href="../connexion/deconnexion.php" classe="deco">
		<button>
			Déconnexion
		</button></a>
	</header><script>
    window.alert(message);
    </script>
		<?php
				$query = "SELECT t1.animal, t1.nom_profil, t1.timestamp, t1.poids, t1.frequence, t1.calories
		FROM `table_animaux` t1
		INNER JOIN (
		  SELECT nom_profil, MAX(timestamp) AS max_timestamp
		  FROM `table_animaux`
		  GROUP BY nom_profil
		) t2 ON t1.nom_profil = t2.nom_profil AND t1.timestamp = t2.max_timestamp";

		$result = mysqli_query($conn, $query);
		// Afficher les lignes du tableau en fonction de la réponse à la requête
		if ($result) {
		    echo '<table>';
		    echo "<tr><th>Race</th><th>Date</th><th>Nom</th><th>Poids</th><th>Fréquence</th><th>Calories</th><th>Plus d'infos</th></tr>";
		    if (mysqli_num_rows($result) > 0) {
			while ($row = mysqli_fetch_assoc($result)) {
			    // Conversion de la date au format jj/mm/aaaa
			    $date = date("d/m/Y", strtotime($row["timestamp"]));
			    $nom_profil = $row["nom_profil"];
			    $race = $row["animal"];
			    echo "<tr>";
			    echo "<td>" . $race . "</td>";
			    echo "<td>" . $date . "</td>";
			    echo "<td>" . $nom_profil . "</td>";
			    echo "<td>" . $row["poids"] . "KG </td>";
			    echo "<td>" . $row["frequence"] . " repas par jour</td>";
			    echo "<td>" . $row["calories"] . " kcal</td>";
			    echo "<td><a href='animal_details.php?nom_profil=" . urlencode($nom_profil) . "'>Voir les détails</a></td>";
			    echo "</tr>";
			}
		    }
		    echo '</table>';
		}
		?>
		<style>
		
		</style>
		
</body>
</html>

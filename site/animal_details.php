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
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Accueil</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment-with-locales.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/locale/fr.js"></script>
   
</head>
<body>
<script src="qrcode.js"></script>
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
	</header>
	<section class="fiche">
		<?php
		require('../connexion/config.php');

		// Vérifier si le paramètre 'nom_profil' a été transmis dans l'URL
		if (isset($_GET['nom_profil'])) {
		    // Échapper le paramètre pour éviter les injections SQL
		    $nom_profil = mysqli_real_escape_string($conn, $_GET['nom_profil']);

		    // Construire la requête pour récupérer toutes les données de l'animal spécifié
		    $query = "SELECT animal, nom_profil, timestamp, poids, frequence, calories
			      FROM `table_animaux`
			      WHERE nom_profil = '$nom_profil'
			      ORDER BY timestamp ASC";

		    $result = mysqli_query($conn, $query);

		    if ($result && mysqli_num_rows($result) > 0) {
			// Récupérer les données et les stocker dans des tableaux distincts
			$timestamps = array();
			$poidsData = array();
			$frequenceData = array();
			$caloriesData = array();

			while ($row = mysqli_fetch_assoc($result)) {
			    // Conversion de la date au format jj/mm/aaaa
			    $date = date("d/m/Y", strtotime($row["timestamp"]));
			    
			    $timestamps[] = $date;
			    $poidsData[] = $row["poids"];
			    $frequenceData[] = $row["frequence"];
			    $caloriesData[] = $row["calories"];
			    $race_animal = $row["animal"];
			}

			// Afficher les titres avec le nom, la race et les graphiques
			
			echo "<h3>Nom : $nom_profil</h3>";
			echo "<h3>Race : $race_animal</h3>";
			?>
			<img id="myImage" src="" alt="QR Code">
			<?php
			// Afficher les graphiques dans une ligne
			echo "<div style='display: flex; flex-wrap: wrap;'>";

			// Créer le graphique du poids
			echo "<div style='width: 31%; padding: 10px;'>";
			echo "<canvas id='poidsChart'></canvas>";
			echo "</div>";

			// Créer le graphique de la fréquence
			echo "<div style='width: 31%; padding: 10px;'>";
			echo "<canvas id='frequenceChart'></canvas>";
			echo "</div>";

			// Créer le graphique des calories
			echo "<div style='width: 31%; padding: 10px;'>";
			echo "<canvas id='caloriesChart'></canvas>";
			echo "</div>";

			echo "</div>";

			// JavaScript pour créer les graphiques
			echo "<script src='https://cdn.jsdelivr.net/npm/chart.js'></script>";
			echo "<script>";
			echo "var ctx1 = document.getElementById('poidsChart').getContext('2d');";
			echo "var ctx2 = document.getElementById('frequenceChart').getContext('2d');";
			echo "var ctx3 = document.getElementById('caloriesChart').getContext('2d');";

			// Reste du code pour créer les graphiques...
			 // Créer le graphique du poids
			echo "var poidsChart = new Chart(ctx1, {
			    type: 'line',
			    data: {
				labels: " . json_encode($timestamps) . ",
				datasets: [{
				    label: 'Poids (kg)',
				    data: " . json_encode($poidsData) . ",
				    borderColor: 'blue',
				    backgroundColor: 'transparent'
				}]
			    },
			    options: {
				responsive: true,
				scales: {
				    x: {
				        display: true,
				        title: {
				            display: true,
				            text: 'Temps'
				        }
				    },
				    y: {
				        display: true,
				        title: {
				            display: true,
				            text: 'Poids (kg)'
				        }
				    }
				}
			    }
			});

			var frequenceChart = new Chart(ctx2, {
			    type: 'line',
			    data: {
				labels: " . json_encode($timestamps) . ",
				datasets: [{
				    label: 'Fréquence',
				    data: " . json_encode($frequenceData) . ",
				    borderColor: 'green',
				    backgroundColor: 'transparent'
				}]
			    },
			    options: {
				responsive: true,
				scales: {
				    x: {
				        display: true,
				        title: {
				            display: true,
				            text: 'temps'
				        }
				    },
				    y: {
				        display: true,
				        title: {
				            display: true,
				            text: 'Fréquence'
				        }
				    }
				}
			    }
			});

			var caloriesChart = new Chart(ctx3, {
			    type: 'line',
			    data: {
				labels: " . json_encode($timestamps) . ",
				datasets: [{
				    label: 'Calories',
				    data: " . json_encode($caloriesData) . ",
				    borderColor: 'red',
				    backgroundColor: 'transparent'
				}]
			    },
			    options: {
				responsive: true,
				scales: {
				    x: {
				        display: true,
				        title: {
				            display: true,
				            text: 'temps'
				        }
				    },
				    y: {
				        display: true,
				        title: {
				            display: true,
				            text: 'Calories'
				        }
				    }
				}
			    }
			});
			</script>";

			echo "</script>";
		    } else {
			echo "Aucune donnée trouvée pour l'animal : $nom_profil";
		    }
		} else {
		    echo "Animal non spécifié.";
		}
		?>
	</section>
<form id="thresholdForm" method="post">
  <h3>Réglage des seuils :</h3>
  <label for="poidsMin">Poids (min) :</label>
  <input type="number" id="poidsMin" name="poidsMin" step="0.1">
  <label for="poidsMax">Poids (max) :</label>
  <input type="number" id="poidsMax" name="poidsMax" step="0.1">
  <br>
  <label for="frequenceMin">Fréquence (min) :</label>
  <input type="number" id="frequenceMin" name="frequenceMin" step="0.1">
  <label for="frequenceMax">Fréquence (max) :</label>
  <input type="number" id="frequenceMax" name="frequenceMax" step="0.1">
  <br>
  <label for="caloriesMin">Calories (min) :</label>
  <input type="number" id="caloriesMin" name="caloriesMin" step="0.1">
  <label for="caloriesMax">Calories (max) :</label>
  <input type="number" id="caloriesMax" name="caloriesMax" step="0.1">
  <br>
  <input type="submit" value="Enregistrer">
</form>
<script src="even.js" type="module"></script>
<script src="qrcodeee.js" type="module"></script>
<div id="calen">
    <div id="eventForm">
        <form method="post" action="">
            <input type="hidden" name="nom_profil" id="nom_profil" value="<?php echo $nom_profil; ?>"><br>

            <label for="eventName">Nom de l'événement :</label>
            <input type="text" name="eventName" id="eventName"><br>

            <label for="eventDate">Date et heure de l'événement :</label>
            <input type="datetime-local" name="eventDate" id="eventDate"><br>

            <button type="button" id="addEvent">Ajouter l'événement</button>
        </form>
    </div>
    <div id="calendar"></div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/locale/fr.js"></script>

<script>
    $(document).ready(function() {
        moment.locale('fr');

        var calendar = $('#calendar').fullCalendar({
            selectable: true,
            select: function(start, end) {
                $('#eventForm').show();
            }
        });

        $('#addEvent').click(function() {
            var eventName = $('#eventName').val();
            var eventDate = moment($('#eventDate').val()).toDate();

            if (eventName && eventDate) {
                calendar.fullCalendar('renderEvent', {
                    title: eventName,
                    start: eventDate,
                    allDay: false
                });

                resetForm();

                var timer = setInterval(function() {
                    var now = moment();
                    if (now.isSame(eventDate, 'minute')) {
                        clearInterval(timer);
                        window.alert('L\'événement "' + eventName + '" commence maintenant !');
                    }
                }, 1000 * 1);
            } else {
                alert('Veuillez remplir tous les champs.');
            }
        });

        function resetForm() {
            $('#eventName').val('');
            $('#eventDate').val('');
        }
    });
</script>

</div>
<style>
header{
    z-index:10;
}
#calen{
	width: 100%;
	height: 10%;
	z-index: 2;
	}
#addEvent{
	width: 210px;
	}
	</style>
</body>
</html>

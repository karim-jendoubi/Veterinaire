<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css" />
    <title>Liste fiche animal</title>
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
					<a href="entree.php">Suivie animal</a>
				</li>
				<li class="onglet">
					<a href="reserver.php">liste ficche animal</a>
				</li>
			</ul>
		</nav>
			<a class="titre" href="entree.php">
				AJ Transports
			</a>
		<?php
		if(!isset($_SESSION["email"])){?>
		<button>
			<a href="../connexion/connexion.php">Connexion</a>
		</button><?php	 
		} else{?>
			<button>
			<a href="../connexion/deconnexion.php" >déconnexion</a>
		</button><?php
		}
		?>
	</header>
</body>
</html>
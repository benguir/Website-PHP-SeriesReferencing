<?php
    session_start();  // démarrage d'une session
?>

<html>
	<head>
		<title>Submarine Serie</title>
		<link rel="icon" href="image/icon.png" type="icon.png" />
		<meta charset="utf-8" />
		<link rel="stylesheet" href="../css/maliste.css">
	</head>

	<?php
    if (isset($_SESSION['version'])) { 
        if ($_SESSION['version'] == 'VO'){ // Ouverture langue VO
	?>
    <body>
    	<nav class="nav_connect">
			<ul>
				<li><a href="../index.php">Home</a></li>
				<li><a href="maliste.php" style="border-bottom: 1px solid white;">My list</a></li>
				<ul class="align-droite">

				<li><a href="page/aide.php">?</a></li>
				<li class="dropdown">
					<a href=""><?php echo $_SESSION['identifiant']; ?> <span class="arrow">&#9662;</span></a>
					<ul class="dropdown-menu">                            
						<li><a href="compte.php">Account</a></li>
<?php
							if($_SESSION['is_admin'] == 1){	 // Admin
?>
								<li><a href="administration/administration.php">Administration</a></li>
<?php
							}
?>
						<li><a href="fonction/logout.php">Log off</a></li>
					</ul>
				</li>
				</ul>
			</ul>
		</nav>

		<script>
			function checkAll(source, className) {
				var checkboxes = document.getElementsByClassName(className);
				for (var i = 0; i < checkboxes.length; i++) {
					checkboxes[i].checked = source.checked;
				}
			}
		</script>
<?php
		// Connexion à la base de données
		$conn = mysqli_connect('localhost', 'root', '', 'submarineserieromain');

		// Exécution de la requête SQL
		$resultat1 = mysqli_query($conn, "SELECT id_series, nom, image FROM series WHERE id_series IN ( SELECT id_series FROM notes WHERE note = 1 and id_utilisateur = " . $_SESSION['id_utilisateur'] . ")");
		$resultat2 = mysqli_query($conn, "SELECT id_series, nom, image FROM series WHERE id_series IN ( SELECT id_series FROM notes WHERE note = 2 and id_utilisateur = " . $_SESSION['id_utilisateur'] . ")");
		$resultat3 = mysqli_query($conn, "SELECT id_series, nom, image FROM series WHERE id_series IN ( SELECT id_series FROM notes WHERE note = 3 and id_utilisateur = " . $_SESSION['id_utilisateur'] . ")");
		$resultat4 = mysqli_query($conn, "SELECT id_series, nom, image FROM series WHERE id_series IN ( SELECT id_series FROM notes WHERE note = 4 and id_utilisateur = " . $_SESSION['id_utilisateur'] . ")");
		$resultat5 = mysqli_query($conn, "SELECT id_series, nom, image FROM series WHERE id_series IN ( SELECT id_series FROM notes WHERE note = 5 and id_utilisateur = " . $_SESSION['id_utilisateur'] . ")");
		// Affichage des résultats
?>				
		<form method="POST" action="fonction/supprimer_serie.php">
<?php
			// 1 étoile
			if (mysqli_num_rows($resultat1) > 0) {
				echo '<div class="one-star">';
					echo '<class ="1 etoile"> ★☆☆☆☆ </br>';
					while ($ligne = mysqli_fetch_assoc($resultat1)) {
						echo '<div class="serie-item">';
							echo '<div class="serie-image-container">';
								echo '<img src="' . $ligne['image'] . '" alt="Image" class="serie-image">';
								echo '<div class="star-container">';
									echo '<input type="checkbox" class="delete-checkbox-1" name="id_series[]" value="' . $ligne['id_series'] . '">';
									echo '<a href="javascript:void(0);" style="text-decoration: none; color: inherit;" onclick="edit_note(' . $ligne['id_series'] . ');">✎</a> <br/>';
								echo '</div>';
							echo '</div>';
							echo $ligne['nom'];
						echo '</div>';
					}
				echo '</div>';
			}

		// 2 étoiles
			if (mysqli_num_rows($resultat2) > 0) {
				echo '<div class="two-star">';
					echo '<class ="2 etoiles"> ★★☆☆☆ </br>';
					while ($ligne = mysqli_fetch_assoc($resultat2)) {
						echo '<div class="serie-item">';
							echo '<div class="serie-image-container">';
								echo '<img src="' . $ligne['image'] . '" alt="Image" class="serie-image">';
								echo '<div class="star-container">';
									echo '<input type="checkbox" class="delete-checkbox-1" name="id_series[]" value="' . $ligne['id_series'] . '">';
									echo '<a href="javascript:void(0);" style="text-decoration: none; color: inherit;" onclick="edit_note(' . $ligne['id_series'] . ');">✎</a> <br/>';
								echo '</div>';
							echo '</div>';
							echo $ligne['nom'];
						echo '</div>';
					}
				echo '</div>';
			}

		// 3 étoiles
			if (mysqli_num_rows($resultat3) > 0) {
				echo '<div class="three-star">';
					echo '<class ="3 etoiles"> ★★★☆☆ </br>';
					while ($ligne = mysqli_fetch_assoc($resultat3)) {
						echo '<div class="serie-item">';
							echo '<div class="serie-image-container">';
								echo '<img src="' . $ligne['image'] . '" alt="Image" class="serie-image">';
								echo '<div class="star-container">';
									echo '<input type="checkbox" class="delete-checkbox-1" name="id_series[]" value="' . $ligne['id_series'] . '">';
									echo '<a href="javascript:void(0);" style="text-decoration: none; color: inherit;" onclick="edit_note(' . $ligne['id_series'] . ');">✎</a> <br/>';
								echo '</div>';
							echo '</div>';
							echo $ligne['nom'];
						echo '</div>';
					}
				echo '</div>';
			}

		// 4 étoiles
			if (mysqli_num_rows($resultat4) > 0) {
				echo '<div class="four-star">';
					echo '<class ="4 etoiles"> ★★★★☆ </br>';
					while ($ligne = mysqli_fetch_assoc($resultat4)) {
						echo '<div class="serie-item">';
							echo '<div class="serie-image-container">';
								echo '<img src="' . $ligne['image'] . '" alt="Image" class="serie-image">';
								echo '<div class="star-container">';
									echo '<input type="checkbox" class="delete-checkbox-1" name="id_series[]" value="' . $ligne['id_series'] . '">';
									echo '<a href="javascript:void(0);" style="text-decoration: none; color: inherit;" onclick="edit_note(' . $ligne['id_series'] . ');">✎</a> <br/>';
								echo '</div>';
							echo '</div>';
							echo $ligne['nom'];
						echo '</div>';
					}
				echo '</div>';
			}

		// 5 étoiles
			if (mysqli_num_rows($resultat5) > 0) {
				echo '<div class="five-star">';
					echo '<class ="5 etoiles"> ★★★★★ </br>';
					while ($ligne = mysqli_fetch_assoc($resultat5)) {
						echo '<div class="serie-item">';
							echo '<div class="serie-image-container">';
								echo '<img src="' . $ligne['image'] . '" alt="Image" class="serie-image">';
								echo '<div class="star-container">';
									echo '<input type="checkbox" class="delete-checkbox-1" name="id_series[]" value="' . $ligne['id_series'] . '">';
									echo '<a href="javascript:void(0);" style="text-decoration: none; color: inherit;" onclick="edit_note(' . $ligne['id_series'] . ');">✎</a> <br/>';
								echo '</div>';
							echo '</div>';
							echo $ligne['nom'];
						echo '</div>';
					}
				echo '</div>';
			}

			echo '<div>';
				echo '<div class="select_allseries">';
					if (mysqli_num_rows($resultat1) > 0 || mysqli_num_rows($resultat2) > 0 || mysqli_num_rows($resultat3) > 0 || mysqli_num_rows($resultat4) > 0 ||mysqli_num_rows($resultat5) > 0) {
						echo '<div class="mini-bande"></div>';
							echo '<tr><td><input class="submit_tout" type="checkbox" id="check-all-1" onclick="checkAll(this, \'delete-checkbox-1\')"></td><td> Check all</td></tr></br>';
							echo '<input class="submit_supprimer" type="submit" name="supprimer" value="Delete">';
						echo '</div>';
					}
				echo '</div>';	
			echo '</div>';	
					
?>	
		<script>
		function edit_note(id_serie) {
			var edit_note = prompt('Change your series grade (from 1 to 5):');
		
			if (edit_note && !isNaN(edit_note) && edit_note >= 1 && edit_note <= 5) {
				var etoiles = '';
				for (var i = 1; i <= 5; i++) {
					if (i <= edit_note) {
						etoiles += '★ ';
					} else {
						etoiles += '☆ ';
					}
				}
			
				var url = "fonction/edit_note.php?new_note=" + edit_note + "&valider=Envoyer&id_serie=" + id_serie;
				window.open(url, "_self");
			} else {
				alert('Please enter a rating (from 1 to 5).');
			}
		}
		</script>
<?php
		} // Fermeture langue V0
		
		else {
			?>
			<body>
				<nav class="nav_connect">
					<ul>
						<li><a href="../index.php">Accueil</a></li>
						<li><a href="maliste.php" style="border-bottom: 1px solid white;">Ma Liste</a></li>
						<ul class="align-droite">
		
						<li><a href="page/aide.php">?</a></li>
						<li class="dropdown">
							<a href=""><?php echo $_SESSION['identifiant']; ?> <span class="arrow">&#9662;</span></a>
							<ul class="dropdown-menu">                            
								<li><a href="compte.php">Mon compte</a></li>
		<?php
									if($_SESSION['is_admin'] == 1){	 // Admin
		?>
										<li><a href="administration/administration.php">Administration</a></li>
		<?php
									}
		?>
								<li><a href="fonction/logout.php">Deconnexion</a></li>
							</ul>
						</li>
						</ul>
					</ul>
				</nav>
		
				<script>
					function checkAll(source, className) {
						var checkboxes = document.getElementsByClassName(className);
						for (var i = 0; i < checkboxes.length; i++) {
							checkboxes[i].checked = source.checked;
						}
					}
				</script>
		<?php
				// Connexion à la base de données
				$conn = mysqli_connect('localhost', 'root', '', 'submarineserieromain');
		
				// Exécution de la requête SQL
				$resultat1 = mysqli_query($conn, "SELECT id_series, nom, image FROM series WHERE id_series IN ( SELECT id_series FROM notes WHERE note = 1 and id_utilisateur = " . $_SESSION['id_utilisateur'] . ")");
				$resultat2 = mysqli_query($conn, "SELECT id_series, nom, image FROM series WHERE id_series IN ( SELECT id_series FROM notes WHERE note = 2 and id_utilisateur = " . $_SESSION['id_utilisateur'] . ")");
				$resultat3 = mysqli_query($conn, "SELECT id_series, nom, image FROM series WHERE id_series IN ( SELECT id_series FROM notes WHERE note = 3 and id_utilisateur = " . $_SESSION['id_utilisateur'] . ")");
				$resultat4 = mysqli_query($conn, "SELECT id_series, nom, image FROM series WHERE id_series IN ( SELECT id_series FROM notes WHERE note = 4 and id_utilisateur = " . $_SESSION['id_utilisateur'] . ")");
				$resultat5 = mysqli_query($conn, "SELECT id_series, nom, image FROM series WHERE id_series IN ( SELECT id_series FROM notes WHERE note = 5 and id_utilisateur = " . $_SESSION['id_utilisateur'] . ")");
				// Affichage des résultats
		?>				
				<form method="POST" action="fonction/supprimer_serie.php">
		<?php
					// 1 étoile
					if (mysqli_num_rows($resultat1) > 0) {
						echo '<div class="one-star">';
							echo '<class ="1 etoile"> ★☆☆☆☆ </br>';
							while ($ligne = mysqli_fetch_assoc($resultat1)) {
								echo '<div class="serie-item">';
									echo '<div class="serie-image-container">';
										echo '<img src="' . $ligne['image'] . '" alt="Image" class="serie-image">';
										echo '<div class="star-container">';
											echo '<input type="checkbox" class="delete-checkbox-1" name="id_series[]" value="' . $ligne['id_series'] . '">';
											echo '<a href="javascript:void(0);" style="text-decoration: none; color: inherit;" onclick="edit_note(' . $ligne['id_series'] . ');">✎</a> <br/>';
										echo '</div>';
									echo '</div>';
									echo $ligne['nom'];
								echo '</div>';
							}
						echo '</div>';
					}
		
				// 2 étoiles
					if (mysqli_num_rows($resultat2) > 0) {
						echo '<div class="two-star">';
							echo '<class ="2 etoiles"> ★★☆☆☆ </br>';
							while ($ligne = mysqli_fetch_assoc($resultat2)) {
								echo '<div class="serie-item">';
									echo '<div class="serie-image-container">';
										echo '<img src="' . $ligne['image'] . '" alt="Image" class="serie-image">';
										echo '<div class="star-container">';
											echo '<input type="checkbox" class="delete-checkbox-1" name="id_series[]" value="' . $ligne['id_series'] . '">';
											echo '<a href="javascript:void(0);" style="text-decoration: none; color: inherit;" onclick="edit_note(' . $ligne['id_series'] . ');">✎</a> <br/>';
										echo '</div>';
									echo '</div>';
									echo $ligne['nom'];
								echo '</div>';
							}
						echo '</div>';
					}
		
				// 3 étoiles
					if (mysqli_num_rows($resultat3) > 0) {
						echo '<div class="three-star">';
							echo '<class ="3 etoiles"> ★★★☆☆ </br>';
							while ($ligne = mysqli_fetch_assoc($resultat3)) {
								echo '<div class="serie-item">';
									echo '<div class="serie-image-container">';
										echo '<img src="' . $ligne['image'] . '" alt="Image" class="serie-image">';
										echo '<div class="star-container">';
											echo '<input type="checkbox" class="delete-checkbox-1" name="id_series[]" value="' . $ligne['id_series'] . '">';
											echo '<a href="javascript:void(0);" style="text-decoration: none; color: inherit;" onclick="edit_note(' . $ligne['id_series'] . ');">✎</a> <br/>';
										echo '</div>';
									echo '</div>';
									echo $ligne['nom'];
								echo '</div>';
							}
						echo '</div>';
					}
		
				// 4 étoiles
					if (mysqli_num_rows($resultat4) > 0) {
						echo '<div class="four-star">';
							echo '<class ="4 etoiles"> ★★★★☆ </br>';
							while ($ligne = mysqli_fetch_assoc($resultat4)) {
								echo '<div class="serie-item">';
									echo '<div class="serie-image-container">';
										echo '<img src="' . $ligne['image'] . '" alt="Image" class="serie-image">';
										echo '<div class="star-container">';
											echo '<input type="checkbox" class="delete-checkbox-1" name="id_series[]" value="' . $ligne['id_series'] . '">';
											echo '<a href="javascript:void(0);" style="text-decoration: none; color: inherit;" onclick="edit_note(' . $ligne['id_series'] . ');">✎</a> <br/>';
										echo '</div>';
									echo '</div>';
									echo $ligne['nom'];
								echo '</div>';
							}
						echo '</div>';
					}
		
				// 5 étoiles
					if (mysqli_num_rows($resultat5) > 0) {
						echo '<div class="five-star">';
							echo '<class ="5 etoiles"> ★★★★★ </br>';
							while ($ligne = mysqli_fetch_assoc($resultat5)) {
								echo '<div class="serie-item">';
									echo '<div class="serie-image-container">';
										echo '<img src="' . $ligne['image'] . '" alt="Image" class="serie-image">';
										echo '<div class="star-container">';
											echo '<input type="checkbox" class="delete-checkbox-1" name="id_series[]" value="' . $ligne['id_series'] . '">';
											echo '<a href="javascript:void(0);" style="text-decoration: none; color: inherit;" onclick="edit_note(' . $ligne['id_series'] . ');">✎</a> <br/>';
										echo '</div>';
									echo '</div>';
									echo $ligne['nom'];
								echo '</div>';
							}
						echo '</div>';
					}
		
					echo '<div>';
						echo '<div class="select_allseries">';
							if (mysqli_num_rows($resultat1) > 0 || mysqli_num_rows($resultat2) > 0 || mysqli_num_rows($resultat3) > 0 || mysqli_num_rows($resultat4) > 0 ||mysqli_num_rows($resultat5) > 0) {
								echo '<div class="mini-bande"></div>';
									echo '<tr><td><input class="submit_tout" type="checkbox" id="check-all-1" onclick="checkAll(this, \'delete-checkbox-1\')"></td><td> Tout cocher</td></tr></br>';
									echo '<input class="submit_supprimer" type="submit" name="supprimer" value="Supprimer">';
								echo '</div>';
							}
						echo '</div>';	
					echo '</div>';	
							
?>
		<script>
		function edit_note(id_serie) {
			var edit_note = prompt('Modifier votre note de la série (de 1 et 5):');
		
			if (edit_note && !isNaN(edit_note) && edit_note >= 1 && edit_note <= 5) {
				var etoiles = '';
				for (var i = 1; i <= 5; i++) {
					if (i <= edit_note) {
						etoiles += '★ ';
					} else {
						etoiles += '☆ ';
					}
				}
			
				var url = "fonction/edit_note.php?new_note=" + edit_note + "&valider=Envoyer&id_serie=" + id_serie;
				window.open(url, "_self");
			} else {
				alert('Veuillez entrer une note (de 1 à 5).');
			}
		}
		</script>
<?php
		} // Fermeture langue VF
	} // Fermeture isset langue
?>
		</form>
	
		<script>
			function toggleCheckboxes(select, className) {
				var checkboxes = document.getElementsByClassName(className);
				var action = select.value;
				for (var i = 0; i < checkboxes.length; i++) {
					if (action === 'check') {
						checkboxes[i].checked = true;
					} 
					else if (action === 'uncheck') {
						checkboxes[i].checked = false;
					}
				}
			}

			function submitForm() {
				document.querySelector('form').submit();
			}


		</script>
		
    </body>
</html>





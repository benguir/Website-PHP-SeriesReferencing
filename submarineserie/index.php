<?php
		session_start();  // démarrage d'une session
	?>

<html>
	<body>
<?php		
	if (!isset($_SESSION['identifiant'])) { // Ouverture Aucune connexion
			if (!isset($_GET['recherche'])) { // Ouverture !recherche
				?>
				
								<head>
									<title>Submarine Serie</title>
									<link rel="icon" href="css/image/icon.png" type="icon.png" />
									<meta charset="utf-8" />
									<link rel="stylesheet" href="css/index.css">
				
				
								</head>
				
								<nav class="nav_">
									<ul>
										<li class="nav_accueil"><a href="index.php" style="border-bottom: 1px solid white;">Accueil</a></li>
										<ul class="align-droite">
										<li><a href="page/aide.php">?</a></li>
										<li class="dropdown">
											<a class="nav_profil" href="">Compte <span class="arrow">&#9662;</span></a>
											<ul class="dropdown-menu">
												<li><a href="page/fonction/connexion_user.php">Connexion</a></li>
												<li><a href="page/fonction/inscription_user.php">Inscription</a></li>
											</ul>
										</li>
										</ul>
									</ul>
									</nav>
				
								<img class = "logo" src="css/image/logo.png"> 
									
								<form id ="recherche" action="index.php" method="GET">
									</br> 
									<input class="input_recherche" type="text" placeholder="Rechercher une série" name="recherche" size="80" maxlength="30"/>
									<span class="clear-icon" onclick="effacerContenu()">❌</span>
									<span class="clear-icon" onclick="validerContenu()">🔍</span>
								</form>
				
				<?php
							} // Fermeture !recherche
							
							if (isset($_GET['recherche'])) { // Ouverture Si recherche
				?>
				
								<head>
									<title>Submarine Serie</title>
									<link rel="icon" href="css/image/icon.png" type="icon.png" />
									<meta charset="utf-8" />
									<link rel="stylesheet" href="css/index_recherche.css">
								</head>
				
								<nav class="nav_">
									<ul>
										<li class="nav_accueil"><a href="index.php" style="border-bottom: 1px solid white;">Accueil</a></li>
										<ul class="align-droite">
										<li><a href="page/aide.php">?</a></li>
										<li class="dropdown">
											<a class="nav_profil" href="">Compte <span class="arrow">&#9662;</span></a>
											<ul class="dropdown-menu">
												<li><a href="page/fonction/connexion_user.php">Connexion</a></li>
												<li><a href="page/fonction/inscription_user.php">Inscription</a></li>
											</ul>
										</li>
										</ul>
									</ul>
									</nav>
				
								<div class="container">								
									<a href ="index.php"><img class = "logo" src="css/image/logo.png" ></a> 
									
									<form id="recherche" action="index.php" method="GET">
										</br> 
										<input class="input_recherche" type="text" value= "<?php echo $_GET['recherche'] ?>" name="recherche" size="80" maxlength="30" >
										<span class="clear-icon" onclick="effacerContenu()">❌</span>
										<span class="clear-icon" onclick="validerContenu()">🔍</span>
									</form>	
								</div>	
				
								<div class="mini-bande"></div>	
				
				<?php // Requête SQL
								$recherche = $_GET['recherche'];
								$conn = mysqli_connect('localhost', 'root', '', 'submarineserieromain');
								$sql = "SELECT distinct s.nom, s.id_series, s.image
											FROM series s LEFT JOIN cles c ON s.id_series = c.id_series
												WHERE (s.nom LIKE '" . $recherche . "%' OR c.mot_cle LIKE '" . $recherche . "%') 
													ORDER BY s.nom = '" . $recherche . "%' DESC, c.frequence DESC";
								
								$sql_count = "SELECT COUNT(DISTINCT s.nom) AS total_count
												FROM series s LEFT JOIN cles c ON s.id_series = c.id_series
													WHERE (s.nom LIKE '" . $recherche . "%' OR c.mot_cle LIKE '" . $recherche . "%')
														ORDER BY s.nom = '" . $recherche . "%' DESC, c.frequence DESC";
				
								$result = mysqli_query($conn, $sql);
								$result_count = mysqli_query($conn, $sql_count);
				
				?> <!-- Requête SQL -->
				
				<?php
								while ($ligne = mysqli_fetch_assoc($result_count)) { // Ouverture nombres de résultats
									echo '<span class="count_series">' . $ligne['total_count'] . ' résultats</span>'; 
								} // Fermeture nombres de résultats
				?>	
				
				<?php
								if (mysqli_num_rows($result) > 0) { // Ouverture affichage séries
				?>
								<div class="serie-grid">
									<form method="post" action="page/fonction/ajouter_note.php<?php if(isset($_GET['recherche'])) echo '?recherche=' . $_GET['recherche']; ?>"id="form_notes">
				<?php
				
										if (mysqli_num_rows($result) > 0) {
											echo '<ul class="serie-list">';
											while ($ligne = mysqli_fetch_assoc($result)) {
												$id_serie = $ligne['id_series'];
												$image = $ligne['image'];
												$nom = $ligne['nom'];
												echo '<li class="serie-item">';
													echo '<div class="serie-image-container">';
														echo '<img src="' . $image . '" alt="Image" class="serie-image">';
														echo '<div class="star-container">';
													
													echo $nom;
													echo '</div>';
													echo '</div>';
												echo '</li>';
											}
											echo '</ul>';
										} 
										else {
											echo 'Aucun résultat';
										}	
				?>		
									</form>
				<?php
								} // Fermeture affichage séries
				?>
				
				<?php
							} // Fermeture Si recherche
				?>
<?php
		} // Fermeture Aucune connexion
?>
<?php
	if (isset($_SESSION['version'])) { 
		if ($_SESSION['version'] == 'VO'){
?>
			

<?php
		if (isset($_SESSION['identifiant'])) { // Ouverture Connexion autorisée
			if (!isset($_GET['recherche'])) { // Ouverture !recherche
?>

				<head>
					<title>Submarine Serie</title>
					<link rel="icon" href="css/image/icon.png" type="icon.png" />
					<meta charset="utf-8" />
					<link rel="stylesheet" href="css/index.css">


				</head>

				<nav class="nav_connect">
					<ul>
						<li><a href="index.php" style="border-bottom: 1px solid white;">Home</a></li>
						<li><a href="page/maliste.php">My list</a></li>
						<ul class="align-droite">
						<li><a href="page/aide.php">?</a></li>
							<li class="dropdown">
								<a href=""><?php echo $_SESSION['identifiant']; ?> <span class="arrow">&#9662;</span></a>
									<ul class="dropdown-menu">
										<li><a href="page/compte.php">Account</a></li>
	<?php
											if ($_SESSION['is_admin'] == 1) {	 // Admin
	?>
												<li><a href="page/administration/administration.php">Administration</a></li>
	<?php
											}
	?>
										<li><a href="page/fonction/logout.php">Log off</a></li>
									</ul>
							</li>
						</ul>
					</ul>
				</nav>

				<img class = "logo" src="css/image/logo.png"> 
					
				<form id ="recherche" action="index.php" method="GET">
					</br> 
					<input class="input_recherche" type="text" placeholder="Search for a series or a keyword" name="recherche" size="80" maxlength="30"/>
					<span class="clear-icon" onclick="effacerContenu()">❌</span>
					<span class="clear-icon" onclick="validerContenu()">🔍</span>
				</form>

<?php
			} // Fermeture !recherche
			
			if (isset($_GET['recherche'])) { // Ouverture Si recherche
?>

				<head>
					<title>Submarine Serie</title>
					<link rel="icon" href="css/image/icon.png" type="icon.png" />
					<meta charset="utf-8" />
					<link rel="stylesheet" href="css/index_recherche.css">
				</head>

				<nav class="nav_connect">
					<ul>
						<li><a href="index.php" style="border-bottom: 1px solid white;">Home</a></li>
						<li><a href="page/maliste.php">My list</a></li>
						<ul class="align-droite">
						<li><a href="page/aide.php">?</a></li>
						<li class="dropdown">
							<a href=""><?php echo $_SESSION['identifiant']; ?> <span class="arrow">&#9662;</span></a>
								<ul class="dropdown-menu">
									<li><a href="page/compte.php">Account</a></li>
<?php
										if ($_SESSION['is_admin'] == 1) {	 // Admin
?>
											<li><a href="page/administration/administration.php">Administration</a></li>
<?php
										}
?>
									<li><a href="page/fonction/logout.php">Log off</a></li>
								</ul>
						</li>
						</ul>
						
					</ul>
				</nav>

				<div class="container">								
					<a href ="index.php"><img class = "logo" src="css/image/logo.png" ></a> 
					
					<form id="recherche" action="index.php" method="GET">
						</br> 
						<input class="input_recherche" type="text" value= "<?php echo $_GET['recherche'] ?>" name="recherche" size="80" maxlength="30" >
						<span class="clear-icon" onclick="effacerContenu()">❌</span>
						<span class="clear-icon" onclick="validerContenu()">🔍</span>
					</form>	
				</div>	

				<div class="mini-bande"></div>	

<?php // Requête SQL
				$recherche = $_GET['recherche'];
				$conn = mysqli_connect('localhost', 'root', '', 'submarineserieromain');
				$sql = "SELECT distinct s.nom, s.id_series, s.image
							FROM series s LEFT JOIN cles c ON s.id_series = c.id_series
								WHERE (s.nom LIKE '" . $recherche . "%' OR c.mot_cle LIKE '" . $recherche . "%') 
								AND s.id_series NOT IN (SELECT id_series FROM notes WHERE id_utilisateur = '" . $_SESSION['id_utilisateur'] . "')
									ORDER BY s.nom = '" . $recherche . "%' DESC, c.frequence DESC";
				
				$sql_count = "SELECT COUNT(DISTINCT s.nom) AS total_count
								FROM series s LEFT JOIN cles c ON s.id_series = c.id_series
									WHERE (s.nom LIKE '" . $recherche . "%' OR c.mot_cle LIKE '" . $recherche . "%')
									AND s.id_series NOT IN (SELECT id_series FROM notes WHERE id_utilisateur = '" . $_SESSION['id_utilisateur'] . "')
										ORDER BY s.nom = '" . $recherche . "%' DESC, c.frequence DESC";

				$result = mysqli_query($conn, $sql);
				$result_count = mysqli_query($conn, $sql_count);

?> <!-- Requête SQL -->

<?php
				while ($ligne = mysqli_fetch_assoc($result_count)) { // Ouverture nombres de résultats
					echo '<span class="count_series">' . $ligne['total_count'] . ' results</span>'; 
				} // Fermeture nombres de résultats
?>	

<?php
				if (mysqli_num_rows($result) > 0) { // Ouverture affichage séries
?>
				<div class="serie-grid">
					<form method="post" action="page/fonction/ajouter_note.php<?php if(isset($_GET['recherche'])) echo '?recherche=' . $_GET['recherche']; ?>"id="form_notes">
<?php

						if (mysqli_num_rows($result) > 0) {
							echo '<ul class="serie-list">';
							while ($ligne = mysqli_fetch_assoc($result)) {
								$id_serie = $ligne['id_series'];
								$image = $ligne['image'];
								$nom = $ligne['nom'];
								echo '<li class="serie-item">';
									echo '<div class="serie-image-container">';
										echo '<img src="' . $image . '" alt="Image" class="serie-image">';
										echo '<div class="star-container">';
											echo '<input type="hidden" name="id_series[]" value="' . $id_serie . '">';
											echo '<input type="hidden" name="note[]" id="note_' . $id_serie . '" value="">';
												echo '<span class="star" data-value="1" data-id="' . $id_serie . '">&#9734;</span>';
												echo '<span class="star" data-value="2" data-id="' . $id_serie . '">&#9734;</span>';
												echo '<span class="star" data-value="3" data-id="' . $id_serie . '">&#9734;</span>';
												echo '<span class="star" data-value="4" data-id="' . $id_serie . '">&#9734;</span>';
												echo '<span class="star" data-value="5" data-id="' . $id_serie . '">&#9734;</span>';
										echo '</div>';
									echo '</div>';
									echo $nom;
								echo '</li>';
							}
							echo '</ul>';
							echo '<input class="recherche_submit"type="submit" value="Send notes">';
						} 
						else {
							echo 'No results';
						}	
?>		
					</form>
<?php
				} // Fermeture affichage séries
?>

<?php
			} // Fermeture Si recherche
?>

<?php
		} // Fermeture Connexion autorisée
?>

<?php
		}
	 // Fermeture langue VO 

	// Ouverture langue VF
	else {
?>
		

<?php
		if (isset($_SESSION['identifiant'])) { // Ouverture Connexion autorisée
			if (!isset($_GET['recherche'])) { // Ouverture !recherche
?>

				<head>
					<title>Submarine Serie</title>
					<link rel="icon" href="css/image/icon.png" type="icon.png" />
					<meta charset="utf-8" />
					<link rel="stylesheet" href="css/index.css">


				</head>

				<nav class="nav_connect">
					<ul>
						<li><a href="index.php" style="border-bottom: 1px solid white;">Accueil</a></li>
						<li><a href="page/maliste.php">Ma Liste</a></li>
						<ul class="align-droite">
						<li><a href="page/aide.php">?</a></li>
							<li class="dropdown">
								<a href=""><?php echo $_SESSION['identifiant']; ?> <span class="arrow">&#9662;</span></a>
									<ul class="dropdown-menu">
										<li><a href="page/compte.php">Mon compte</a></li>
	<?php
											if ($_SESSION['is_admin'] == 1) {	 // Admin
	?>
												<li><a href="page/administration/administration.php">Administration</a></li>
	<?php
											}
	?>
										<li><a href="page/fonction/logout.php">Deconnexion</a></li>
									</ul>
							</li>
						</ul>
					</ul>
				</nav>

				<img class = "logo" src="css/image/logo.png"> 
					
				<form id ="recherche" action="index.php" method="GET">
					</br> 
					<input class="input_recherche" type="text" placeholder="Rechercher une série" name="recherche" size="80" maxlength="30"/>
					<span class="clear-icon" onclick="effacerContenu()">❌</span>
					<span class="clear-icon" onclick="validerContenu()">🔍</span>
				</form>

<?php
			} // Fermeture !recherche
			
			if (isset($_GET['recherche'])) { // Ouverture Si recherche
?>

				<head>
					<title>Submarine Serie</title>
					<link rel="icon" href="css/image/icon.png" type="icon.png" />
					<meta charset="utf-8" />
					<link rel="stylesheet" href="css/index_recherche.css">
				</head>

				<nav class="nav_connect">
					<ul>
						<li><a href="index.php" style="border-bottom: 1px solid white;">Accueil</a></li>
						<li><a href="page/maliste.php">Ma Liste</a></li>
						<ul class="align-droite">
						<li><a href="page/aide.php">?</a></li>
						<li class="dropdown">
							<a href=""><?php echo $_SESSION['identifiant']; ?> <span class="arrow">&#9662;</span></a>
								<ul class="dropdown-menu">
									<li><a href="page/compte.php">Mon compte</a></li>
<?php
										if ($_SESSION['is_admin'] == 1) {	 // Admin
?>
											<li><a href="page/administration/administration.php">Administration</a></li>
<?php
										}
?>
									<li><a href="page/fonction/logout.php">Deconnexion</a></li>
								</ul>
						</li>
						</ul>
						
					</ul>
				</nav>

				<div class="container">								
					<a href ="index.php"><img class = "logo" src="css/image/logo.png" ></a> 
					
					<form id="recherche" action="index.php" method="GET">
						</br> 
						<input class="input_recherche" type="text" value= "<?php echo $_GET['recherche'] ?>" name="recherche" size="80" maxlength="30" >
						<span class="clear-icon" onclick="effacerContenu()">❌</span>
						<span class="clear-icon" onclick="validerContenu()">🔍</span>
					</form>	
				</div>	

				<div class="mini-bande"></div>	

<?php // Requête SQL
				$recherche = $_GET['recherche'];
				$conn = mysqli_connect('localhost', 'root', '', 'submarineserieromain');
				$sql = "SELECT distinct s.nom, s.id_series, s.image
							FROM series s LEFT JOIN cles c ON s.id_series = c.id_series
								WHERE (s.nom LIKE '" . $recherche . "%' OR c.mot_cle LIKE '" . $recherche . "%') 
								AND s.id_series NOT IN (SELECT id_series FROM notes WHERE id_utilisateur = '" . $_SESSION['id_utilisateur'] . "')
									ORDER BY s.nom = '" . $recherche . "%' DESC, c.frequence DESC";
				
				$sql_count = "SELECT COUNT(DISTINCT s.nom) AS total_count
								FROM series s LEFT JOIN cles c ON s.id_series = c.id_series
									WHERE (s.nom LIKE '" . $recherche . "%' OR c.mot_cle LIKE '" . $recherche . "%')
									AND s.id_series NOT IN (SELECT id_series FROM notes WHERE id_utilisateur = '" . $_SESSION['id_utilisateur'] . "')
										ORDER BY s.nom = '" . $recherche . "%' DESC, c.frequence DESC";

				$result = mysqli_query($conn, $sql);
				$result_count = mysqli_query($conn, $sql_count);

?> <!-- Requête SQL -->

<?php
				while ($ligne = mysqli_fetch_assoc($result_count)) { // Ouverture nombres de résultats
					echo '<span class="count_series">' . $ligne['total_count'] . ' résultats</span>'; 
				} // Fermeture nombres de résultats
?>	

<?php
				if (mysqli_num_rows($result) > 0) { // Ouverture affichage séries
?>
				<div class="serie-grid">
					<form method="post" action="page/fonction/ajouter_note.php<?php if(isset($_GET['recherche'])) echo '?recherche=' . $_GET['recherche']; ?>"id="form_notes">
<?php

						if (mysqli_num_rows($result) > 0) {
							echo '<ul class="serie-list">';
							while ($ligne = mysqli_fetch_assoc($result)) {
								$id_serie = $ligne['id_series'];
								$image = $ligne['image'];
								$nom = $ligne['nom'];
								echo '<li class="serie-item">';
									echo '<div class="serie-image-container">';
										echo '<img src="' . $image . '" alt="Image" class="serie-image">';
										echo '<div class="star-container">';
											echo '<input type="hidden" name="id_series[]" value="' . $id_serie . '">';
											echo '<input type="hidden" name="note[]" id="note_' . $id_serie . '" value="">';
												echo '<span class="star" data-value="1" data-id="' . $id_serie . '">&#9734;</span>';
												echo '<span class="star" data-value="2" data-id="' . $id_serie . '">&#9734;</span>';
												echo '<span class="star" data-value="3" data-id="' . $id_serie . '">&#9734;</span>';
												echo '<span class="star" data-value="4" data-id="' . $id_serie . '">&#9734;</span>';
												echo '<span class="star" data-value="5" data-id="' . $id_serie . '">&#9734;</span>';
										echo '</div>';
									echo '</div>';
									echo $nom;
								echo '</li>';
							}
							echo '</ul>';
							echo '<input class="recherche_submit"type="submit" value="Envoyer les notes">';
						} 
						else {
							echo 'Aucun résultat';
						}	
?>		
					</form>
<?php
				} // Fermeture affichage séries
?>

<?php
			} // Fermeture Si recherche
?>

<?php
		} // Fermeture Connexion autorisée
	} // Fermeture langue VF
} // Fermeture isset langue
?>		
	


		<script> // Notation en étoiles
			var stars = document.querySelectorAll('.star');

			stars.forEach(function(star) {
				star.addEventListener('click', function() {
					var id = this.getAttribute('data-id');
					var value = parseInt(this.getAttribute('data-value'));
					updateStars(id, value);
				});
			});

			function updateStars(id, value) {
				var starContainer = document.querySelectorAll('.star[data-id="' + id + '"]');
				var noteInput = document.getElementById('note_' + id);
				var currentValue = parseInt(noteInput.value);
				if (currentValue === value) {
					value = 0;
					noteInput.value = '';
				} 
				else {
					noteInput.value = value;
				}
				for (var i = 0; i < starContainer.length; i++) {
					var star = starContainer[i];
					if (i < value) {
						star.innerHTML = '&#9733;';
					} 
					else {
						star.innerHTML = '&#9734;';
					}
				}
			}

			document.getElementById('form_notes').addEventListener('submit', function(e) {
				var noteInputs = document.querySelectorAll('input[name^="note"]');
				var hasValue = false;
				for (var i = 0; i < noteInputs.length; i++) {
					if (noteInputs[i].value !== '') {
						hasValue = true;
						break;
					}
				}
				if (!hasValue) {
					e.preventDefault();
				}
			});

		</script>

		<script>
			function effacerContenu() {
				document.querySelector('.input_recherche').value = '';
			}

			function validerContenu() {
				document.getElementById("recherche").submit();
    		}

		</script>
	
	</body>

</html>
<?php
		session_start();  // démarrage d'une session
?>

<html>
	<head>
		<title>Submarine Serie</title>
		<link rel="icon" href="image/icon.png" type="icon.png" />
		<meta charset="utf-8" />
		<link rel="stylesheet" href="../../css/inscription_user.css">
	</head>

	<body>

<?php
		if (isset($_POST["identifiant"]) && (isset($_POST["mdp"]))) {
			$civilite = $_POST['civilite'];
			$prenom = $_POST['prenom'];
			$nom = $_POST['nom'];
			$identifiant = $_POST['identifiant'];
			$mdp = $_POST['mdp'];
			$mail = $_POST['mail'];
			$date_Naissance = $_POST['date_Naissance'];
			$version = $_POST['version'];
			$bdd = new PDO('mysql:host=Localhost;dbname=submarineserieromain', 'root', '');
			
			// Vérifier si l'identifiant existe déjà
			$sql_check_identifiant = "SELECT identifiant FROM utilisateur WHERE identifiant = ?";
			$stmt_check_identifiant = $bdd->prepare($sql_check_identifiant);
			$stmt_check_identifiant->execute([$identifiant]);
			$existing_identifiant = $stmt_check_identifiant->fetchColumn();
			$confirm_mdp = $_POST['confirm_mdp'];
			if ($existing_identifiant) {
				$error_message = "Cet identifiant est déjà utilisé.";
			} else if ($mdp !== $confirm_mdp) {
				$error_message = "Les mots de passe ne correspondent pas.";
			} else {
				// Insérer les données dans la base de données
				$sql = "INSERT INTO utilisateur SET prenom=?, nom=?, civilite=?, mail=?, date_Naissance=?, identifiant=?, mdp=?, version=?";
				$stmt = $bdd->prepare($sql);
				$stmt->execute([$prenom, $nom, $civilite, $mail, $date_Naissance, $identifiant, $mdp, $version]);
				
				// Redirection après une inscription réussie
				if ($stmt) {
					$sql = "SELECT id_utilisateur, identifiant, mdp, is_admin, version FROM utilisateur WHERE identifiant='".$identifiant."' AND mdp='".$mdp."' ";
					$reponse = $bdd->query($sql);
					$resultat=$reponse->rowcount();
						if($resultat==1){																			
							$_SESSION['identifiant'] = $identifiant;
							foreach($reponse as $row) {
								$_SESSION['is_admin'] = $row['is_admin'];
								$_SESSION['id_utilisateur'] = $row['id_utilisateur'];
								$_SESSION['mdp'] = $row['mdp'];
								$_SESSION['identifiant'] = $row['identifiant'];
								$_SESSION['version'] = $row['version'];
							}
						}
				}
				header("Location: ../aide.php");
				exit();
			}
		}
?> 

		<nav class="nav_">
			<ul>
				<li class="nav_accueil"><a href="../../index.php">Accueil</a></li>
				<li class="dropdown">
					<a class="nav_profil" href="" style="border-bottom: 1px solid white;">Profil <span class="arrow">&#9662;</span></a>
					<ul class="dropdown-menu">
						<li><a href="connexion_user.php">Connexion</a></li>
						<li><a href="inscription_user.php">Inscription</a></li>
					</ul>
				</li>
			</ul>
		</nav>
		
		<a href ="index.php"><img class = "logo" src="../../css/image/logo.png" ></a> 

		<div class="div_inscription">
			<form action="inscription_user.php" method="POST">				
				<select name="civilite" class="form-control" required="required" autocomplete="off">
						<option value="Mr">Mr.</option>
						<option value="Mme">Mme.</option>
				</select>
				<input class="" type="text" placeholder="Nom" name="nom" size="40" maxlength="30" required />
				<input class="" type="text" placeholder="Prenom" name="prenom" size="40" maxlength="30" required />
				<input class="" type="mail" placeholder="Mail" name="mail" size="40" maxlength="30" required />
				<input class="" type="date" placeholder="Date de naissance" name="date_Naissance" size="40" maxlength="30" required />
				<select name="version" class="form-control" required="required" autocomplete="off">
						<option value="VF">Français</option>
						<option value="VO">English</option>
				</select>
				<input class="" type="text" placeholder="Identifiant" name="identifiant" size="40" maxlength="30" required />
				<input class="" type="password" placeholder="Mot de passe" name="mdp" size="40" maxlength="30" required />
				<input class="" type="password" placeholder="Confirm Mot de Passe" name="confirm_mdp" size="40" maxlength="30" required />
<?php if(isset($error_message)): ?>
				<p class="error-message"><?php echo $error_message; ?></p>
				</br>
<?php endif; ?>
				<input class="" type="submit" value="Inscription" />	
			</form>
		</div>
		
	</body>
</html>
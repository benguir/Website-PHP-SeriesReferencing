<?php
		session_start();  // démarrage d'une session
?>
<html>
	<head>
		<title>Submarine Serie</title>
		<link rel="icon" href="image/icon.png" type="icon.png" />
		<meta charset="utf-8" />
		<link rel="stylesheet" href="../../css/connexion_user.css">
	</head>

	<body>
<?php
		if(isset($_POST["identifiant"]) && (isset($_POST["mdp"]))){	
			$identifiant = $_POST['identifiant'];
			$mdp = $_POST['mdp'];
			$bdd = new PDO('mysql:host=Localhost;dbname=submarineserieromain', 'root', '');
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
				header("Location: ../../index.php");
				} else {
					// Identifiant ou mot de passe incorrect, afficher un message d'erreur
				$error_message = "Identifiant ou mot de passe incorrect.";
				}
		}
?> 
		
		<nav class="nav_">
			<ul>
				<li class="nav_accueil"><a href="../../index.php">Accueil</a></li>
				<ul class="align-droite">
				<li class="dropdown">
					<a class="nav_profil" href="" style="border-bottom: 1px solid white;">Profil <span class="arrow">&#9662;</span></a>
					<ul class="dropdown-menu">
						<li><a href="connexion_user.php">Connexion</a></li>
						<li><a href="inscription_user.php">Inscription</a></li>
					</ul>
				</li>
				</ul>
			</ul>
		</nav>
		
		<a href ="index.php"><img class = "logo" src="../../css/image/logo.png" ></a> 

		<div class="div_connexion">
			<form action="connexion_user.php" method="POST"> 
				<input class="input_identifiant_connexion" type="text" placeholder="Identifiant" name="identifiant" size="40" maxlength="30" required />
				<input class="input_mdp_connexion" type="password" placeholder="Mot de passe" name="mdp" size="40" maxlength="30" required />
<?php if(isset($error_message)): ?>
				<p class="error-message"><?php echo $error_message; ?></p>
				</br>
<?php endif; ?>
				
				<input class="input_submit_connexion" type="submit" value="Login" />    
			</form>
		</div>

		
	</body>
</html>
<?php
		session_start();  // démarrage d'une session
?>

<html>
        <head>
            <title>Submarine Serie</title>
            <link rel="icon" href="../css/image/icon.png" type="icon.png" />
            <meta charset="utf-8" />
            <link rel="stylesheet" href="../css/aide.css">
        </head>
<?php
	if (isset($_SESSION['version'])) { 
        if ($_SESSION['version'] == 'VO'){ // Ouverture langue VO
?>
				<nav class="nav_connect">
					<ul>
						<li><a href="../index.php">Home</a></li>
						<li><a href="maliste.php">My list</a></li>
						<ul class="align-droite">
						<li><a href="aide.php"style="border-bottom: 1px solid white;">?</a></li>
						<li class="dropdown">
							<a href=""><?php echo $_SESSION['identifiant']; ?> <span class="arrow">&#9662;</span></a>
								<ul class="dropdown-menu">
									<li><a href="compte.php">Account</a></li>
<?php
										if ($_SESSION['is_admin'] == 1) {	 // Admin
?>
											<li><a href="page/administration/administration.php">Administration</a></li>
<?php
										}
?>
									<li><a href="fonction/logout.php">Log off</a></li>
								</ul>
						</li>
						</ul>
						
					</ul>
				</nav>
        <img class = "logo" src="../css/image/logo.png"> 
                                   
        
        <embed src="../css/image/aide_english.pdf" width="100%" height="100%" type='application/pdf'>

<?php
		} else {
?>
				<nav class="nav_connect">
					<ul>
						<li><a href="../index.php">Accueil</a></li>
						<li><a href="maliste.php">Ma Liste</a></li>
						<ul class="align-droite">
						<li><a href="aide.php"style="border-bottom: 1px solid white;">?</a></li>
						<li class="dropdown">
							<a href=""><?php echo $_SESSION['identifiant']; ?> <span class="arrow">&#9662;</span></a>
								<ul class="dropdown-menu">
									<li><a href="compte.php">Mon compte</a></li>
<?php
										if ($_SESSION['is_admin'] == 1) {	 // Admin
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
        <img class = "logo" src="../css/image/logo.png"> 
                                   
        
        <embed src="../css/image/aide_french.pdf" width="100%" height="100%" type='application/pdf'>
<?php
		}
	}
?>
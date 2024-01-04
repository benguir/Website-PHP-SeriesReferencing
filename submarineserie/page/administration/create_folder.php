		<?php
		
			session_start();  // démarrage d'une session
			if (isset($_SESSION['version'])) { 
				if ($_SESSION['version'] == 'VO'){ // Ouverture langue VO
    ?>
		
		<?php
		
			function create_folder($folder){
				if(!is_dir($folder)) {
                    mkdir(($_SESSION['current_folder']).$folder, 0777, true);
				}
			}   
			
			if(!empty($_POST['folder'])){
				create_folder($_POST['folder']);
				header('Location:administration.php');
			}
		?>


<html>

<head>
    <title>Submarine Serie</title>
    <link rel="icon" href="image/icon.png" type="icon.png" />
    <meta charset="utf-8" />
    <link rel="stylesheet" href="../../css/create_folder.css">
    <script src="/brython.js"></script>
</head>
<body>
        <nav class="nav_connect">
					<ul>
						<li><a href="../../index.php">Home</a></li>
						<li><a href="../maliste.php">My list</a></li>
						<ul class="align-droite">
						<li><a href="page/aide.php">?</a></li>
						<li class="dropdown">
							<a href=""style="border-bottom: 1px solid white;"><?php echo $_SESSION['identifiant']; ?> <span class="arrow">&#9662;</span></a>
							<ul class="dropdown-menu">
                                <li><a href="../compte.php">Account</a></li>
								<li><a href="administration.php">Administration</a></li>
								<li><a href="../fonction/logout.php">Log off</a></li>
							</ul>
						</li>
						</ul>
					</ul>      
		</nav>
	

		<div class="div_create_folder">
		Create a folder
			<form action="create_folder.php" method="post">
				<input class="input_folder_name" type="text" placeholder="Folder name"  size="40" name="folder" required /> 
				<input class="input_folder_create" type="submit" value="Create"/>
			</form>
		</div>
		<div class="div_upload_file">
		Import a file
			<form method="POST" action="upload_folder.php" enctype="multipart/form-data">
				<input class="input_file_choisir" type="file" class="upload_file" name="files">
				<input class="input_file_create" type="submit" class="upload_submit" name="envoyer" value="Import"> <br>
			</form>
		</div>
	</body>

</html>

<?php
				} else { // Ouverture lange VF
				
					function create_folder($folder){
						if(!is_dir($folder)) {
							mkdir(($_SESSION['current_folder']).$folder, 0777, true);
						}
					}   
					
					if(!empty($_POST['folder'])){
						create_folder($_POST['folder']);
						header('Location:administration.php');
					}
				?>
		
		
		<html>
		
		<head>
			<title>Submarine Serie</title>
			<link rel="icon" href="image/icon.png" type="icon.png" />
			<meta charset="utf-8" />
			<link rel="stylesheet" href="../../css/create_folder.css">
			<script src="/brython.js"></script>
		</head>
		<body>
				<nav class="nav_connect">
							<ul>
								<li><a href="../../index.php">Accueil</a></li>
								<li><a href="../maliste.php">Ma Liste</a></li>
								<ul class="align-droite">
								<li><a href="page/aide.php">?</a></li>
								<li class="dropdown">
									<a href=""style="border-bottom: 1px solid white;"><?php echo $_SESSION['identifiant']; ?> <span class="arrow">&#9662;</span></a>
									<ul class="dropdown-menu">
										<li><a href="../compte.php">Mon compte</a></li>
										<li><a href="administration.php">Administration</a></li>
										<li><a href="../fonction/logout.php">Deconnexion</a></li>
									</ul>
								</li>
								</ul>
							</ul>      
				</nav>
			
		
				<div class="div_create_folder">
					Créer un dossier
					<form action="create_folder.php" method="post">
						<input class="input_folder_name" type="text" placeholder="Nom du dossier"  size="40" name="folder" required /> 
						<input class="input_folder_create" type="submit" value="Créer"/>
					</form>
				</div>
				<div class="div_upload_file">
					Importer un fichier
					<form method="POST" action="upload_folder.php" enctype="multipart/form-data">
						<input class="input_file_choisir" type="file" class="upload_file" name="files">
						<input class="input_file_create" type="submit" class="upload_submit" name="envoyer" value="Importer"> <br>
					</form>
				</div>
			</body>
		
		</html>

	<?php
				} // Fermeture langue VF
			}
		?>
		
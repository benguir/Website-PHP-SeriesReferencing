<?php
        session_start();  // démarrage d'une session
        if($_SESSION['is_admin'] == 0){	 // Pas Admin
            header("Location: ../index.php");
        }

        if($_SESSION['is_admin'] == 1){	 // Admin
			if (isset($_SESSION['version'])) { 
				if ($_SESSION['version'] == 'VO'){ // Ouverture langue VO
    ?>

<html>

<head>
    <title>Submarine Serie</title>
    <link rel="icon" href="image/icon.png" type="icon.png" />
    <meta charset="utf-8" />
    <link rel="stylesheet" href="../../css/compte.css">
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
                <a href="" style="border-bottom: 1px solid white;"><?php echo $_SESSION['identifiant']; ?> <span class="arrow">&#9662;</span></a>
                <ul class="dropdown-menu">
                    <li><a href="../compte.php">Account</a></li>
                    <li><a href="../fonction/logout.php">Log off</a></li>
                </ul>
            </li>
			
		</ul>
        </ul>
    </nav>

    <!-- <a href="../python/run_python.php" class="a_python">Recharger les données dans la base</a></br> -->


    <a href="create_folder.php" class="a_create"> Add file / folder </a> </br></br>
	

    <?php
		
			if (!isset($_SESSION['current_folder'])) {
				$_SESSION['current_folder'] = "SubmarinesSeries/"; // Initialise le repertoire avec la valeur
			}
							
			if (isset($_GET["folder"])) { // Test si il y a une varibale $folder dans l'URL
				$test_folder = $_GET["folder"] . "/";
				if (file_exists ($test_folder))
					$_SESSION['current_folder'] = $test_folder;	// Rajoute la variable au dossier courrant
			}	
		?>
    </br>

    <?php

			function path_to_array($path){
				$result = array();
				$find = "/";
				$origin = 0;
				$position = stripos ($path, $find, $origin);
				while ($position != false) {
					$retourne = substr ($path, $origin, $position - $origin);
					array_push ($result, $retourne);
					$origin = $position +1;
					$position = stripos ($path, $find, $origin);
				}
				return $result;
			}
		?>

    <?php 
		
			function array_to_path($array, $i){
				$result = "";
				$n = 0;
				while($n < $i ){
					if ($n == 0){
						$result = $array[$n];
					}
					else{
						$result = $result . "/" . $array[$n];
					}
				$n++;
				}
				return $result;
			}	
		?>

    <?php

			function count_file($folder)
			{
				$nbFichiers = 0;
				$repertoire = opendir($folder);
				while ($fichier = readdir($repertoire)){
					$nbFichiers++;
				}
                if ($nbFichiers <= 2){
					return (int) $nbFichiers;
				}
			}
		?>

    <script type="text/javascript">
    function confirme_delete_folder(folder) {
        var confirmation_folder = confirm("Delete confirmation ?");
        if (confirmation_folder)
            window.open("delete_folder.php?folder=" + folder, "_self");
        else
            window.open("administration.php", "_self");
    }

    function confirme_delete_file(file) {
        var confirmation_file = confirm("Delete confirmation ?");
        if (confirmation_file)
            window.open("delete_file.php?folder=" + file, "_self");
        else
            window.open("administration.php", "_self");
    }

    function confirme_rename_folder(path, folder) {
        var new_name = prompt('New folder name');
        window.open("rename_folder.php?new_name=" + new_name + "&valider=Envoyer&path=" + path + "&folder=" + folder,
            "_self");
    }

    function confirme_rename_file(path, file) {
        var new_name = prompt('New file name');
        window.open("rename_file.php?new_name=" + new_name + "&valider=Envoyer&path=" + path + "&file=" + file,
        "_self");
    }
    </script>

    <?php
			echo "<table>";
			echo "<div class='div_path_web'>";
			$path_array = path_to_array($_SESSION['current_folder']);
			$index = count(path_to_array($_SESSION['current_folder']));
			$array_path = array_to_path($path_array, $index);			
			foreach($path_array as $result){
				$n = 0;
				while($n <= $index ){
					if ($path_array[$n] == $result){
						$array_path_temp = array_to_path($path_array, $n+1);
						echo "<a class='path_web' href=\"administration.php?folder=$array_path_temp\" > $result </a> <a class='a_separateur'> / </a> \n";
						$n=$index+1;
					}
					else{
						$n++;
					}
				}
			}
			echo "</div>";
			?>

    <?php

			$scandir = scandir($array_path); // Liste les fichiers et repertoires du dossier courrant ($folder)
			foreach($scandir as $folder){ 
			
				if ($folder != ".." && $folder != "." && is_dir($_SESSION['current_folder'] . $folder)){ // Enlever les .. et .
					$folder_del = $_SESSION['current_folder'] . $folder;
					$path = $_SESSION['current_folder'];
					echo "<tr><td valign='center'><img class='img_scandir_folder' src='../../css/image/folder80.png'></td><td width='100%'> <a class='a_scandir_folder' href=\"administration.php?folder=".$_SESSION['current_folder'] . $folder."\" > $folder </a></td><td width=''>";
					if(count_file($folder_del)){
						echo "<a href='javascript:confirme_delete_folder(\"$folder_del\")'><img class='img_scandir_folder_delete' src='../../css/image/delete_folder30.png'> </a>"; 
					}
					else{
						echo "<img class='img_scandir_folder_notdelete' src='../../css/image/not_delete30.png'>"; 
					}
					echo "</td> <td width=''><a href='javascript:confirme_rename_folder(\"$path\", \"$folder\")'> <img <img class='img_scandir_folder_rename' src='../../css/image/rename_folder30.png'></a></td></tr>"; // Cliquer sur un dossier
				}
			}
			
			foreach($scandir as $file){ 
				if ($file != ".." && $file != "." && !is_dir($_SESSION['current_folder'] . $file)){ // Enlever les .. et .
					$path = $_SESSION['current_folder'];
					$file_del = $_SESSION['current_folder'] . $file;
					echo "<tr><td valign='center'><img class='img_scandir_file' src='../../css/image/file80.png'></td><td width='100%'> <a class='a_scandir_file' href=".$_SESSION['current_folder'] . $file."> $file </a></td><td valign='center'>"; 
					echo "<a href='javascript:confirme_delete_file(\"$file_del\")'> <img <img class='img_scandir_file_delete' src='../../css/image/delete_file30.png'> </a></td><td>"; 
					echo "<a href='javascript:confirme_rename_file(\"$path\", \"$file\")'> <img class='img_scandir_file_rename' src= '../../css/image/rename_file30.png'> </a> <br/></td></tr>"; // Cliquer sur un fichier
				}
			}
			echo "</table>";
		} else {
?>
			<html>

<head>
    <title>Submarine Serie</title>
    <link rel="icon" href="image/icon.png" type="icon.png" />
    <meta charset="utf-8" />
    <link rel="stylesheet" href="../../css/compte.css">
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
                <a href="" style="border-bottom: 1px solid white;"><?php echo $_SESSION['identifiant']; ?> <span class="arrow">&#9662;</span></a>
                <ul class="dropdown-menu">
                    <li><a href="../compte.php">Mon compte</a></li>
                    <li><a href="../fonction/logout.php">Deconnexion</a></li>
                </ul>
            </li>
			
		</ul>
        </ul>
    </nav>

    <!-- <a href="../python/run_python.php" class="a_python">Recharger les données dans la base</a></br> -->


    <a href="create_folder.php" class="a_create"> Ajout fichier / dossier </a> </br></br>
	<a href="../python/run_python.php" class="a_create"> Run python </a> </br></br>

    <?php
		
			if (!isset($_SESSION['current_folder'])) {
				$_SESSION['current_folder'] = "SubmarinesSeries/"; // Initialise le repertoire avec la valeur
			}
							
			if (isset($_GET["folder"])) { // Test si il y a une varibale $folder dans l'URL
				$test_folder = $_GET["folder"] . "/";
				if (file_exists ($test_folder))
					$_SESSION['current_folder'] = $test_folder;	// Rajoute la variable au dossier courrant
			}	
		?>
    </br>

    <?php

			function path_to_array($path){
				$result = array();
				$find = "/";
				$origin = 0;
				$position = stripos ($path, $find, $origin);
				while ($position != false) {
					$retourne = substr ($path, $origin, $position - $origin);
					array_push ($result, $retourne);
					$origin = $position +1;
					$position = stripos ($path, $find, $origin);
				}
				return $result;
			}
		?>

    <?php 
		
			function array_to_path($array, $i){
				$result = "";
				$n = 0;
				while($n < $i ){
					if ($n == 0){
						$result = $array[$n];
					}
					else{
						$result = $result . "/" . $array[$n];
					}
				$n++;
				}
				return $result;
			}	
		?>

    <?php

			function count_file($folder)
			{
				$nbFichiers = 0;
				$repertoire = opendir($folder);
				while ($fichier = readdir($repertoire)){
					$nbFichiers++;
				}
                if ($nbFichiers <= 2){
					return (int) $nbFichiers;
				}
			}
		?>

    <script type="text/javascript">
    function confirme_delete_folder(folder) {
        var confirmation_folder = confirm("Confirmation de suppression ?");
        if (confirmation_folder)
            window.open("delete_folder.php?folder=" + folder, "_self");
        else
            window.open("administration.php", "_self");
    }

    function confirme_delete_file(file) {
        var confirmation_file = confirm("Confirmation de suppression ?");
        if (confirmation_file)
            window.open("delete_file.php?folder=" + file, "_self");
        else
            window.open("administration.php", "_self");
    }

    function confirme_rename_folder(path, folder) {
        var new_name = prompt('Nouveau nom du dossier');
        window.open("rename_folder.php?new_name=" + new_name + "&valider=Envoyer&path=" + path + "&folder=" + folder,
            "_self");
    }

    function confirme_rename_file(path, file) {
        var new_name = prompt('Nouveau nom du dossier');
        window.open("rename_file.php?new_name=" + new_name + "&valider=Envoyer&path=" + path + "&file=" + file,
        "_self");
    }
    </script>

    <?php
			echo "<table>";
			echo "<div class='div_path_web'>";
			$path_array = path_to_array($_SESSION['current_folder']);
			$index = count(path_to_array($_SESSION['current_folder']));
			$array_path = array_to_path($path_array, $index);			
			foreach($path_array as $result){
				$n = 0;
				while($n <= $index ){
					if ($path_array[$n] == $result){
						$array_path_temp = array_to_path($path_array, $n+1);
						echo "<a class='path_web' href=\"administration.php?folder=$array_path_temp\" > $result </a> <a class='a_separateur'> / </a> \n";
						$n=$index+1;
					}
					else{
						$n++;
					}
				}
			}
			echo "</div>";
			?>

    <?php

			$scandir = scandir($array_path); // Liste les fichiers et repertoires du dossier courrant ($folder)
			foreach($scandir as $folder){ 
			
				if ($folder != ".." && $folder != "." && is_dir($_SESSION['current_folder'] . $folder)){ // Enlever les .. et .
					$folder_del = $_SESSION['current_folder'] . $folder;
					$path = $_SESSION['current_folder'];
					echo "<tr><td valign='center'><img class='img_scandir_folder' src='../../css/image/folder80.png'></td><td width='100%'> <a class='a_scandir_folder' href=\"administration.php?folder=".$_SESSION['current_folder'] . $folder."\" > $folder </a></td><td width=''>";
					if(count_file($folder_del)){
						echo "<a href='javascript:confirme_delete_folder(\"$folder_del\")'><img class='img_scandir_folder_delete' src='../../css/image/delete_folder30.png'> </a>"; 
					}
					else{
						echo "<img class='img_scandir_folder_notdelete' src='../../css/image/not_delete30.png'>"; 
					}
					echo "</td> <td width=''><a href='javascript:confirme_rename_folder(\"$path\", \"$folder\")'> <img <img class='img_scandir_folder_rename' src='../../css/image/rename_folder30.png'></a></td></tr>"; // Cliquer sur un dossier
				}
			}
			
			foreach($scandir as $file){ 
				if ($file != ".." && $file != "." && !is_dir($_SESSION['current_folder'] . $file)){ // Enlever les .. et .
					$path = $_SESSION['current_folder'];
					$file_del = $_SESSION['current_folder'] . $file;
					echo "<tr><td valign='center'><img class='img_scandir_file' src='../../css/image/file80.png'></td><td width='100%'> <a class='a_scandir_file' href=".$_SESSION['current_folder'] . $file."> $file </a></td><td valign='center'>"; 
					echo "<a href='javascript:confirme_delete_file(\"$file_del\")'> <img <img class='img_scandir_file_delete' src='../../css/image/delete_file30.png'> </a></td><td>"; 
					echo "<a href='javascript:confirme_rename_file(\"$path\", \"$file\")'> <img class='img_scandir_file_rename' src= '../../css/image/rename_file30.png'> </a> <br/></td></tr>"; // Cliquer sur un fichier
				}
			}
			echo "</table>";
		}
	}
}	
		?>
    </br>


</body>

</html>
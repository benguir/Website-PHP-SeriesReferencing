		<?php
		
			session_start();  // démarrage d'une session
		?>
		
		<?php
			
			$dossier = ($_SESSION['current_folder']);
			$fichier = basename($_FILES['files']['name']);
			$taille = filesize($_FILES['files']['tmp_name']);
			$extension = strrchr($_FILES['files']['name'], '.'); 
			
			if(!isset($erreur))
			{
				$fichier = strtr($fichier, 
					'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 
					'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
				$fichier = preg_replace('/([^.a-z0-9]+)/i', ' ', $fichier);
				if(move_uploaded_file($_FILES['files']['tmp_name'], $dossier . $fichier)){
					
				}
				else {
					
				}
			}
			header('Location:administration.php');
		?>
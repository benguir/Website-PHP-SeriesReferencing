		<?php
		
			session_start();  // d�marrage d'une session
		?>
		<?php 

			if (isset($_GET['valider'])) {
				$new_name = $_GET['new_name'];
				$folder = $_GET['folder'];
				$path = $_GET['path'];
			}
		 ?>

		<?php
			function rename_folder($path, $old_name, $new_name){
				rename($path.$old_name, $path.$new_name);
				header('Location:administration.php');
			}
		rename_folder($path, $folder, $new_name);

		?>
		
			
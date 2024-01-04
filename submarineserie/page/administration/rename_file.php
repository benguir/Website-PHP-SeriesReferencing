		<?php
		
			session_start();  // d�marrage d'une session
		?>
		<?php 

			if (isset($_GET['valider'])) {
				$new_name = $_GET['new_name'];
				$file = $_GET['file'];
				$path = $_GET['path'];
				$zip = ".zip";
			}
		 ?>

		<?php
			function rename_file($path, $old_name, $new_name){
				rename($path.$old_name, $path.$new_name);
				header('Location:administration.php');
			}
		rename_file($path, $file, $new_name.$zip);

		?>
		
			
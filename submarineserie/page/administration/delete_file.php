		<?php
		
			session_start();  // d�marrage d'une session
		?>

		<?php

			function delete_file($file){
				if(!is_dir($file)){
					unlink($file);
					header('Location:administration.php');
				}
			}
			delete_file($_GET['folder']);

		?>
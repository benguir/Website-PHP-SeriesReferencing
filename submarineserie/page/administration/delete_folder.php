		<?php
		
			session_start();  // d�marrage d'une session
		?>

		<?php

			function delete_folder($folder){
				if(is_dir($folder)){
					rmdir($folder);
					header('Location:administration.php');
				}
			}
			delete_folder($_GET['folder']);
		?>
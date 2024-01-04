<?php	
	session_start();  // démarrage d'une session
?>

<?php	
	session_unset ();
	session_destroy ();
	header ('location: ../../index.php');
?>


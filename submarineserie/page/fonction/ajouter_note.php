<?php
	session_start();
?>

<?php
	// Récupérer les notes envoyées
	$id_series = $_POST["id_series"];
	$notes = $_POST["note"];

	// Insérer les notes dans la base de données
	$con = mysqli_connect("localhost", "root", "", "submarineserieromain");
	$id_utilisateur = $_SESSION["id_utilisateur"];

	for ($i = 0; $i < count($id_series); $i++) {
		$id_serie = $id_series[$i];
		$note = $notes[$i];

		if ($note != 0) {
			$sql = "INSERT INTO notes (id_utilisateur, id_series, note) VALUES ('$id_utilisateur', '$id_serie', '$note')";
			if (mysqli_query($con, $sql)) {
				echo "Note ajoutée avec succès!";
			} 
			else {
				echo "Erreur: " . mysqli_error($con);
			}
		}
	}

	mysqli_close($con);

	// Redirection vers la page index.php avec le paramètre de recherche
	header("Location: ../../index.php?recherche=" . urlencode($_GET['recherche']));
?>

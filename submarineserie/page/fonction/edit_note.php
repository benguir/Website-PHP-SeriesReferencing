
<?php
		
        session_start();  // d�marrage d'une session
    ?>
    <?php 

        if (isset($_GET['valider'])) {
            $edit_note = $_GET['new_note'];
            echo $edit_note;
            $id_serie = $_GET['id_serie'];
            echo $id_serie;
        }            
     ?>

    <?php
	// Insérer les notes dans la base de données
	$con = mysqli_connect("localhost", "root", "", "submarineserieromain");
	$id_utilisateur = $_SESSION["id_utilisateur"];

			$sql = "UPDATE notes SET note = '".$edit_note."' WHERE id_utilisateur = '".$id_utilisateur."' AND id_series = '".$id_serie."'";

			if (mysqli_query($con, $sql)) {
				echo "Note ajoutée avec succès!";
			} 
			else {
				echo "Erreur: " . mysqli_error($con);
			}

	// Redirection vers la page index.php avec le paramètre de recherche
	header("Location: ../maliste.php");
    ?>
    
        
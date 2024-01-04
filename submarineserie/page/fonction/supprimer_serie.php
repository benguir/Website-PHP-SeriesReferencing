<?php
    session_start();
?>

<?php
    $con = mysqli_connect("localhost", "root", "", "submarineserieromain");

    $id_utilisateur = $_SESSION["id_utilisateur"];
    $id_series = $_POST['id_series'];

    // Supprimer les séries sélectionnées de la base de données
    foreach ($id_series as $id_serie) {

        $sql = "DELETE FROM notes WHERE id_utilisateur = '$id_utilisateur' AND id_series = '$id_serie'";
        if (mysqli_query($con, $sql)) {
            
        }
    }

    // Fermeture de la connexion
    mysqli_close($con);
    
    // Rediriger vers la page "maliste.php"
    header("Location: ../maliste.php");
?>

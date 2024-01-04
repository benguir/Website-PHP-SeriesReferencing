<?php
// Démarrage de la session pour stocker la sélection de l'utilisateur
session_start();
?>
<?php
    if(isset($_POST['langue'])){
    if($_POST['langue']=='anglais'){
        // Stocke la sélection de l'utilisateur dans une variable de session
        $_SESSION['langue'] = 'anglais';
        echo'anglais';
    } else {
        // Stocke la sélection de l'utilisateur dans une variable de session
        $_SESSION['langue'] = 'français';
        echo'francais';
    }
    } else {
    // Si aucune sélection n'a été effectuée, définit la langue par défaut sur "français"
    $_SESSION['langue'] = 'français';
    }
    if(!isset($_POST['langue'])){
        echo'francais';
    }
?>
<html>
    <head>
        <title>Submarine Serie</title>
        <link rel="icon" href="image/icon.png" type="icon.png" />
        <meta charset="utf-8" />
		<link rel="stylesheet" href="css/index.css">
    </head>

    <form id="myForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" 
        style="position: fixed;
        bottom: 0;
        right: 0;
        margin-bottom: 20px; /* Ajoutez une marge inférieure si nécessaire */
        margin-right: 20px; /* Ajoutez une marge droite si nécessaire */">
        <label for="langue">Langue :</label>
        <select name="langue" id="langue">
            <option value="francais"<?php if($_SESSION['langue']=='français') echo ' selected'; ?>>Français</option>
            <option value="anglais"<?php if($_SESSION['langue']=='anglais') echo ' selected'; ?>>Anglais</option>
        </select>
    </form>


<script>
  // Écouteur d'événement pour détecter le changement de sélection dans la liste déroulante
  document.getElementById("langue").addEventListener("change", function() {
    // Envoie automatiquement le formulaire
    document.getElementById("myForm").submit();
  });
</script>
</html>
<?php
    session_start();  // démarrage d'une session
?>

<html>
    <head>
        <title>Submarine Serie</title>
        <link rel="icon" href="image/icon.png" type="icon.png" />
        <meta charset="utf-8" />
        <link rel="stylesheet" href="../css/compte.css">
        <script src="/brython.js"></script>
    </head>

    <body>
 <?php
            if($_SESSION['is_admin'] == 1){	
                if(isset($_POST["edit_identifiant"])){	
                    $edit_identifiant = $_POST['edit_identifiant'];
                    $edit_is_admin = $_POST['edit_is_admin'];
                    $bdd = new PDO('mysql:host=Localhost;dbname=submarineserieromain', 'root', '');
                    $sql = "UPDATE utilisateur SET is_admin='".$_POST['edit_is_admin']."' WHERE identifiant = '".$_POST['edit_identifiant']."'";
                    $reponse = $bdd->query($sql); 	
                }
            }
            if(isset($_POST["edit_langue"])){	
                $edit_langue = $_POST['edit_langue'];
                $bdd = new PDO('mysql:host=Localhost;dbname=submarineserieromain', 'root', '');
                $sql = "UPDATE utilisateur SET version='".$_POST['edit_langue']."' WHERE identifiant = '".$_SESSION['identifiant']."'";
                $reponse = $bdd->query($sql);
                $_SESSION['version'] = $edit_langue;
            }
            ?>
            <?php	
                $value = null;
                if(isset($_POST["old_pwd"])){	
                    $old_pwd = $_POST['old_pwd'];
                    $new_pwd = $_POST['new_pwd'];
                    $new_pwd_conf = $_POST['new_pwd_conf'];
                    $bdd = new PDO('mysql:host=Localhost;dbname=submarineserieromain', 'root', '');
                    if($old_pwd == $_SESSION['mdp']){
                        if($new_pwd == $new_pwd_conf){
                            $sql = "UPDATE utilisateur SET mdp='".$_POST['new_pwd']."' WHERE id_utilisateur = '".$_SESSION['id_utilisateur']."'";
                            $reponse = $bdd->query($sql);
                            $value = "Mot de passe modifié";
                        }
                        else {
                            $value = "Erreur nouveau mot de passe et nouveau mot de passe confimé";
                        }
                    }
                    else{
                        $value = "Erreur ancien mot de passe";
                    }
                
                }
            ?> 

            <?php
    if (isset($_SESSION['version'])) { 
        if ($_SESSION['version'] == 'VO'){ // Ouverture langue VO
            if($_SESSION['is_admin'] == 0){	 // Pas admin
            ?>
        

    <html>

        <body>
        <nav class="nav_connect">
                        <ul>
                            <li><a href="../index.php">Home</a></li>
                            <li><a href="maliste.php">My list</a></li>
                            
                            <ul class="align-droite">
                            <li><a href="aide.php">?</a></li>
                            <li class="dropdown">
                            <a href=""style="border-bottom: 1px solid white;"><?php echo $_SESSION['identifiant']; ?> <span class="arrow">&#9662;</span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="fonction/logout.php">Log off</a></li>
                                </ul>
                            </li>
                            </ul>
                            
                        </ul>
                    </nav>

                <a href ="index.php"><img class = "logo" src="../css/image/logo.png" ></a>     
                
                <div class="div_changepwd">
                    <form action="compte.php" method="POST">
                        <input class="input_oldpwd_changepwd" type="password" placeholder="Old password" name="old_pwd" size="40" maxlength="30" required />
                        <input class="input_newpwd_changepwd" type="password" placeholder="New password" name="new_pwd" size="40" maxlength="15" required />
                        <input class="input_confnewpwd_changepwd" type="password" placeholder="Confirm new password" name="new_pwd_conf" size="40" maxlength="30" required />
                        <?php
                            echo $value.'</br>';  
                        ?>
                        <input class="input_submit_changepwd" type="submit" value="Change password" />
                    </form>
                </div>
                <div class="div_edit">
                        <form action="compte.php" method="POST">				
                            <p>Language : </p><select class= "select_isadmin_edit" name="edit_langue"> 
                                <option value="VO">English</option> 
                                <option value="VF">French</option> 
                            </select> </br> </br>
                            <input class="input_submit_edit" type="submit" value="Edit language" />	
                        </form>
                </div>
        </body>
    </html>

        <?php
            }
        ?>

        <?php
            if($_SESSION['is_admin'] == 1){	 // Admin
        ?>  
        
        <html>

            <body>
            <nav class="nav_connect">
                        <ul>
                            <li><a href="../index.php">Home</a></li>
                            <li><a href="maliste.php">My list</a></li>
                            
                            <ul class="align-droite">
                            <li><a href="aide.php">?</a></li>
                            <li class="dropdown">
                            <a href=""style="border-bottom: 1px solid white;"><?php echo $_SESSION['identifiant']; ?> <span class="arrow">&#9662;</span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="administration/administration.php">Administration</a></li>
                                    <li><a href="fonction/logout.php">Log off</a></li>
                                </ul>
                            </li>
                            </ul>
                            
                        </ul>
                        </nav>

                    <a href ="index.php"><img class = "logo" src="../css/image/logo.png" ></a>         

                    <div class="div_changepwd">
                        <form action="compte.php" method="POST">
                            <input class="input_oldpwd_changepwd" type="password" placeholder="Old password" name="old_pwd" size="40" maxlength="30" required />
                            <input class="input_newpwd_changepwd" type="password" placeholder="New password" name="new_pwd" size="40" maxlength="15" required />
                            <input class="input_confnewpwd_changepwd" type="password" placeholder="Confirm new password" name="new_pwd_conf" size="40" maxlength="30" required />
                            <?php
                                echo $value.'</br>';  
                            ?>
                            <input class="input_submit_changepwd" type="submit" value="Change password" />

                        </form>
                    </div>
                    <div class="div_edit">
                        <form action="compte.php" method="POST">				
                            <input class="input_identifiant" type="text" placeholder="Identifiant" name="edit_identifiant" size="40" maxlength="30" required />
                            <p>Admin : </p><select class= "select_isadmin_edit" name="edit_is_admin"> 
                                <option value="0">No</option> 
                                <option value="1">Yes</option> 
                            </select> </br> </br>
                            <input class="input_submit_edit" type="submit" value="Editer admin" />	
                        </form>
                    </div>
                    <div class="div_edit">
                        <form action="compte.php" method="POST">				
                            <p>Language : </p><select class= "select_isadmin_edit" name="edit_langue"> 
                                <option value="VO">English</option> 
                                <option value="VF">French</option> 
                            </select> </br> </br>
                            <input class="input_submit_edit" type="submit" value="Edit language" />	
                        </form>
                    </div>
            </body>
        </body>
            
        <?php
            } // Fermeture langue VO
        } else { // Ouverture langue VF
            if($_SESSION['is_admin'] == 0){	 // Pas admin
            ?>
        

    <html>

        <body>
        <nav class="nav_connect">
                        <ul>
                            <li><a href="../index.php">Accueil</a></li>
                            <li><a href="maliste.php">Ma Liste</a></li>
                            
                            <ul class="align-droite">
                            <li><a href="aide.php">?</a></li>
                            <li class="dropdown">
                            <a href=""style="border-bottom: 1px solid white;"><?php echo $_SESSION['identifiant']; ?> <span class="arrow">&#9662;</span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="fonction/logout.php">Deconnexion</a></li>
                                </ul>
                            </li>
                            </ul>
                            
                        </ul>
                    </nav>

                <a href ="index.php"><img class = "logo" src="../css/image/logo.png" ></a>     
                
                <div class="div_changepwd">
                    <form action="compte.php" method="POST">
                        <input class="input_oldpwd_changepwd" type="password" placeholder="Ancien mot de passe" name="old_pwd" size="40" maxlength="30" required />
                        <input class="input_newpwd_changepwd" type="password" placeholder="Nouveau mot de passe" name="new_pwd" size="40" maxlength="15" required />
                        <input class="input_confnewpwd_changepwd" type="password" placeholder="Confirmation nouveau mot de passe" name="new_pwd_conf" size="40" maxlength="30" required />
                        <?php
                            echo $value.'</br>';  
                        ?>
                        <input class="input_submit_changepwd" type="submit" value="Changer mot de passe" />
                    </form>
                </div>
                <div class="div_edit">
                        <form action="compte.php" method="POST">				
                            <p>Langue : </p><select class= "select_isadmin_edit" name="edit_langue"> 
                                <option value="VF">Français</option> 
                                <option value="VO">Anglais</option> 
                            </select> </br> </br>
                            <input class="input_submit_edit" type="submit" value="Changer la langue" />	
                        </form>
                </div>
        </body>
    </html>

        <?php
            }
        ?>

        <?php
            if($_SESSION['is_admin'] == 1){	 // Admin
        ?>  
        
        <html>

            <body>
            <nav class="nav_connect">
                        <ul>
                            <li><a href="../index.php">Accueil</a></li>
                            <li><a href="maliste.php">Ma Liste</a></li>
                            
                            <ul class="align-droite">
                            <li><a href="aide.php">?</a></li>
                            <li class="dropdown">
                            <a href=""style="border-bottom: 1px solid white;"><?php echo $_SESSION['identifiant']; ?> <span class="arrow">&#9662;</span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="administration/administration.php">Administration</a></li>
                                    <li><a href="fonction/logout.php">Deconnexion</a></li>
                                </ul>
                            </li>
                            </ul>
                            
                        </ul>
                        </nav>

                    <a href ="index.php"><img class = "logo" src="../css/image/logo.png" ></a>         

                    <div class="div_changepwd">
                        <form action="compte.php" method="POST">
                            <input class="input_oldpwd_changepwd" type="password" placeholder="Ancien mot de passe" name="old_pwd" size="40" maxlength="30" required />
                            <input class="input_newpwd_changepwd" type="password" placeholder="Nouveau mot de passe" name="new_pwd" size="40" maxlength="15" required />
                            <input class="input_confnewpwd_changepwd" type="password" placeholder="Confirmation nouveau mot de passe" name="new_pwd_conf" size="40" maxlength="30" required />
                            <?php
                                echo $value.'</br>';  
                            ?>
                            <input class="input_submit_changepwd" type="submit" value="Changer mot de passe" />

                        </form>
                    </div>
                    <div class="div_edit">
                        <form action="compte.php" method="POST">				
                            <input class="input_identifiant" type="text" placeholder="Identifiant" name="edit_identifiant" size="40" maxlength="30" required />
                            <p>Admin : </p><select class= "select_isadmin_edit" name="edit_is_admin"> 
                                <option value="0">Non</option> 
                                <option value="1">Oui</option> 
                            </select> </br> </br>
                            <input class="input_submit_edit" type="submit" value="Editer l'admin" />	
                        </form>
                    </div>
                    <div class="div_edit">
                        <form action="compte.php" method="POST">				
                            <p>Langue : </p><select class= "select_isadmin_edit" name="edit_langue"> 
                                <option value="VF">Français</option> 
                                <option value="VO">Anglais</option> 
                            </select> </br> </br>
                            <input class="input_submit_edit" type="submit" value="Changer la langue" />	
                        </form>
                    </div>
            </body>
        </body>
            
        <?php
            }
        }
    }
 

        ?>
    
</body>
</html>



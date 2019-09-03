<?php
session_start();

//Connexion à la base de données
$bdd = new PDO('mysql:host=localhost;dbname=auth_chat', 'root', '');
try {
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $bdd->exec('SET NAMES "utf8"');
}
catch (PDOException $e) {
    $error = '.: Unable to connect to the database server :.';
    echo 'Echec de la connexion à la base de données';
    exit();
}
    $reqbdd = $bdd->prepare('SELECT * FROM users WHERE id = ?');
    $reqbdd->execute(array($_SESSION['id']));
    $user = $reqbdd->fetch();
    
   

    // Modification du pseudo
    if(isset($_POST['newpseudo']) AND !empty($_POST['newpseudo'])){        
        $newpseudo = $_POST['newpseudo'];
        if($_POST['newpseudo'] != $user['pseudo']){
            $reqpseudo = $bdd->prepare("SELECT * FROM users WHERE pseudo = :newpseudo");
            $reqpseudo->bindValue(':newpseudo', $newpseudo);
            $reqpseudo->execute();
            $pseudoexist = $reqpseudo->rowCount();
            
            if($pseudoexist == 0) {
                $insertpseudo = $bdd->prepare("UPDATE users SET pseudo = ? WHERE id = ?");
                $insertpseudo->execute(array($newpseudo, $_SESSION['id']));
                $createdpseudo = "Le pseudo a bien été modifié!";
            }
            else {
                $errpseudo = "Ce pseudo est déjà utilisé!";
            }
        } 
        else {
            $errpseudo = "Le pseudo saisi est identique au pseudo d'origine!";
        }
    }
    
    //Modification de l'email
    if(!empty($_POST['newmail'])){
        $newmail = $_POST['newmail'];
        if(filter_var($newmail, FILTER_VALIDATE_EMAIL)){
            if($_POST['newmail'] != $user['mail']){
                $reqmail = $bdd->prepare("SELECT * FROM users WHERE mail = :newmail");
                $reqmail->bindValue(':newmail', $newmail);
                $reqmail->execute();
                $mailexist = $reqmail->rowCount();
                
                if($mailexist == 0) {
                    $insertmail = $bdd->prepare('UPDATE users SET mail = ? WHERE id = ?');
                    $insertmail->execute(array($newmail, $_SESSION['id']));
                    $createdmail = "L'email a bien été modifié!";
                }
                else {
                    $errmail = "Cette adresse mail est déjà utilisée!";
                }
            }
            else{
                $errmail = "L'email saisi est identique au mail d'origine!";
            }
        }
        else {
            $errmail = "Adresse mail invalide!";
        }
    }
    
    //Modification du mot de passe
    if(isset($_POST['newpass']) AND !empty($_POST['newpass']) AND isset($_POST['newpass2']) AND !empty($_POST['newpass2'])){
        $newpass = $_POST['newpass'];
        $newpass2 = $_POST['newpass2'];
        
        if($newpass == $newpass2){
            //Hachage du mot de passe
            $newpass_hash = password_hash($_POST['newpass'], PASSWORD_DEFAULT);
            $insertpass = $bdd->prepare('UPDATE users SET pass = ? WHERE id= ?');
            $insertpass->execute(array($newpass_hash, $_SESSION['id']));
            $createdpass = "Le mot de passe a bien été modifié";
        }
        else {
            $errpass = "Les mots de passe ne sont pas identiques!";
        }
    }
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <title>Profil</title>
        <meta charset="utf-8">
    </head>
    <body>
        <form action="" method="post">
            <div align="center"><fieldset class="boite" style="width:325px">
                <legend>Editer mon profil</legend>
                <div align="center">. :   Seuls les champs remplis seront modifiés   : .</div><br/>
                <div align="right"><a href="profil.html.php">Retour au profil</a></div><br/>
            <div class="form-group" align="left">
                <label for="pseudo">Pseudo</label>
                <input type="text" class="form-control" name="newpseudo" id="newpseudo" placeholder="Nouveau pseudo">
            </div>
            <div class="form-group" align="left">
                <label for="pseudo">Mail</label>
                <input type="email" class="form-control" name="newmail" id="newmail" placeholder="Nouveau mail">
            </div>
            <div class="form-group" align="left">
                <label for="pass">Mot de passe</label>
                <input type="password" class="form-control" name="newpass" id="newpass" placeholder="Nouveau mot de passe">
                <input type="password" class="form-control" name="newpass2" id="newpass2" placeholder="Répétez le mot de passe">
            </div>
                <button type="submit" class="btn btn-primary">OK</button>
            
            </fieldset></div>
            <br/><br/><div align="center"><h4>
                <?php
                if(isset($errpseudo)) {
                    echo '<font color="red">' . $errpseudo . "</font>";
                    ?><br/><br/><?php
                }
                if(isset($errmail)) {
                    echo '<font color="red">' . $errmail . "</font>";
                    ?><br/><br/><?php
                }
                if(isset($errpass)) {
                    echo '<font color="red">' . $errpass . "</font>";
                    ?><br/><br/><?php
                }
                if(isset($createdpseudo)) {
                    echo '<font color="green">' . $createdpseudo . "</font>";
                    ?><br/><br/><?php
                }
                if(isset($createdmail)) {
                    echo '<font color="green">' . $createdmail . "</font>";
                    ?><br/><br/><?php
                }
                if(isset($createdpass)) {
                    echo '<font color="green">' . $createdpass . "</font>";
                }
                ?></h4>
                </div>
        </form>

    </body>
    </html>
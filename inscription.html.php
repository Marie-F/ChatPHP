<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <title>Inscription</title>
    </head>

    <body>
        <form action='writing.php' method="post">
            <div align="center"><fieldset style="width: 20rem;">
                <legend>Inscrivez-vous</legend>
                <div class="form-group"align="left">
                    <label for="pseudo">Pseudo</label>
                    <input type="text" class="form-control" name="pseudo" id="pseudo" placeholder="Entrez votre pseudo" value="<?php if(isset($pseudo)) { echo $pseudo; } ?>" required>
                </div>
                <div class="form-group" align="left">
                    <label for="pass">Mot de passe</label>
                    <input type="password" class="form-control" name="pass" id="pass" placeholder="Entrez votre mot de passe" required>
                    <input type="password" class="form-control" name="pass2" id="pass2" placeholder="Répétez votre mot de passe" required>
                </div>
                <div class="form-group" align="left">
                    <label for="pseudo">Email</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="Entrez votre email" value="<?php if(isset($email)) { echo $email; } ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">OK</button>
                <div style="padding-top:20px"><a href="connexion.html.php">Retour à la page de connexion</a></div>
            </fieldset></div>
            <br/><br/><div align="center"><h4>
                <?php
                    if(isset($error)) {
                        echo '<font color="red">'.$error."</font>";
                    }
                ?></h4></div>
        </form>
    </body>
</html>


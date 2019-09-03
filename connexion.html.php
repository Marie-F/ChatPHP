<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <title>Connexion</title>
    </head>

    <body>
        <form action="connexion.php" method="post">
            <div align="center"><fieldset  style="width: 20rem;">
                <legend>Connectez-vous</legend>
                <div class="form-group" align="left">
                    <label for="pseudo">Pseudo</label>
                    <input type="text" class="form-control" name="pseudoconnect" id="pseudoconnect" placeholder="Entrez votre pseudo" required>
                </div>
                <div class="form-group" align="left">
                    <label for="pass">Mot de passe</label>
                    <input type="password" class="form-control" name="passconnect" id="passconnect" placeholder="Entrez votre mot de passe" required>
                </div>
                <button type="submit" class="btn btn-primary">OK</button>
                <div style="padding-top:20px"><a href="inscription.html.php">Je n'ai pas de compte → Inscription</a></div>
                </fieldset></div>
                <br/><br/><div align="center"><h4>
                <?php
                    if(isset($error)) {
                        echo '<font color="red">'. $error ."</font>";
                    }
                    if(isset($created)) {
                        echo '<font color="green">' . $created . "</font>";
                    }
                ?></h4></div>
        </form>
    </body>
</html>
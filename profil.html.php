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

    if(isset($_SESSION['id'])){
        $getid = intval($_SESSION['id']);
        $requser = $bdd->prepare('SELECT * FROM users WHERE id = ?');
        $requser->execute(array($getid));
        $userinfo = $requser->fetch();
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
<div align="left">
      <h3><a href=chat.php>← Retour au chat</a></h3>
      </div>
    <div align="center" class="form-group">
      <h2>Profil de <?php echo $userinfo['pseudo']; ?></h2>
      <br /><br /><div>
      <b>Pseudo : </b><?php echo $userinfo['pseudo']; ?>
      <br />
      <b>Mail : </b><?php echo $userinfo['mail']; ?>
      </div><br />
      <?php
      if(isset($_SESSION['id']) AND $userinfo['id'] == $_SESSION['id']) {
        ?>
        <br/>
        <a href=editprofile.php><button class="btn btn-primary">Editer mon profil</button></a><br/><br/>
        <a href=deconnect.php><button class="btn btn-primary">Se déconnecter</button></a><br/><br/><br/>
        <a href=delete.php>Supprimer mon compte</a>
        <?php
      }
      ?>
        </div>
    </body>
</html>
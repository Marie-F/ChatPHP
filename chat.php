<?php  
session_start(); 
$bdd = new PDO('mysql:host=localhost;dbname=auth_chat', 'root', '');

// Récupération des valeurs de l'utilisateur connecté
if(isset($_SESSION['id'])){
    $getid = intval($_SESSION['id']);
    $requser = $bdd->prepare('SELECT * FROM users WHERE id = ?');
    $requser->execute(array($getid));
    $userinfo = $requser->fetch();
}
$userpseudo = $userinfo['pseudo'];
$userpass = $userinfo['pass'];
$usermail = $userinfo['mail'];
$userid = $userinfo['id'];

?> <p style="display: none;"> <?php echo'.';?></p><?php
// Insertion du message entré dans la bdd
if(isset($_POST['msg']) AND !empty($_POST['msg'])){
    $msg = htmlspecialchars($_POST['msg']);
    $userpseudo = $userinfo['pseudo']; 
    $insertmsg = $bdd -> prepare('INSERT INTO chat (msg, pseudo) VALUES (?, ?)');
    $insertmsg -> execute(array($msg, $userpseudo));
}
?>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/
libs/jquery/1.3.0/jquery.min.js"></script>
<script type="text/javascript">
// Rafraîchit la div 'refresh_messages' toutes les 2s
var auto_refresh = setInterval(
function ()
{$('#refresh_messages').load('refresh_page.php').fadeIn("slow");}, 2000);
</script> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <title>Chat</title>
</head>
<body style="margin: 15px;">
<button class="btn btn-primary"><a style="color: white; font-weight: bold;" href=profil.html.php>Mon profil</a></button>
    <h3 align="center">Chat</h3>
    <div style="overflow:scroll; max-height: 560px; border-style: solid; border-width: 2px;">
        <div id="refresh_messages">
            <?php
              require('refresh_page.php');
            ?>
        </div>
       
    </div>
    <div class="container" style=" margin-top: 10px;">
            <form method="post" action="">
            <div class="row">
                <div class="col-10">
                    <input type="text" style="width: 100%;" class="form-control" placeholder="Entrez votre message" name="msg"/>
                </div>
                <div class="col-2">
                    <button class="btn btn-primary" type="submit">Envoyer</button>
                </div>
            </div>
            </form>
        </div>
</body>
</html>



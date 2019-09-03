<div id="refresh_messages">

<?php

// Connexion à la base de données
try
{
    $bdd = new PDO('mysql:host=localhost;dbname=auth_chat;charset=utf8', 'root', '');
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}

// Récupération des 50 derniers messages
$reponse = $bdd->query('SELECT pseudo, msg FROM chat ORDER BY id DESC LIMIT 50');

// Définition des fonctions pour avoir une couleur aléatoire de pseudos
function random_color_part() {
    return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
}
function random_color() {
    return random_color_part() . random_color_part() . random_color_part();
}   

// Affichage des messages
while ($donnees = $reponse->fetch())
{                
    ?>
    <b style="margin-left: 15px; color: <?php echo random_color()?> ;"><?php echo htmlspecialchars($donnees['pseudo'],  ENT_QUOTES, 'UTF-8'); ?>:  </b><?php echo htmlspecialchars($donnees['msg'],  ENT_QUOTES, 'UTF-8'); ?><br/><br/>
    <?php
}

$reponse->closeCursor();

?>

</div> 
<?php
session_start();
//Connexion à la base de données
try {
    $bdd = new PDO('mysql:host=localhost;dbname=auth_chat', 'root', '');
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
$userid = $userinfo['id'];
try {        
    // Preparation de la requete a executer   
    $sql = 'DELETE FROM users WHERE id = ?';
    $s = $bdd->prepare($sql);
    $s->execute(array($userid));
}
catch (PDOException $e) {
    $error = '.: Erreur dans la suppression : ' . $e->getMessage() . ' :.';
    echo 'Erreur dans l\'ajout' . $e->getMessage();
}    
$created = 'Compte supprimé!';
include('index.php');
exit();
?>
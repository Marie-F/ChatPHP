<?php
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
    
    $pseudoconnect= $_POST['pseudoconnect'];
    $passconnect= $_POST['passconnect'];

    //Hachage du mot de passe
    $passconnect_hash = password_hash($_POST['passconnect'], PASSWORD_DEFAULT);
 
    //  Récupération de l'utilisateur et de son pass hashé
    $req = $bdd->prepare('SELECT id, pseudo, pass FROM users WHERE (pseudo = :pseudo)');
    $req->execute(array('pseudo' => $pseudoconnect));
    $resultat = $req->fetch();

    // Comparaison du pass envoyé via le formulaire avec la base
    $isPasswordCorrect = password_verify($_REQUEST['passconnect'], $resultat['pass']);

    if ($isPasswordCorrect) {
        session_start();                      
        $_SESSION['id'] = $resultat['id'];
        $_SESSION['pseudo'] = $resultat['pseudo'];
        header('location: chat.php');
    }
    else {
        $error = "Mauvais identifiant ou mot de passe!";
        include 'index.php';
    }
    ?>
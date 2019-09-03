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

    //Récupération des informations saisies
    $pseudo = $_REQUEST['pseudo'];  // La variable $pseudo prend la valeur de ce qu'on a récupéré dans le input où name="pseudo"
    $pass = $_REQUEST['pass'];  // La variable $pass prend la valeur de ce qu'on a récupéré dans le input où name="pass"
    $pass2 = $_REQUEST['pass2'];
    $mail = $_REQUEST['email'];

    // Vérification de la validité des informations 
if(!empty($_POST['pseudo'])){
    $reqpseudo = $bdd->prepare("SELECT * FROM users WHERE pseudo = ?");
    $reqpseudo->execute(array($pseudo));
    $pseudoexist = $reqpseudo->rowCount();
    if($pseudoexist == 0) {
        if(filter_var($mail, FILTER_VALIDATE_EMAIL)){
            $reqmail = $bdd->prepare("SELECT * FROM users WHERE mail = ?");
            $reqmail->execute(array($mail));
            $mailexist = $reqmail->rowCount();
            if($mailexist == 0) {
                if ($pass == $pass2){    
                    // Hachage du mot de passe
                    $pass_hache = password_hash($_POST['pass'], PASSWORD_DEFAULT);
                    
                    // Insertion
                    $req = $bdd->prepare( 'INSERT INTO users(pseudo, pass, mail) VALUES(:pseudo, :pass, :mail)');
                    $req->execute(array(
                        'pseudo' => $pseudo,
                        'pass' => $pass_hache,
                        'mail' => $mail));
                    
                        $created = 'Bienvenue ' . htmlspecialchars($pseudo, ENT_QUOTES, 'UTF-8') . ', vous êtes des nôtres!';
                        include 'index.php';
                } else{
                    $error = "Les mots de passe saisis ne sont pas identiques!";
                    include 'inscription.html.php';
                }
            } else {
                $error = "Cette adresse mail est déjà utilisée!";
                include 'inscription.html.php';
            }
        } else {
            $error = "Adresse mail non valide!";
            include 'inscription.html.php';
        }
    } else {
        $error = "Pseudo déjà utilisé!";
        include 'inscription.html.php';
}
}
?>
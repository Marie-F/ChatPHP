<?php
    // Initialisation
    if (get_magic_quotes_gpc()) {
        $process = array(&$_GET, &$_POST, &$_COOKIE, &$_REQUEST);
        while (list($key, $val) = each($process)){
            foreach ($val as $k => $v) {
                unset($process[$key][$k]);
                if (is_array($v)) {
                    $process[$key][stripslashes($k)] = $v;
                    $process[] = &$process[$key][stripslashes($k)];
                }
                else {
                    $process[$key ][stripslashes($k)] = stripslashes($v);
                }
            }
        }
        unset($process);
    }
    
// Création de la BDD - connexion à Mysql sans base de données
$pdo = new PDO('mysql:host=localhost;', 'root', '');    
    try {
        //Preparation de la requete a executer
        $sql = 'CREATE DATABASE IF NOT EXISTS auth_chat;
                USE auth_chat;
                CREATE TABLE users(
                        id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                        pseudo VARCHAR (20) NOT NULL,
                        pass TEXT NOT NULL,
                        mail VARCHAR(100) NOT NULL
                        ) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
                CREATE TABLE chat(
                        id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                        pseudo VARCHAR (20) NOT NULL,
                        msg TEXT NOT NULL
                        ) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;';
                        
        $s = $pdo ->prepare($sql);
        $s->execute();
      }
      catch (PDOException $e) {
        $error = '.: Erreur dans l\'ajout :.';
        echo 'erreur dans l\'ajout' . $e->getMessage();
        exit();
      }

      // Tentative de connexion a la Base de Donnees...
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
    
    include 'connexion.html.php';
?>
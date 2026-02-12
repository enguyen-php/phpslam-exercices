<?php

// Fichier de connexion de la BDD 

// On inclut dotenv qui contient les variables d'environnement
include "dotenv.php";

class DB {
    // Le data source name, une string qui contient certaines infos de connexion 
    private static $dsn = "mysql:dbname=app-sqy271;host=localhost";
    // On va préciser les options pour PDO, ici récupérer comme réponse de la BDD sous forme de tableau associatif
    private static $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC);

    public static function connectDB($dbuser, $dbpassword) {    
        try {
             // On affiche un message de confirmation si succès
            // echo "La connexion à la BDD a réussie";

            // On tente de se connecter à la BDD avec PDO 
            // On vient finalement se connecter à la BDD 
            return new PDO(DB::$dsn, $dbuser, $dbpassword, DB::$options);    

        } catch(PDOException $error) {
            // En cas d'erreur on stop le script et on l'affiche. On utilise la méthode getMessage() de PDOException
            die("erreur lors de la connexion : " . $error->getMessage());
        }
    } 
}

// On appelle la méthode statique connectDB qui nous retourne 
// l'objet de la connexion 
$db = DB::connectDB($dbuser, $dbpassword);
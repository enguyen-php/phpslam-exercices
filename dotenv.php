<?php 

//Load Composer's autoloader 
require 'vendor/autoload.php';

// On récupère nos variables d'environnements depuis .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();


// Variables d'environnement pour PDO
// $dbhost = $_ENV['DB_HOST'];
// $dbname = $_ENV['DB_NAME'];
$dbuser = $_ENV['DB_USERNAME'];
$dbpassword = $_ENV['DB_PASSWORD'];
// $dbsgbd = $_ENV['DB_SGBD'];
// $dbport = $_ENV['DB_PORT'];


// Variables d'environnement pour PHP_Mailer
// $mailhost = $_ENV['SMTP_HOST'];
// $mailport = $_ENV['SMTP_PORT'];
$mailuser = $_ENV['MAIL_USERNAME'];
$mailpassword = $_ENV['MAIL_PASSWORD'];
// $mailencrypt = $_ENV['SMTP_ENCRYPTION'];

// Variables pour la weather API
$apiKey = $_ENV["WEATHER_API_KEY"];
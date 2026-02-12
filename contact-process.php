<?php

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader (created by composer, not included with PHPMailer)
require 'vendor/autoload.php';

// On récupère nos variables d'environnements depuis .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

// Faire en sorte, via POST, de transmettre les infos soumises par le user 
// vers la page contact-process.php
// TOUS les champs doivent etre remplis 
// Une erreur doit s'afficher si ce n'est pas le cas 


// Vérification des champs - vide ou pas
if (!empty($_POST["first-name"]) 
    && !empty($_POST["last-name"]) 
    && !empty($_POST["email"]) 
    && !empty($_POST["message"]) 
    && isset($_POST["agree-to-policies"])) {

        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = $_ENV["MAIL_USER"];                     //SMTP username
            $mail->Password   = $_ENV["MAIL_PASSWORD"];                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        
            //Recipients
            $mail->setFrom($_POST["email"], $_POST["first-name"] . $_POST["last-name"]);
            $mail->addAddress($_ENV["MAIL_USER"], 'Romain Jalabert');     //Add a recipient
        
        
            //Content
            $mail->Subject = 'Message de ' . $_POST["email"];
            $mail->Body    = $_POST["message"];
        
            $mail->send();
        
            header("Location: contact.php?success=true");
        
        } catch (Exception $e) {
        
            echo "Le message n'a pas pu etre envoyé : {$mail->ErrorInfo}";
        
        }

} else {
    header("Location: contact.php?error=true");
    exit();
}





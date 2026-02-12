<?php 

// Logique de déconnexion
// On commence toujours par ouvrir la session 
session_start();

session_destroy();

// Renvoie vers la page de Login
header("Location: login.php");

?>
<?php 

include "partials/header.php";

// Avec la superglobale $_GET j'affiche les données transmises via la méthode HTTP Get 
// Cette superglobale est un tableau associatif et j'accède à une donnée précise via l'attribut name de l'input 
// echo $_GET["pseudo"];

// Avec la méthode POST rien ne s'affiche dans l'URL 
// J'ai besoin de la superglobale $_POST pour afficher les données transmises 
if (isset($_POST["pseudo"])) {
    echo $_POST["pseudo"];
}


// Avec la superglobale $_SERVER je récup toutes les infos liées au serveur web
// print_r($_SERVER);

?>

<h1>Méthodes HTTP : GET et POST</h1>


<h3>Je transmets avec la méthode GET des infos via les paramètres de l'URL : </h3> 
<form action="" method="GET">

    <input placeholder="Votre pseudo ici ..." type="text" name="pseudo" id="username-input">
    <input type="submit" value="Envoyer">

</form>



<h3>Je transmets avec la méthode POST :</h3>
<form action="" method="POST">

    <input placeholder="Votre pseudo ici ..." type="text" name="pseudo" id="username-input">
    <input type="submit" value="Envoyer">

</form>

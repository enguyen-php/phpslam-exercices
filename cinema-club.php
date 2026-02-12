<?php

include "partials/header.php";



// 1 - Récupérer, si il y en a, les données en GET
// avec l'aide de superglobales - par exemple $_GET

// On vérifie d'abord si le form a été soumis 
if (isset($_GET["submit"])) {

    // On vérifie ensuite que chaque champ soit bien rempli
    if (!isset($_GET["nom"]) || !isset($_GET["prenom"]) || !isset($_GET["age"])) {

        $error = "Veuillez renseigner tous les champs";
    
    } else {
        // On définit des variables 
        $nom = $_GET["nom"];
        $prenom = $_GET["prenom"];
        $age = $_GET["age"];
    
        // Calcul du tarif selon l'age recuperé
        if ($age < 10) {
            $tarif = "Enfant";
            $prix = 4;
        } else if ($age < 16) {
            $tarif = "Junior";
            $prix = 6;
        } else if ($age < 25) {
            $tarif = "Etudiant";
            $prix = 7;
        } else if ($age > 60) {
            $tarif = "Senior";
            $prix = 6;
        } else {
            $tarif = "Standard";
            $prix = 18;
        }
    }
}

// 2 - Assigner des variables à ces données 
// 3 - Effectuer le calcul du tarif avec des conditions 

?>

<h1>Cinéma-club</h1>

<!-- Notre formulaire à remplir afin d'envoyer les infos avec la méthode GET -->
<form action="" method="GET">
    <input type="text" name="nom" placeholder="Votre nom ici ...">
    <input type="text" name="prenom" placeholder="Votre prenom ici ...">
    <input type="number" name="age" placeholder="Précisez votre age ...">
    <input type="submit" name="submit" value="Calculer le tarif" >
</form>

<!-- Si les variable tarif et prix existent alors on les affiche dans le h2 -->
<?php if (isset($tarif) && isset($prix)) : ?> 
    <h2>Le tarif est <?= $tarif ?>, le prix est de <?= $prix ?> euros</h2>
<?php endif ?>

<!-- Si une variable error existe c'est qu 'il y a eu un souci, on l'affiche dans ce cas -->
<?php if (isset($error)) : ?> 
    <h2><?= $error ?></h2>
<?php endif ?>

<?php

include "partials/footer.php";

?>
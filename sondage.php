<?php

include "partials/header.php";

// Coder le php ici ...

// 1 - Vérifier que le formulaire ait bien été soumis 
// On va utiliser la superglobale $_POST pour recup les infos transmises via la méthode http POST
if (isset($_POST["submit"])) {

    // 2 - Vérifier que tous les champs/ inputs aient bien été pris en compte
    if (!empty($_POST["prenom"]) 
    && !empty($_POST["nom"]) 
    && !empty($_POST["language"]) 
    && !empty($_POST["gafa"]) 
    && !empty($_POST["front"]) 
    && !empty($_POST["ia"])) {

        // 3 - Une fois tout cela vérifié on recupère les différentes valeurs que l'on assignent à des variables 
        $prenom = $_POST["prenom"];
        $nom = $_POST["nom"];
        $language = $_POST["language"];
        $gafa = $_POST["gafa"];
        $front = $_POST["front"];
        $ia = $_POST["ia"]; 

    } else {
        $error = "Veuillez remplir tous les champs";
    }
} 
// 4 - Enfin on les affiche dans le HTML en y mélangeant les balises php si pb lors des vérifications 
// afficher un message d'erreur 

// Vous aurez basoin de récupérer les infos soumises par l'utilisateur pour ca on peut utiliser $_POST

?>


<h1>Sondage avec la méthode POST</h1>

<!-- h2+input*2+(h3+(input*3))*2+(h3+input*2)*2+input -->

<form action="" method="POST">

    <input placeholder="Votre prénom ..." type="text" name="prenom">
    <input placeholder="Votre nom ..." type="text" name="nom">

    <h3>Quel est votre language favori ?</h3>

    <input value="html" name="language" type="radio">HTML
    <input value="css" name="language" type="radio">CSS
    <input value="php" name="language" type="radio">PHP

    <h3>Quel est votre GAFA favori ?</h3>

    <input value="facebook" name="gafa" type="radio">Facebook/Meta
    <input value="apple" name="gafa" type="radio">Apple
    <input value="amazon" name="gafa" type="radio">Amazon
    <input value="google" name="gafa" type="radio">Google

    <h3>Plutot front ou backend ?</h3>

    <input value="frontend" name="front" type="radio">Frontend
    <input value="backend" name="front" type="radio" >Backend

    <h3>L'IA vous fait elle peur ?</h3>

    <input name="ia" value="yes" type="radio">Oui
    <input name="ia" value="no" type="radio">Non

    <br>
    <br>

    <input name="submit" value="Soumettre" type="submit">

</form>

<div class="results">

    <!-- On vient afficher les variables déclarées plus haut ssi on a pas d'erreur 
    et que le formulaire a bien été soumis   -->
    <?php if (!isset($error) && isset($_POST["submit"])) : ?>

        <h3>Vous etes <?= $prenom ?> <?= $nom ?></h3>
        <h3>Votre language favori est <?= $language ?></h3>
        <h3>Votre GAFA favori est <?= $gafa ?></h3>
        <h3>Plutot <?= $front ?></h3>
        <h3>Peur de l'IA ? <?= $ia ?></h3>

    <!-- Cas ou on a une erreur et le formulaire a été soumis  -->
    <?php elseif (isset($error) && isset($_POST["submit"])) : ?>
        <h3><?= $error ?></h3>
    <?php endif ?>

</div>


<?php

include "partials/footer.php";

?>
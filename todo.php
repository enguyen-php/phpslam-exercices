<?php 

include "partials/header.php";
include "config/db.php";

// FAIRE FONCTIONNER LA TODO : MODIFIER et SUPPRIMER 

// On doit pouvoir en cliquant sur un bouton qui sera dans chaque todo, modifier le contenu de la todo 
// On doit également pouvoir supprimer la todo lorsque l'on clique sur le bouton de suppression
// En profiter pour récupérer des composants tailwind qui rende notre todo plus jolie 
// Créér un lien dans le menu qui mène vers nos différents exos / projets en PHP (et qui inclut cette todo) 
 
// 1 - Ajouter les boutons en question dans le HTML (modifier et supprimer) pour chaque todo
// 2 - Associer des liens <a> à ces boutons (et on pourra mener vers une URL spécifique pour
// la modification ou la suppression)
// 3 - Coder la logique derrière chaque action en réutilisant $db et en écrivant 
// les requetes SQL vers la DB  

// Ajouter un lien qui permet de checker une todo 


// On déclare $todos qui vient éxecuter la requete sur $db 
// fetchAll() nous  retourne l'ensemble des résultats (!= fetch qui n'en retourne qu'un seul le premier)
$sql = "SELECT * FROM todos";
$todos = $db->query($sql)->fetchAll();

// AJOUTER UNE TODO EN BDD 
if (isset($_POST["submit"])) {
    if (!empty($_POST["todo"])) {

        $content = $_POST["todo"];

        // On vient se prémunir des injections SQL avec des requetes préparées
        // Cad on remplace les données en provenance du user par ?
        $sqlInsert = "INSERT INTO todos(content) VALUES(?)";

        // On vient préparer la requete 
        $stmt = $db->prepare($sqlInsert);

        // On vient ensuite éxecuter la requete et lier les paramètres 3
        $stmt->execute([$content]);  

    } else {
        $error = "Veuillez écrire une todo";
    }
}

// Si on a bien des params (en GET) dans l'URL ...
if (!empty($_GET)) {
    // SUPPRESSION D'UNE TODO
    // Si on a bien dans l'url un paramètre id avec une valeur et delete qui est égal à true
    if (isset($_GET["id"]) && isset($_GET["delete"]) && $_GET["delete"]) {
        
        $sql = "DELETE FROM todos WHERE id = ?";

        $stmt = $db->prepare($sql);
        $stmt->execute([$_GET["id"]]);
        header("Location: todo.php");
        exit();
    }

    // MODIFICATION D'UNE TODO
    // Si on a bien dans l'url un paramètre id avec une valeur et edit qui est égal à true
    if (isset($_GET["id"]) && ($_GET["edit"] == "done")) {

        // Récupérer le nouveau contenu de la todo 
        $content = $_POST["todo-change"];

        // Requete SQL
        $sql = "UPDATE todos SET content = ? WHERE id = ?";

        $stmt = $db->prepare($sql);
        $stmt->execute([$content, $_GET["id"]]);
        header("Location: todo.php");
        exit();
    }

    if (isset($_GET["check"])) {

        foreach($todos as $todo) {

            if ($todo["id"] == $_GET["check"]) {

                $bool = $todo["check"];

                $sql = "UPDATE todos SET checked = ? WHERE id = ?";

                $stmt = $db->prepare($sql);
                $stmt->execute([!$bool, $_GET["check"]]);
                header("Location: todo.php");
                exit();
            }
        }

    }
}

?>

<h1>Ma todo en PHP</h1>

<form action="" method="POST">

    <input name="todo" type="text" placeholder="Votre todo ici ...">
    <input name="submit" type="submit" value="Ajouter">

</form>

<div class="display-todos">

    <?php if (isset($todos)) : ?> 
        <!-- On utilise un foreach pour parcourir le tableau des todos  -->
        <?php foreach($todos as $todo) : ?>
            <div class="todo">

            <?php if (!empty($_GET) && isset($_GET["id"]) && ($_GET["id"] == $todo["id"]) && $_GET["edit"]) : ?> 

                <form action="todo.php?id=<?= $todo["id"] ?>&edit=done" method="POST">
                    <input type="text" name="todo-change" placeholder="<?= $todo["content"] ?>">
                    <input type="submit" name="submit" value="Changer"/>
                </form>

            <?php else : ?>

                <p><?= $todo["content"] ?></p>

            <?php endif ?>
            
                <a href="todo.php?check=<?= $todo["id"] ?>">Check</a>
                <a href="todo.php?id=<?= $todo["id"] ?>&edit=true">Edit</a>
                <a href="todo.php?id=<?= $todo["id"] ?>&delete=true">X</a>

            </div>
        <?php endforeach ?>
    <?php endif ?>

</div>

<?php

include "partials/footer.php";

?>



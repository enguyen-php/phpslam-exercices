<?php

include "partials/header.php";
include "partials/check-session.php";
include "config/cURL.php";
include "config/db.php";


// On va utiliser cURL afin de récupérer des données depuis l'API fake store API : https://fakestoreapi.com/docs
if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $product = connectToAPI("https://fakestoreapi.com/products/$id");
} else {
    header("Location: shop.php");
    exit();
}

// On vient regarder si il y a un status de précisé dans l'URL (success par exemple)
// Si oui on affiche un message de confirmation
if (isset($_GET["status"]) && $_GET["status"] == "success") {
    $message = "Votre item a été ajouté au panier avec succès !";
}

//// FONCTIONNALITE DES NOTES

// Vérification du fait qu'une note ait déjà été enregistré en BDD
$sqlCheck = "SELECT * FROM notes WHERE id_user = ? AND id_product = ?";
$stmt = $db->prepare($sqlCheck);
$stmt->execute([$_SESSION["id"], $product["id"]]);
$result = $stmt->fetch();

// Ajout des notes en BDD 
if (isset($_GET["note"])) {
    // Si on a dèjà une note pour le produit alors on vient écraser celle-ci
    if ($result) {
        // Update
        $sql = "UPDATE notes SET points = ? WHERE id_user = ? AND id_product = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$_GET["note"], $_SESSION["id"], $product["id"]]);
    // Si on a pas dfe notes pour le produit on en insère une 
    } else {
        // Insert
        $sql = "INSERT INTO notes(points, id_user, id_product) VALUES(?, ?, ?)";
        $stmt = $db->prepare($sql);
        $stmt->execute([$_GET["note"], $_SESSION["id"], $product["id"]]);
    }
// Si aucune note n'est précisée dans l'URL on redirige vers la page du produit en affichant la note depuis la BDD
} else {
    if ($result) {
        header("Location: shop-item.php?id=" . $product["id"] . "&note=" . $result["points"]);
        exit();
    }
}

// Affichage de la moyenne des notes
$sqlAvg = "SELECT AVG(points) FROM notes WHERE id_product = ?"; 
$stmt = $db->prepare($sqlAvg);
$stmt->execute([$product["id"]]);
$avg = $stmt->fetch();
 

//// SYSTEME DE COMMENTAIRE ////

// Etape en BDD -> Créer une table pour les commenatires (id, contenu, id_auteur, id_produit, timestamp)

// 1 - Créer l'input de texte pour le commentaire et un bouton de confirmation (en html)
// 2 - Coder la logique PHP ensuite : 
//      - vérifier les données (empecher les caractères de type html)
//      - Enregistrer les commentaire en BDD via la connexion PDO ($db)
// 4 - Une fois le commentaiore enregistré en BDD on redirige vers une version actualisée de la page  
// 5 - L'idée étant que lorsque l'on arrive sur la page les comments se chargent automatiquement

// Si on a appuyé sur le bouton de soumission d'un commentaire 
if (isset($_POST["submit"])) {
    // Ensuite on vérifie que le champ de commentaire ne soit pas vide
   if (!empty($_POST["comment"])) {
        // Empechement des caractères spéciaux pour éviter les scripts malveillants 
        $content = htmlspecialchars($_POST["comment"]);

        // Ajout du commentaire en BDD, d'abord notre requete
        $sql = "INSERT INTO comments(content, id_user, id_product) VALUES(?, ?, ?)";

        // On fait notre logique habituelle de requete préparée
        $stmt = $db->prepare($sql);
        $stmt->execute([$content, $_SESSION["id"], $product["id"]]);
        header("Location: shop-item.php?id=" . $product["id"]);
        exit();

   } else {
        $error = "Veuillez écrire un commentaire ...";
   }
}

// AFFICHAGE DES DIFFERENTS COMMENTAIRES 
$sqlComment = "SELECT comments.id, content, id_user, id_product, comments.timestamp_comment, username, avatar FROM comments INNER JOIN users ON comments.id_user = users.id WHERE id_product = ?";
$stmt = $db->prepare($sqlComment);
$stmt->execute([$product["id"]]);
$comments = $stmt->fetchAll();
// echo("<pre>");
// print_r($comments);
// echo("</pre>");

// SUPPRESSION d'UN COMMENTAIRE 
if (isset($_GET["delete"])) {
    $sql = "DELETE FROM comments WHERE id = ?";

    $stmt = $db->prepare($sql);
    $stmt->execute([$_GET["delete"]]);

    header("Location: shop-item.php?id=" . $product["id"]);
    exit();
}


?>


<!-- On affiche un message de onfirmation si un item a bien été ajouté au panier -->
<?php if (isset($message)) : ?>
    <p class="text-center font-bold mt-4 text-pretty text-green-700"><?= $message ?></p>
<?php endif ?>


<?php if (isset($product)) : ?>

    <section>
        <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 md:items-center md:gap-8">

                <div>
                    <div class="max-w-prose md:max-w-none">

                        <h2 class="text-2xl font-semibold text-gray-900 sm:text-3xl">
                                <?= $product["title"] ?>
                        </h2>

                        <!-- Container afin d'appliquer du flex pour nos étoiles  -->
                        <div class="flex mt-4">
                            <!-- Boucle for afin d'afficher les boutons étoiles  -->
                            <?php for ($i=1; $i <= 5; $i++) : ?>

                                <!-- Condition : si notre variable i de la boucle est inf ou égale à la note transmise alors on affiche l'étoile en jaune -->
                                <?php if (isset($_GET["note"]) && ($i <= $_GET["note"]) ) : ?>

                                    <a href="shop-item.php?id=<?= $product["id"] ?>&note=<?= $i ?>">
                                        <svg class="w-5 h-5 fill-yellow-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24"><path d="M13.849 4.22c-.684-1.626-3.014-1.626-3.698 0L8.397 8.387l-4.552.361c-1.775.14-2.495 2.331-1.142 3.477l3.468 2.937-1.06 4.392c-.413 1.713 1.472 3.067 2.992 2.149L12 19.35l3.897 2.354c1.52.918 3.405-.436 2.992-2.15l-1.06-4.39 3.468-2.938c1.353-1.146.633-3.336-1.142-3.477l-4.552-.36-1.754-4.17Z"/></svg>
                                    </a>

                                <?php else : ?>

                                    <a href="shop-item.php?id=<?= $product["id"] ?>&note=<?= $i ?>">
                                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24"><path d="M13.849 4.22c-.684-1.626-3.014-1.626-3.698 0L8.397 8.387l-4.552.361c-1.775.14-2.495 2.331-1.142 3.477l3.468 2.937-1.06 4.392c-.413 1.713 1.472 3.067 2.992 2.149L12 19.35l3.897 2.354c1.52.918 3.405-.436 2.992-2.15l-1.06-4.39 3.468-2.938c1.353-1.146.633-3.336-1.142-3.477l-4.552-.36-1.754-4.17Z"/></svg>
                                    </a>

                                <?php endif ?>

                            <?php endfor ?>

                        </div>

                        <div class="mt-4">
                        <h2>Note moyenne des utilisateurs : <?= round(floatval($avg["AVG(points)"]), 2) ?> / 5</h2> 
                        </div>

                        <p class="mt-4 text-pretty text-gray-700">
                            <?= $product["description"] ?>
                        </p>

                        <h2 class="text-2xl font-semibold text-gray-900 sm:text-3xl">
                                <?= $product["price"] . "€" ?>
                        </h2>

                        <a href="add-to-cart.php?id=<?= $product["id"] ?>" class="mt-4 flex w-48 justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                            Ajouter au panier
                        </a>

                    </div>
                </div>

                <div>
                    <img src="<?= $product["image"] ?>" class="rounded" alt="">
                </div>

            </div>

                    <!-- Formulaire de copmmentaire  -->
        <h2 class="mt-4">Commentaires</h2>

        <form action="#" method="POST">
        <!-- <label for="email" class="block text-sm/6 font-medium text-gray-900">Commentaires</label> -->
        <textarea placehoder="Votre commentaire ici ..." name="comment" id="comment" class="mt-2 mb-2 flex w-full justify-center rounded-md px-3 py-1.5 text-sm/6 font-semibold text-black shadow-xs focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 border-2 border-gray-600"></textarea>
        <input value="Comment" type="submit" name="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
        </form>

        <!-- AFFICHAGE DES DIFFERE?NTS COMMENTAIRES  -->
        <?php if (count($comments)) : ?> 

        <?php foreach($comments as $comment) : ?>

        <div class="mt-6 relative grid grid-cols-1 gap-4 p-4 mb-8 border rounded-lg bg-white shadow-lg relative">
            <!-- Liens d'edit et de suppression -->
            <div class="comment-links flex absolute right-0 mt-2">
                <a><img class="w-6 mr-2 cursor-pointer" src="assets/icons/edit.svg"></a>
                <a href="shop-item.php?id=<?= $product["id"] ?>&delete=<?= $comment["id"] ?>"><img class="cross-btn w-6 mr-2 cursor-pointer" src="assets/icons/close-cross.svg"></a>
            </div>

            <div class="relative flex gap-4 w-fit">
                <img src="<?= $comment["avatar"]?>" class="relative rounded-lg -top-8 -mb-4 bg-white border h-20 w-20" alt="" loading="lazy">
                <div class="flex flex-col w-fit">
                    <div class="flex flex-row justify-between">
                        <p class="relative text-xl whitespace-nowrap truncate overflow-hidden"><?= $comment["username"] ?></p>
                        <a class="text-gray-500 text-xl" href="#"><i class="fa-solid fa-trash"></i></a>
                    </div>
                    <p class="text-gray-400 text-sm"><?= $comment["timestamp_comment"] ?></p>
                </div>
            </div>
            <p class="-mt-4 text-gray-500"><?= $comment["content"] ?></p>
        </div>

        <?php endforeach ?>


        <?php endif ?>
        </div>



    </section>

<?php endif ?>


<?php

include "partials/footer.php";

?>
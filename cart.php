<?php

include "partials/header.php";
include "partials/check-session.php";
include "config/db.php";


// Récupération du contenu du panier depuis la base de données
$sql = "SELECT * FROM cart WHERE id_user = ?";
$stmt = $db->prepare($sql);
$stmt->execute([$_SESSION["id"]]);
$res = $stmt->fetch();

// Conversion des données JSON en tableau PHP
if (isset($res["content"])) {
    $content = json_decode($res["content"], true);
} else {
    $content = null;
}

// On intialise les variables pour le calcul du cout total
$subtotal = 0;
$total = 0;

// Calcul du total et gestion des erreurs 
if (isset($res) && !empty($content)) {
    //Vérification que le décodage JSON a réussi
    if ($content === null && json_last_error() !== JSON_ERROR_NONE) {
        $message = "Erreur lors du chargement du panier.";
        $content = null;
        
    } else {
        // Calcul du sous-total
        foreach ($content as $product) {
            $subtotal += floatval($product["price"]);
        }
        $total = $subtotal;
    }
} else {
    $message = "Votre panier est vide ...";
}

?>



<main class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">

    <h2 class="text-3xl font-bold text-gray-900 mb-8">Mon Panier</h2>

    <?php if (isset($message) && !isset($content) || empty($content)) : ?>

        <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm text-center">
            <p class="text-gray-600"><?= htmlspecialchars($message) ?></p>
            <a href="shop.php" class="mt-4 inline-block text-indigo-600 hover:text-indigo-500">Continuer vos achats</a>
        </div>

    <?php elseif (isset($content) && count($content) > 0) : ?>
        <div class="lg:grid lg:grid-cols-12 lg:gap-x-12">

            <!-- Cart Items -->
            <div class="lg:col-span-7 space-y-4">

                <?php foreach($content as $product) : ?>
                    <!-- Cart Item -->
                    <div class="flex rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
                        <img src="<?= $product["image"] ?>" alt="<?= htmlspecialchars($product["title"]) ?>" class="h-24 w-24 rounded-md object-cover flex-shrink-0">
                        <div class="ml-6 flex-1">
                            <div class="flex justify-between">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900"><?= htmlspecialchars($product["title"]) ?></h3>
                                    <p class="text-sm text-gray-500 mt-1"><?= number_format($product["price"], 2, ',', ' ') ?> €</p>
                                </div>

                                <!-- Suppression du panier -->
                                <a data-productId="<?= $product["id"] ?>" class="deleteBtn text-gray-400 hover:text-red-500 transition-colors">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </a>

                            </div>
                            <label>Quantité : </label>
                            <input type="number" value="1" min="1" class="mt-4 w-20 rounded-md border border-gray-300 px-3 py-1 text-sm">
                        </div>
                    </div>
                <?php endforeach ?>
            </div>

            <!-- Order Summary -->
            <div class="mt-10 lg:col-span-5 lg:mt-0">
                <div class="rounded-lg border border-gray-200 bg-white px-6 py-6 shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Résumé</h3>
                    
                    <div class="space-y-4">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Sous-total</span>
                            <span class="font-medium"><?= number_format($subtotal, 2, ',', ' ') ?> €</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Livraison</span>
                            <span class="font-medium">Gratuite</span>
                        </div>
                        <div class="flex justify-between border-t border-gray-200 pt-4">
                            <span class="font-semibold">Total</span>
                            <span class="font-semibold"><?= number_format($total, 2, ',', ' ') ?> €</span>
                        </div>
                    </div>

                    <button class="mt-6 w-full rounded-md bg-indigo-600 px-4 py-3 text-sm font-semibold text-white hover:bg-indigo-500 transition-colors">
                        Passer la commande
                    </button>
                </div>
            </div>
        </div>
    <?php endif ?>
</main>

<!-- Script JS pour afficher une alerte lors de la suppression d'un article -->
<script>
    console.log("script ok")
    // Récupérer les éléments à écouter / rendre dynamique -> le lien "a" de suppression
    // qui a pour classe "deleteBtn" -> On a tous les boutons à sélectionner d'ou le "all"
    const deleteBtns = document.querySelectorAll(".deleteBtn")

    console.log(deleteBtns)

    // On veut écouter le click sur chaque bouton de suppression
    deleteBtns.forEach((btn) => {

        console.log(btn)

        btn.addEventListener("click", () => {

            console.log("bouton de sup cliqué")


            if (confirm("Etes vous sur de vouloir supprimer l'article séléctionné ?") == true) {
                window.location.href = "remove-from-cart.php?id=" + btn.getAttribute("data-productId")
            } else {
                window.reload()
            }
        }) 
    })

</script>

<?php

include "partials/footer.php";

?>
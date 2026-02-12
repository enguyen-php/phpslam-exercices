<?php 

include "partials/header.php";
include "partials/check-session.php";
include "config/cURL.php";

// Challenge notes et commentairess :

// - Permettre au User de noter chaque article : la note pouvant aller de 0 à 5 (vous pouvez utiliser des étoiles)
// - Créer une table en BDD qui va contenir les notes, une entrée dans la table = une note d'un user 
// - Dans cette table note il faudra que chaque note enregistrée puisse etre reliée à un article et à un utilisateur 
// - Quand un user met une note celle-ci est enregistrée en BDD et on actualise l'affichage de la note du produit : 
// -> Cette note doit etre une moyenne de toutes les note attribuées au produit

// PS1 : Une seule note possible par article pour chaque user 
// PS2 : Les notes doivent apparaitre dans la page shop et la page produit

// BONUS : Faire un système de commentaire ou on peut commenter un produit sur la page produit seulement

// On recup tous les produits en utilisant notre fonction de connexion vers l'API
$products = connectToAPI("https://fakestoreapi.com/products"); 

//// MENU DES FILTRES POUR LE SHOP

// On initialise un tableau de catégories vide 
$categories = [];

// On récupère depuis le call API des produits ($produtcs) les différentes catés existantes 
// Si une caté est déjà enregistrée dans le tableau alos on ne l'ajoute pas 
foreach($products as $product) {
    if (!in_array($product["category"], $categories)) {
        $categories[] = $product["category"];
    }
}


// Si on a bien une catégorie précisée en paramètre de l'URL ...
if (isset($_GET["category"])) {

    // ... alors on initialise un tableau vide qui recevra les produits 
    // correspondants à la catégorie choisie 
    $products_filtered = [];

    // Popur chaque produit dans mon ensemble de produits, je vérifie
    // que la catégorie corresponde bien : si c'est le cas je l'ajoute à mon tableau des produits filtrés 
    foreach($products as $product) {
        if ($product["category"] == $_GET["category"]) {
            $products_filtered[] = $product;
    }}

    // Si la catégorie n'existe pas ou ne concerne aucun produit on arffiche un message d'erreur
    if (!empty($products_filtered)) {
        $products = $products_filtered;
    } else {
        $error = "La catégorie ne contient aucun produit ...";
    }
}


?>

<!-- On va afficher la liste des produits recup depuis la fake store api 
On récupère un tableau, lui meme constitué d'objets (ou tableaux associatifs en php) -->
<div class="bg-white">
  <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
    <h2 class="mb-6 text-2xl font-bold tracking-tight text-gray-900">Bienvenue sur le Shop</h2>

    <!-- Affichage du message de succès si on a ajouté un produitr dans le panier  -->
    <?php if (isset($_GET["status"])) :  ?> 

        <h3 class="mb-6 text-green-700 font-bold mt-6">Votre article a bien été ajouté au panier !</h3>

    <?php endif ?>


    <!-- Récupération des catégories afin de mettre en place un système de filtres  -->
    <?php foreach($categories as $category) : ?> 
        <a href="shop.php?category=<?= $category ?>" class="cursor-pointer inline mr-4 flex w-48 justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
            <?= $category ?>
        </a>
    <?php endforeach ?>

    <!-- Si on a bien $product de défini ... -->
    <?php if (isset($products)) :  ?>

    <!-- A partir d'ici on affiche la liste des items du shop si on la reçoit bien -->
    <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">

        <?php foreach($products as $product) : ?>

        <!-- Code pour un item de la liste du shop -->
        <div class="group relative flex flex-col justify-between items-center">
            <a href="shop-item.php?id=<?= $product["id"] ?>">
                <img src="<?= $product["image"] ?>" alt="Front of men&#039;s Basic Tee in black." class="aspect-square w-full rounded-md bg-gray-200 object-cover group-hover:opacity-75 lg:aspect-auto lg:h-80" />
                <div class="mt-4 flex justify-between">
                    <h3 class="text-sm text-gray-700">
                        
                        <!-- <span aria-hidden="true" class="absolute inset-0"></span> -->
                        <?= $product["title"] ?>
                    </h3>
                    <div>
                        <p class="mt-1 text-sm text-gray-500"><?= substr($product["description"], 0, 100) ?> ...</p>
                    </div>
                    <p class="text-sm font-medium text-gray-900"><?= $product["price"] ?> €</p>
                </div>
            </a>
            <a href="add-to-cart.php?id=<?= $product["id"] ?>" class="addBtn animate__animated  mt-4 flex w-48 justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Ajouter au panier</a>
        </div>

        <?php endforeach ?>

    </div>

    
    <?php endif ?>

  </div>
</div>

<!-- // Animation du bouton pour ajouter au panier -->
<script>
    const addBtns = document.querySelectorAll(".addBtn")

    addBtns.forEach((btn) => {
        btn.addEventListener("click", () => {
            btn.classList.add("animate__bounceOut")
        })
    })
    

</script>


<?php 

include "partials/footer.php";

?>
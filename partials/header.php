<?php 

session_start();

?>

<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Mon site en PHP</title>

    <!-- Import de Tailwind avec lien CDN -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <!-- Import de animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <!-- Import des scripts JS -->
    <script type="module" src="scripts/comments.js" defer></script>
</head>

<body>

<header class="bg-gray-900 z-1">
    <!-- Notre menu de navigation Tailwind -->
  <nav aria-label="Global" class="mx-auto flex max-w-7xl items-center justify-between p-6 lg:px-8">
    
    <!-- Logo de notre app à gauche -->
    <div class="flex lg:flex-1">
      <a href="index.php" class="-m-1.5 p-1.5">
        <img src="./assets/images/fouine-noBg.png" alt="" class="h-16 w-auto" />
      </a>
    </div>

    <!-- Burger menu lorsque l'on est sur mobile ou tablette -->
    <div class="flex lg:hidden">
      <button type="button" command="show-modal" commandfor="mobile-menu" class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-400">
        <span class="sr-only">Open main menu</span>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" data-slot="icon" aria-hidden="true" class="size-6">
          <path d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
      </button>
    </div>

    <!-- Notre menu, qui change selon si l'on est login ou pas ... -->
    <?php if (isset($_SESSION["username"])) : ?>

        <el-popover-group class="hidden lg:flex lg:gap-x-12">
            <a href="index.php" class="text-sm/6 font-semibold text-white">Home</a>
            <a href="shop.php" class="text-sm/6 font-semibold text-white">Shop</a>
            <a href="projects.php" class="text-sm/6 font-semibold text-white">Projects</a>
            <a href="contact.php" class="text-sm/6 font-semibold text-white">Contact</a>
            
        </el-popover-group>

        <div class="hidden lg:flex lg:flex-1 lg:justify-end">

            <!-- Icone du panier : rajouter le nbre d'items au dessus du logo -->
             <!-- On va utiliser la longueur du tableau contenant les produits du panier  -->

          

          <a href="cart.php"><img class="relative w-12 mr-12" src="./assets/icons/cart-icon.svg" />
          
                        
              <?php if (isset($_SESSION["cart"])) :  ?>
                <h2 class="absolute top-7 right-62 text-white bg-red-500 rounded-full w-6 h-6 flex justify-center items-center"><?= count($_SESSION["cart"]) ?></h2>
              <?php endif ?>
    
          </a>


            <a href="logout.php" class="text-sm/6 font-semibold text-white">Log out <span aria-hidden="true">&rarr;</span></a>
        </div>

    <?php else : ?>

        <el-popover-group class="hidden lg:flex lg:gap-x-12">
            <a href="login.php" class="text-sm/6 font-semibold text-white">Login</a>
            <a href="signup.php" class="text-sm/6 font-semibold text-white">Signup</a>
        </el-popover-group>

    <?php endif ?>


  </nav>
  
</header>


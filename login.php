<?php

include "partials/header.php";
include "config/db.php";

// Traitement des infos reçues en POST
// Vérification que le form ait été soumis 
// Puis vérification que les champs ne soient pas vides etc 

// On vérifie que le form ait été soumis
if (isset($_POST["submit"])) {
    // On vérifie qu'aucun chalmp ne soit laissé vide
    if (!empty($_POST["username"]) && !empty($_POST["password"])) {

        // Requete afin de vérifier que le user existe bien (via email ou username)
        $sql = "SELECT * FROM users WHERE username = ? OR email = ?";

        // On prépare puis on éxecute la requete SQL 
        $stmt = $db->prepare($sql);
        $stmt->execute([$_POST["username"], $_POST["username"]]);

        // Avec fetch on vient recup la réponse > Si oui ou non un user existe bvien avec le pseudo donné ou le mail
        $res = $stmt->fetch(); 

        // Prise en compte du cas ou le user n'existe pas 
        // $res seul dans les parenthèses équivaut à ($res === true)
        if ($res) {
            // Ici on vérifie avec password verify que le mdp correspond bien au hash en BDD
            if (password_verify($_POST["password"], $res["password"])) {

                // Récupérer le panier correspondant au user afin d'afficher le nbre d'items 
                // au niveau du logo du panier dans le header
                $sqlCart = "SELECT * FROM cart WHERE id_user = ?";

                // On prépare puis on éxecute la requete SQL pour récupérer le contenu du panier
                $stmt = $db->prepare($sqlCart);
                $stmt->execute([$res["id"]]);
                $cart = $stmt->fetch(); 


                // Tout est bon, on démarre donc une session -> à partir de cette ligne
                // le cookie de session qui contient l'id de la session est automatiquement créee 
                session_start();

                // On alimente avec les bonnes infos reçues de la BDD 
                // notre superglobale $_SESSION - nom, email et date de création
                $_SESSION = $res;

                // On ajoute le contenu du panier dans la session
                $_SESSION["cart"] = json_decode($cart["content"], true);

                // Suppression du password de nos données contenues dans la session
                unset($_SESSION["password"]);

                // Ici tout a été normalement vérifié -> on redirige vers la homepage
                header("Location: index.php");
                exit();

            } else {
                $error = "Le mot de passe n'est pas bon ...";
            }
        } else {
            $error = "Aucun utilisateur trouvé avec le pseudo / email donné";
        }
    } else {
        $error = "Veuillez remplir tous les champs";
    }
}


?>

<!-- 
1 - Coder d'abord le form en question avec la method (post) et en ne précisant pas l'action dans les attributs. 
    On aura besoin de pseudo / email et mot de passe

2 - Une fois le form ajouté assurez vous de bien recevoir les données transmises en haut de la page entre les balises php 
    avec la superglobale $_POST - Rappellez vous que $_POST est un tableau associatif et chaque clé de ce tableau provient 
    des différents "name" précisés en attributs dans chacun de nos inputs

3 - On procède ensuite au traitement des données : 

    - Si le form a bien été soumis 
    - Alors on vérifie que les champs soient tous remplis (sinon message d'erreur)
    - Si tout est remplis on procède à la requete préparée avec $db (qui devra etre inclus plus haut)
    - Il faudra donc écrire la requete SQL permettant de vérifier si le user existe bien dans la bdd et que le mdp correspond 
    - On vérifiera les mdp (la version reçue en post et celle hashée en bdd) avec password_verify
    - On créera des erreurs pour chaque situation adéquate

4 - Si tout est bon est que le user est login -> trouver un moyen de rediriger vers la homepage (index.php)  
-->

<!--
  This example requires updating your template:

  ```
  <html class="h-full bg-white">
  <body class="h-full">
  ```
-->
<div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
  <div class="sm:mx-auto sm:w-full sm:max-w-sm">
    <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-gray-900">Login</h2>
  </div>

  <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">

    <form action="#" method="POST" class="space-y-6">
      <div>
        <label for="email" class="block text-sm/6 font-medium text-gray-900">Pseudo / Email</label>
        <div class="mt-2">
          <input id="email" type="text" name="username" required autocomplete="email" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
        </div>
      </div>

      <div>
        <div class="flex items-center justify-between">
          <label for="password" class="block text-sm/6 font-medium text-gray-900">Mot de passe</label>
          <div class="text-sm">
            <a href="#" class="font-semibold text-indigo-600 hover:text-indigo-500">Mot de passe oublié ?</a>
          </div>
        </div>
        <div class="mt-2">
          <input id="password" type="password" name="password" required autocomplete="current-password" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
        </div>
      </div>

      <div>
        <input value="Login" type="submit" name="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
      </div>
    </form>

    <p class="mt-10 text-center text-sm/6 text-gray-500">
      Pas encore inscrit ?
      <a href="signup.php" class="font-semibold text-indigo-600 hover:text-indigo-500">S'inscrire</a>
    </p>

    <?php if (isset($error)) : ?> 

        <h3 class="mt-10 text-center text-sm/6 text-red-500"><?= $error ?></h3>

    <?php endif ?> 

  </div>
</div>


<!-- <form action="" method="POST">

    <input type="text" name="username" placeholder="Votre pseudo ...">
    <input type="password" name="password" placeholder="Votre mot de passe ...">
    <input type="submit" name="submit" value="Se connecter">

</form>



<?php

include "partials/footer.php";

?>
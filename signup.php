<?php

include "partials/header.php";
include "config/db.php";


// Véerifier les données: Est ce que le form a été soumis ? 
if (isset($_POST["submit"])) {
    // On vérifie que chaque champ du formulaire soit bien rempli
    if (!empty($_POST["username"]) 
    && !empty($_POST["email"]) 
    && !empty($_POST["password"]) 
    && !empty($_POST["confirm-password"])) {

        // On vérifie que le user ait bien mis 2 fois le meme mot de passe
        $username = $_POST["username"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $confirm = $_POST["confirm-password"];

        // Idéalement on devrait vérifier en plus que : 
            // le username ne contienne pas de caractères spéciaux (<, >, ; etc)
            // L'email est au bon format 
            // Il faudrait aussi théoriquement vérifier la longueur et le contenu du mdp .
            // (12 car mnimum, min, maj, chiffre et carcatère spécial)

        // On vient vérifier qu'un user en question n'est pas déjà enregistré avec ces informations
        $sqlCheck = "SELECT * FROM users WHERE username = ? OR email = ?";

        $stmtCheck = $db->prepare($sqlCheck);

        $stmtCheck->execute([$_POST["username"], $_POST["email"]]);

        $resCheck = $stmtCheck->fetch();

        if (!$resCheck) {

            if ($password !== $confirm) {

                $error = "Le mot de passe et la confirmation sont différents...";
                exit();
    
            } else {
    
                // Si les mdp sont bien identiques -> hasher le mdp
                // On peut hasher grace à la fonction integrée password_hash
                $hash = password_hash($password, PASSWORD_DEFAULT); 
    
                // On écrit notre requete SQL pour insérer un nouveau user dans la table users
                $sql = "INSERT INTO users(username, email, password) VALUES(?, ?, ?)";
    
                // On vient préparer la requete 
                $stmt = $db->prepare($sql);
                
                // On vbient éxecuter la requete en remplacant les ? par les bonnes variables.
                $stmt->execute([$username, $email, $hash]);

                header("Location: login.php");
                exit();
            }

        } else {
            $error = "Il existe déjà un user avec cet email ou ce pseudo";
        }
    } else {
        $error = "Veuillez renseigner tous les champs";
    }
}

?>

<!-- 
1 - Coder le form de signup : username, email, mot de passe et confirmation du mot de passe
2 - Il faut transmettre les données via POST et vérifier que les mdp soient équivalents
3 - Créer une table users dans phpmyadmin qui contiendra les infos de chaque user
4 - Si le username, le mail et le mdp sont bien remplis on les enregistre en BDD 
-->

<div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
  <div class="sm:mx-auto sm:w-full sm:max-w-sm">
    <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-gray-900">Signup</h2>
  </div>

  <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">

    <form action="#" method="POST" class="space-y-6">
      <div>
        <label for="email" class="block text-sm/6 font-medium text-gray-900">Email</label>
        <div class="mt-2">
          <input id="email" type="email" name="email" required autocomplete="email" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
        </div>
        <label for="username" class="block text-sm/6 font-medium text-gray-900">Username</label>
        <div class="mt-2">
          <input id="username" type="username" name="username" required autocomplete="username" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
        </div>
      </div>

      <div>
        <label for="password" class="block text-sm/6 font-medium text-gray-900">Mot de passe</label>
        <div class="mt-2">
            <input id="password" type="password" name="password" required autocomplete="current-password" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
        </div>
        <label for="password" class="block text-sm/6 font-medium text-gray-900">Confirmation du mot de passe</label>
        <div class="mt-2">
            <input id="password" type="password" name="confirm-password" required autocomplete="current-password" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
        </div>
      </div>

      <div>
        <input value="Signup" type="submit" name="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
      </div>
    </form>

    <?php if (isset($error)) : ?> 

        <h3 class="mt-10 text-center text-sm/6 text-red-500"><?= $error ?></h3>

    <?php endif ?> 

  </div>
</div>

<!-- <h1>Page de Signup</h1>

<form action="" method="POST">

    <input name="username" placeholder="Votre pseudo..." type="text">
    <input name="email" placeholder="Votre email..." type="text">
    <input name="password" placeholder="Votre mot de passe..." type="password">
    <input name="confirm-password" placeholder="Confirmer votre mot de passe ..." type="password">

    <input name="submit" type="submit" value="S'inscrire">

</form>

<?php if (isset($error)) : ?> 

    <h3><?= $error ?></h3>

<?php endif ?> -->

<?php

include "partials/footer.php";

?>
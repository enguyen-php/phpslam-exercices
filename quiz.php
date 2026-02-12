<?php

include "partials/header.php";
include "partials/check-session.php";

?>

<script type="module" src="scripts/quiz.js" defer></script>

<h1>Page de quiz</h1>

<!-- En alliant JS et HTML / PHP on veut coder un quiz dynamique qui 
nous demande les capitales de pays du monde et nous attribue un score /20

Lors de chaque tour on doit trouver la capitale du pays en question parmi 4 choix 
-> 1 bonne réponse, er 3 aléatoires mais qui partagent la meme zone géographique

A l'issue des 20 questiobn le quiz s'arrete : "Fin du quiz, vous avez eu xx/20"
Aussi un bouton recommencer doit apparaitre et recharger le jeu lorsque l'on clique -->



<?php

include "partials/footer.php";

?>
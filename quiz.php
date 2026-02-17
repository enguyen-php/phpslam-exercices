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

<div class="quiz">

    <h3>Question numéro <span class="quiz-number"></span></h3>
    <h3>Score : <span class="quiz-score"></span></h3>

    <h2 class="quiz-question"></h2>

    <div class="quiz-choices"></div>

    <!-- Commentaire selon si le choix est le bon ou non  -->
    <div class="quiz-comment"></div>

    <!-- On nous propose de valider pour sélectionner une option 
    Puis dans un deuxieme temps le bouton affichera suivant pour 
    passer à la question suivante  -->
    <button class="quiz-submit">Valider</button>
    <button class="quiz-next">Suivant</button>

</div>

<script type="module" src="./scripts/quiz.js"></script>





<?php

include "partials/footer.php";

?>
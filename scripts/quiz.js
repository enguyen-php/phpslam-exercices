// En alliant JS et HTML / PHP on veut coder un quiz dynamique qui 
// nous demande les capitales de pays du monde et nous attribue un score /20

// Lors de chaque tour on doit trouver la capitale du pays en question parmi 4 choix 
// -> 1 bonne réponse, er 3 aléatoires mais qui partagent la meme zone géographique

// A l'issue des 20 questions le quiz s'arrete : "Fin du quiz, vous avez eu xx/20"
// Aussi un bouton recommencer doit apparaitre et recharger le jeu lorsque l'on clique 

// -> Piocher aléatoirement 3 capitales par question et zone en plus de la bonne
// -> On pourra utiliser Math.random() combiné avec Math.floor()
// -> Il faudra générer 3 fois un index aléatoire dans une portée donnée (pas de répétition)
// -> Et aussi ajouter la bonne réponse et bien mélanger les choix multiples 

// -> Il faudra générer une phrase type -> Quelle est la capitale de xxx ?
// -> Il faudra aussi un bouton de confirmation après avoir choisi un des choix 
// -> Afficher un message selon la réponse : si mauvaise réponse surligner le bon choix en vert 
// -> Avoir un bouton une fois ces séquences passées qui permette de passer à la question suivante

// -> Afficher pour chaque tour / question le score 

// A la toute fin le score final et un bouton "recommencer"

import countries from '../pays-capitales.json' with { type: 'json' };

// Je recup mon tableau avec tous les pays dans la variable countries 
console.log(countries)
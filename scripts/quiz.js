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

// J'importe le tableau de type JSON en le rendant exploitable en JS 
import countries from '../pays-capitales.json' with { type: 'json' };

// Je recup mon tableau avec tous les pays dans la variable countries 
console.log(countries)

// Récupération des élémnets de ma page HTML afin de les manipuler 
const container = document.querySelector(".quiz")
const question = document.querySelector(".quiz-question")
const score = document.querySelector(".quiz-score")
const choices = document.querySelector(".quiz-choices")
const questionNumber = document.querySelector(".quiz-number")
const comment = document.querySelector(".quiz-comment")
const submit = document.querySelector(".quiz-submit")

window.addEventListener("DOMContentLoaded", () => {
    initQuiz()
})

function fetchRandomCountry() {
    let index = Math.floor(Math.random() * countries.length)
    let currentCountry = countries[index]

    // On enlève également le pays tiré en premier lieu des choix possibles (éviter les doublons)
    let otherCountries = countries.splice(index, 1)
    
    // On vient créer un tableau avec seulement des pays de la meme zone que celui tiré
    otherCountries = countries.filter(country => country.zone == currentCountry.zone)

    // On crée un tableau de réponse avec la "bonne" réponse pour commencer 
    let answers = [currentCountry.capitale]

    for (let i=0; i < 3; i++) {
        let index = Math.floor(Math.random() * otherCountries.length)

        // On ajoute à chaque tour une capitale au tableau de réponse
        answers.push(otherCountries[index].capitale)

        // On enlève à chaque tour le pays précedemment tiré des choix possibles
        otherCountries.splice(index, 1)
    }

    // On vient mélanger avec une fonction de shuffle les réponses proposées
    // Ci-dessous j'ai donc 4 réponses mélangées dont la bonne dans un tableau 
    answers = shuffle(answers)

    // Je regroupe les infos pertinentes à utiliser dans ma fonction initQuiz()
    let countryObject = {
        current: currentCountry,
        options: answers
    }

    return countryObject  
    
}

function initQuiz() {
    //// On affiche les éléments du jeu 
    // Génerer une première question aléatoire depuis notre fichier json

    // randomCountry est l'objet qui contient toutes les infos dont nous avons besoin
    let randomCountry = fetchRandomCountry()

    console.log(randomCountry)

    // Générer aussi les réponses possibles (4 au total)

    // Pour chacun des boutons générés on devra les "écouter"
    // Quand on clique sur le bouton que se passe-t-il ?
    // -> On vient verifier si la réponse est la bonne 

    // Si la réponse est la bonne => 
    // On affiche un message de succès (en vert)
    // + le bouton confirmer le choix qui deviendrait question suivante
    // + On ajoute +1 au score 
    
    // Si la réponse est la mauvaise =>
    // Message d'éhec (en rouge)
    // Meme chose pour le bouton 



}


function shuffle(array) {
    for (let i = array.length - 1; i > 0; i--) {
      // Generate a random index j such that 0 ≤ j ≤ i
      const j = Math.floor(Math.random() * (i + 1));
      // Swap elements at indices i and j
      [array[i], array[j]] = [array[j], array[i]];
    }
    return array;
  }
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

const question = document.querySelector(".question")

window.addEventListener("DOMContentLoaded", () => {
    quiz()
})

function quiz() {
    let quizAnswer = countries[Math.floor(Math.random() * 194)]

    let quizCountry = quizAnswer.pays

    let quizCapital = quizAnswer.capitale

    let quizGoodAnswer = Math.floor(Math.random() * 4)

    let ans1 = countries[Math.floor(Math.random() * 194)].capitale
    let ans2 = countries[Math.floor(Math.random() * 194)].capitale
    let ans3 = countries[Math.floor(Math.random() * 194)].capitale
    let ans4 = countries[Math.floor(Math.random() * 194)].capitale

    if (quizGoodAnswer == 0) {
        ans1 = quizCapital
    } else if (quizGoodAnswer == 1) {
        ans2 = quizCapital
    } else if (quizGoodAnswer == 2) {
        ans3 = quizCapital
    } else {
        ans4 = quizCapital
    }

    let quizDiv = document.createElement("div")

    quizDiv.innerHTML = `<h1>Question :</h1>`

    let choice1 = document.createElement("div")
    let choice2 = document.createElement("div")
    let choice3 = document.createElement("div")
    let choice4 = document.createElement("div")

    choice1.innerHTML = `<input type="radio" name="capital" />` + " " + ans1
    choice2.innerHTML = `<input type="radio" name="capital" />` + " " + ans2
    choice3.innerHTML = `<input type="radio" name="capital" />` + " " + ans3
    choice4.innerHTML = `<input type="radio" name="capital" />` + " " + ans4

    quizDiv.append(choice1, choice2, choice3, choice4)

    question.append(quizDiv)
}
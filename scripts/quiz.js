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
let container = document.querySelector(".quiz")
let question = document.querySelector(".quiz-question")
let score = document.querySelector(".quiz-score")
let choices = document.querySelector(".quiz-choices")
let questionNumber = document.querySelector(".quiz-number")
let comment = document.querySelector(".quiz-comment")
let submit = document.querySelector(".quiz-submit")
let next = document.querySelector(".quiz-next")

// On attend que la page charge tous ses éléments avant de lancer le jeu
window.addEventListener("DOMContentLoaded", () => {
    initQuiz()
})

console.log(typeof comment.textContent)

// Fonction qui génère l'objet contenant le payx les options et autres infos nécessaires 
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


// TODO : 

// - Pouvoir enchainer les questions et stopper à la 20eme ou on nous propose de recommencer le jeu...
// Une boucle est tout indiquée (for ? while ?)
// - Pkoi pas améliorer avec du CSS / Tailwind 


// Fonction de jeu 
function initQuiz() {
    //// On affiche les éléments du jeu 
    // Génerer une première question aléatoire depuis notre fichier json
    let points = 0;
    let pastCountries = []
    let rounds = 1

    score.textContent = points
    questionNumber.textContent = rounds

    // for (let i = 1; i <= 20; i++) {
    //     let country = createQuestion()
    //     pastCountries.push(country.current.pays)
    //     rounds += 1
    // }
    createQuestion(points, rounds, pastCountries)
}


function createQuestion(points, rounds, pastCountries) {
    // On réinitialise les infos liées à la question
    choices.innerHTML = ""
    comment.textContent = ""
    let submitClone = submit.cloneNode(true)

    let countryObject = fetchRandomCountry()

    while (pastCountries.includes(countryObject.current.pays)) {
        countryObject = fetchRandomCountry()
    }

    // On ajoute le pays en cours au tableau de l'historique des pays 
    pastCountries.push(countryObject.current.pays)

    // On affiche la première question aka le premier pays  
    question.textContent = countryObject.current.pays
    

    // Générer aussi les réponses possibles (4 au total)
    countryObject.options.forEach(option => {
        let quizBtn = document.createElement("button")
        quizBtn.textContent = option

        // Pour chacun des boutons générés on devra les "écouter"+
        quizBtn.addEventListener("click", () => {
            // On enlève la classe selected à l'ensemble des buttons ...
            choices.querySelectorAll("button").forEach(choice => {
                choice.classList.remove("selected", "bg-blue-600")
            }) 
            // ... avant de la rajouter au dernier bouton cliqué
            quizBtn.classList.add("selected", "bg-blue-600")
        })

        choices.appendChild(quizBtn)
    }) 

    // Ecouter le bouton de submit -> Quand on clique dessus on vérifie la répobnse fournie
    submitClone.addEventListener("click", () => {
        let selectedOption = document.querySelector(".selected")

        // Vérification de la réponse 
        if (selectedOption.textContent == countryObject.current.capitale) {
            comment.textContent = "Bravo c'est la bonne"
            selectedOption.classList.add("bg-green-600")

            points += 1
            score.textContent = points

        } else {
            comment.textContent = "Bouh c'est mauvais"
            selectedOption.classList.add("bg-red-500")
        }

        

        // Passage à la question suivante 
        if (comment.textContent != null) {
            next.addEventListener("click", () => {
                if (rounds < 20) {
                    rounds += 1
                    createQuestion(points, rounds, pastCountries)
                } else {
                    container.innerHTML = "fin"
    
                }
            })
        }
    })

    submit.replaceWith(submitClone)

    return countryObject

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
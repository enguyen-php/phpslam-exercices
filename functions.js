// Coder une fonction qui interroge l'un de vous au hasard ...
// BONUS : ne pas permettre qu'un meme nom ressorte 2 fois de suite

let students = ["Bastien", "Nohlan", "Soen", "Ethan", "Mathis", "Amine", "Thomas"];

function pickRandomStudent() {
    
    let random = Math.floor(Math.random() * students.length)

    let randomStudent = students[random]  

    students.splice(random, 1)

    if (students.length) {

        return randomStudent

    } else {

        return "Tous les élèves ont été déjà interrogés"
 
    }
}

console.log(pickRandomStudent())
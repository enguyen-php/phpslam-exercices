// ANIMATION SUPPRESSION COMMENTAIRE

// Je récupère l'ensemble de icones la croix qui permettent de supprimer un comment
const crossBtn = document.querySelectorAll(".cross-btn")

// Pour chaque icone de type croix je viens écouter lorsque le user clique
crossBtn.forEach(btn => {
    btn.addEventListener("click", () => {
        // Lors du click je viens ajouter les classes afin d'animer ma div de comment 
        // en accédant au grand-grand-parent de mon icone de fermeture 
        btn.parentNode.parentNode.parentNode.classList.add("animate__animated",  "animate__bounceOut")
    })
})

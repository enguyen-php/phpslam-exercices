<?php

// Exos Intro PHP

// Exercice if ... selse avec l age
$age = 57;

if ($age < 18) {
    $message = "Encore mineur";
} else if ($age < 30) {
    $message = "Enfin majeur";
} else if ($age < 50) {
    $message = "¨Premiers cheveux blancs";
} else if ($age < 60) {
    $message = "Bientot les petits enfants";
} else {
    $message = "Bientot la retraite";
}

// echo $message;


// Le cadavre exquis 

// Tableaux à utiliser comme arguments lors de l'appel de la fonction
$substantif = [ "le cadavre", "le tracteur", "Le pigeon", "La grand-mère" ];
$adjectif = [ "exquis", "jaune", "flexible", "excentrique" ];
$verbe = [ "mange", "évite", "partage", "rencontre" ];

// scgéma à suivre : substantif + adjectif + verbe + substantif + adjectif
// Pour l'aléatoire utiliser mt_rand(0, 10) -> retourne un nombre aléaatoire entre 0 et 10

// Objectif : écrire la fonction qui retournera une phrase aléatoire à chaque fois
// cette fonction pourra prendre en paramètre un tableau.


function randomWord($array) {
    // Créer une variable qui vient générer un chiffre aléatoire entre 0 le dernier index du tableau
    // count($array) correspond aux nombre d'éléments du tableau, on enlève 1 pour obtenir le dernier index
    $nombre_aleatoire = mt_rand(0, count($array) - 1);

    // En utilisant l'index aléatoire on retourne un mot aléatoire
    return $array[$nombre_aleatoire];
}

// On peut appeller plusieurs fois notre fonction pour construire la phrase
// On vient concaténer (cad coller) différents appels de la fonction qui correspondent à un mot à chaque fois
// echo randomWord($substantif) . " " . randomWord($adjectif) . " " . randomWord($verbe) . " " . randomWord($substantif) . " " . randomWord($adjectif);


// Convertisseur de devises 

// Coder une fonction qui permettent les changes suivants : 

// EUR -> USD // 1eur =  1.17$
// EUR -> JPY // 1 eur = 183Y
// EUR -> BP // 1 eur = 0.87£

// Elle prend 2 paramètres : le montant et la devise de destination (USD, BP ou JPY)
// Vous trouverez les taux sur Internet ...

// Déclaration 

function converter($devise, $montant) {
    // On crée d'abord un tableau associatif $conversions qui regroupe le nom des devises et le taux de conversion
    $conversions = [ "USD" =>  1.17, "JPY" => 183, "GBP" => 0.87 ];

    // On utilise une condition pour vérifier si le montant est bien poitif 
    // et si la devise existye bien en tant que clé dans le tableau  
    if ($montant > 0 && array_key_exists($devise, conversions)) {

        // On déclare une variable pour le nouveau montant : montant * taux de conversion
        $new_montant = $montant * $conversions[$devise];

        // On retourne le résultat
        return $new_montant;
    } else {
        // Gestion des cas d'erreur 
        return "Montant inadequat ou devise non prise en charge";
    }
} 

// Appel de la fonction (et echo qui permet d'afficher le résultat)
// echo converter("GBP", 55687);

// Exercices sur les fonctions utiles en PHP

// 1 - Fonction pour Palindrome 

function IsPalindrome($tableau) {
    // On vient vérifier que le paramètre reçu est bien de type tableau (array)
    // Sinon on renvoie un message d'erreur
    if (!is_array($tableau)) {
        return "Le param n'est pas un tableau";
    }

    // On crée une copie du tableau dont l'ordre est inversé
    $reverse = array_reverse($tableau);
    // On return la comparaison entre tableau d'origine et version inversée 
    // Cela nous donnera bien true ou false 
    return $tableau === $reverse;
}

$tableau = "bonjour";

// echo IsPalindrome($tableau);

// 2 - Remplacement de caractères 

function replaceAbyB($mot) {
    return str_replace("a", "b", $mot);
}

// echo replaceAbyB("babar");

// 3 - Conversion string -> array

function strToArray($string) {
    if (!is_string($string)) {
        return "Le param n'est pas une string";
    }

    return str_split($string);
}

// Avec print_r on affiche le contenu d'un tableau sur notre page
// echo ne marche que pour les strings 
// print_r(strToArray("coucou"));


// 4 - Caractères spéciaux HTML

echo htmlspecialchars("<h1>Bonjour !!</h1>");
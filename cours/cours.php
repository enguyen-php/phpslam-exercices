<?php

// Declaration de variables en PHP 
$name = "Romain";
$number = 32;
$boolean = true;

// Tableau et tableau associatif 
$array = ["mat", 23, "toto"];
$associative = ["name" => "toto", "age" => 25, "ville" => "Nantes"];



// Inspecter le type d'une variable avec var_dump()
// Ici echo va permettre d'afficher 'string' (le type de la variable $name)
echo var_dump($name); 

// ici va afficher Romain avec echo (permet d'afficher des strings)
echo $name;

// On affiche un élément d'un tableau grace à son index entre crochets 
// Rappel : l'index commence à zéro 
echo $array[0]; 

// Comment afficher "toto"
echo $array[2];

// On peut l'afficher aussi avec le tableau associatif 
echo $associative["name"];

// Pour ajouter un élément à la fin d'un tableau 
$array[] = "coucou";

// On déclare les constantes avec const - possible avec DEFINE(CONSTANTE, "valeur de la constante")
const constante = "Une constante, sa valeur de change pas";

// Les conditions, les boucles etc
$condition = 4;
$bool = false;

if ($condition > 3) {
    echo "La condition est validée";
} else {
    echo "La condition n'est pas validée";
}

// Pour avoir une condition ET une autre on utilise &&
if ($condition > 2 && $bool == false) {
    echo "Nos conditions sont validées";
} else {
    echo "les conditions ne sont pas validées";
}

// Pour avoir une condition OU une autre on utilise ||
if ($condition > 2 || $bool == true) {
    echo "L'une des conditions est validée";
} else {
    echo "Aucune des conditions n'est validée";
}

// Boucle for répète des instructions 
for ($i = 0; $i < 4; $i ++) {
    echo "i vaut : $i<br>";
}

// La boucle foreach permet de boucler dans un tableau associatif 
// $associative = ["name" => "toto", "age" => 25, "ville" => "Nantes"];
foreach($associative as $cle=>$valeur) {
    echo "La clé est " . $cle . ", elle a pour valeur " . $valeur . "<br>"; ;
}

// LES FONCTIONS 

// 1 - Déclaration de la fonction 
function writeHello($param) {
    return "Bonjour $param !";
}

// 2 - Appel de la fonction : elle va afficher Bonjour Tom !
echo writeHello("Tom");

//// Fonctions de gestion de variable : isset() et empty()

$novalue;
$empty = '';
$null = null;
$false = false;

// Cas de figure pour isset() -> diff de NULL et déclarée
var_dump(isset($novalue)); // true
echo "<br>";
var_dump(isset($empty)); // true
echo "<br>";
var_dump(isset($null)); // false
echo "<br>";
var_dump(isset($false)); // true
echo "<br>";
var_dump(isset($x)); // false
echo "<br>";

// Cas de figure pour empty() -> si variable "vide", valide dans tous ces cas de figure
var_dump(empty($novalue)); // true
echo "<br>";
var_dump(empty($empty)); // true
echo "<br>";
var_dump(empty($null)); // true
echo "<br>";
var_dump(empty($false)); // true
echo "<br>";
var_dump(empty($x)); // true
echo "<br>";

// Fonctions PHP à utiliser sur les tableaux : in_array(), array_reverse(), array_key_exists() ...

$other_array = ["jim", 1898, "jim"];

echo in_array(32, $other_array);


?>


<?php 

// POO en PHP : Programmation Orientée Objet
// Les classes comportent des attributs et des méthodes -> en fait des variables et des fonctions +
// Dans l'exemple de User on regroupe au sein de cette classe tous les attributs et fonctoins liées au user

// Les classes permettenty de générer des objets 

// Le nom des classes doit etre en PascalCase (à ne pas confondre avec le camelCase)
class User {
    // Attributs ou propriétés cad des variables associées au User
    // Ici le private est la portée de notre prorpriété. Ces propriétés peuvent etre : 
    // public, protected ou private
    public $name = "Patrick";
    public $age = 23;
    private $email;

    // Méthodes qui sont en fait des fonctions liées au User
    public function sayHello() {
        return "Bonjour $this->name tu as $this->age ans";
    }

    // Fonction de type Getter 
    public function getEmail() {
        return $this->email;
    }

    // fonction de type setter 
    public function setEmail($email) {
        $this->email = $email;
    }
}


class SuperUser extends User {
    public $avatar;
}

// Pour générer un objet on doit "instancier" notre classe
// Ici je génère un objet "$patrick" à partir de la classe User avec le mot clé new
$patrick = new User;

// echo $patrick->name; // Censé m'afficher "Patrick"
// echo $patrick->sayHello(); // Affiche "Bonjour"

// Exercice POO - Voiture 

// Déclaration de la classe 
class Voiture {
    // Attributs publics
    private string $brand;
    private string $color;
    private int $power; 
    private int $speed = 0; 
    public static $engine = "V8";


    // Fonction de type Constructor
    public function __construct($marque, $color) {
        $this->brand = $marque;
        $this->color = $color;
    }

    // Les méthodes (ou fonctions)
    public function accelerate() {
        $this->speed += 50;
        return "La $this->brand de couleur $this->color roule à $this->speed km/h<br>";
    }

    public function freiner() {
        if ($this->speed > 0) {

            $this->speed -= 50;
            return "La $this->brand de couleur $this->color roule à $this->speed km/h<br>";

        } else {
            return "La voiture est à l'arret<br>";
        }
    }

    // Ceci est une fonction de type getter, elle permet d'accèder à des attributs privés en dehors de la classe
    public function getBrand() {
        return $this->brand;
    }

    // ceci est une fonction de type setter -> Elle permet de changer la valeur d'attribut privés en dehors de la classe
    public function setBrand($brand) {
        $this->brand = $brand;
    } 

    // exemple de méthode statique -> On peut appeller ce genre de méthode sans avoir à instancier notre classe
    public static function sayBye() {
        return "Au revoir !";
    }
}

// Instanciation de la classe -> création d'objets.
$citroen = new Voiture("citroen", "verte");
$jaguar = new Voiture("jaguar", "verte");
$renault = new Voiture("renault", "verte");

// echo $jaguar->brand; // Fatal error -> car $brand est un attribut privé
echo $jaguar->getBrand(); // Là on est bon !

// Ici on appelle notre méthode statique sans avoir besoin d'instancier la classe 
// au préalable
Voiture::sayBye();


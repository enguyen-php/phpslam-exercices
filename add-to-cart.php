<?php 

    // PAGE DE TYPE "TUNNEL" qui nous permet de déterminer le process d'ajout d'un element à notre panie
    
    session_start();

    include "config/db.php";
    include "partials/check-session.php";
    include "config/cURL.php";


    if (isset($_GET["id"])) {

        // On récupère l'id du produit à ajouter dans le panier via l'URL
        $productId = $_GET["id"];

        // Vérifier si notre user possède déjà un panier en BDD dans la table cart...
        $sql = "SELECT * FROM cart WHERE id_user = ?";

        $stmt = $db->prepare($sql);
        $stmt->execute([$_SESSION["id"]]);  
        $res = $stmt->fetch();

        // On associe à une variable $products ce que l'on récupère de l'API
        $products = connectToAPI("https://fakestoreapi.com/products/");


        // SI on a bien un panier déjà enresgitré en BDD ...
        if ($res) {
            // On écrit la requete qui vient mettre à jour la colonne content 
            // Cette colonne content contient tous nos produits et lmeurs infos respectives en format json
            $sqlUpdate = "UPDATE cart SET content = ? WHERE id_user = ?";

            // On recup le contenu du panier depuis la BDD ($content) et on le convertir depuis JSON 
            // afin de pouvoir exploiter ces données 
            $content = json_decode($res["content"], true);

            // On ajoute à notre tableau content les infos du produit récemment ajouté
            $content[] = $products[$productId - 1];

            // Juste avant de transmettre le content mis à jour de notre cart en BDD 
            // On l'enregistre en parallèle en Session
            $_SESSION["cart"] = $content;

            // On remet notre tableau $content au format json afin de le renvoyer en BDD 
            // et mettre à jour la bonne cellule
            $content = json_encode($content);

            // var_dump($content);
            // die();

            // On prepare, execute et on recup la réponse de la BDD 
            // Si tout est bon on redirige vers la page d'item et on précise 
            // dans les params de l'URL : status=success -> nous permettra d'afficher 
            // un message de confirmation sur la page du produit 
            $stmtUpdate = $db->prepare($sqlUpdate);
            $stmtUpdate->execute([$content, $_SESSION["id"]]);  
            $res = $stmtUpdate->fetch();

            header("Location: shop.php?id=$productId&status=success");

        } else {
            // Cas ou il faut aussi créer le panier dans la BDD 
            // Requete pour créer un panier dans la table cart
            $sqlCreate = "INSERT INTO cart(content, id_user) VALUES(?, ?)";

            // Juste avant de transmettre le content mis à jour de notre cart en BDD 
            // On l'enregistre en parallèle en Session
            $_SESSION["cart"] = $content;

            // On ajoute au tableau vide $content les infos du produit désiré 
            $content = json_encode([$products[$productId - 1]]);


            // On prépare + execute la requete avant de rediriger vers notre page de produit
            $stmtCreate = $db->prepare($sqlCreate);
            $stmtCreate->execute([$content, $_SESSION["id"]]);  

            // var_dump($content);
            // die();
            // $resCreate = $stmtCreate->fetch();

            header("Location: shop.php?id=$productId&status=success");
        }
    } else {
        header("Location: shop.php");
        exit();
    }

?>
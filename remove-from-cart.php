<?php 

session_start();
include "config/db.php";
include "partials/check-session.php";

// On vérifie que l'on recup bien l'id du produit à supprimer dans l'URL 
if (isset($_GET["id"])) {

    // Logique de suppression avec req SQl 

    // On récupère l'id du produit à ajouter dans le panier
    $productId = $_GET["id"];

    // Vérifier si notre user possède déjà un panier en BDD dans la table cart...
    $sql = "SELECT * FROM cart WHERE id_user = ?";

    // On recup les infos liées au panier 
    $stmt = $db->prepare($sql);
    $stmt->execute([$_SESSION["id"]]);  
    $res = $stmt->fetch();

    // On vérifie que l'on ait bien une réponse si oui on enchaine  
    if ($res) {

        // On recup le content que l'on traduit depuis json 
        $content = json_decode($res["content"], true);

        // On peut parcourir le Tableau reçu pui schercher l'id du produit en question 
        // et le supprimer du contenu avec unset()
        foreach($content as $key=>$item) {

            // Si un item correspond à l'id transmis
            // on le supprime du tableau en passant par la clef ici $key 
            if ($item["id"] == $productId) {
                unset($content[$key]);
            }
        }

        // On va transmettre notre tableau modifié à la BDD 
        // Requete SQL pour modifier le panier (son content en particulier)
        $sqlUpdate = "UPDATE cart SET content = ? WHERE id_user = ?";


            // Juste avant de transmettre le content mis à jour de notre cart en BDD 
        // On l'enregistre en parallèle en Session
        $_SESSION["cart"] = $content;

        // On reconcvertit vers JSON avant d'envoyer 
        $content = json_encode($content);

        // On recup les infos liées au panier 
        $stmt = $db->prepare($sqlUpdate);
        $stmt->execute([$content, $_SESSION["id"]]);  
        
        header("Location: cart.php");
        exit();
    }
} else {
    header("Location: cart.php");
    exit();
}

?>

<?php 
// On s'assure qu'une personne non login ne puisse pas accéder à la page 
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

?>
<?php 
session_start();
include 'classes.php'; 

$db = new BDD();

// Vérifier si l'utilisateur est connecté, sinon rediriger vers la page de connexion
if (!isset($_SESSION["user_id"]) || !isset($_SESSION["pseudo"]) || ($_SESSION["role"] !== "quizzer" && $_SESSION["role"] !== "admin")) {
    header("location: connexion.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

</body>
</html>
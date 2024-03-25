<?php 
session_start();
include 'classes.php'; 

$db = new BDD();
// Vérifier si l'utilisateur est connecté, sinon rediriger vers la page de connexion
// if (!isset($_SESSION["user_id"]) || !isset($_SESSION["pseudo"]) || ($_SESSION["role"] !== "quizzer" && $_SESSION["role"] !== "admin")) {
//     header("location: connexion.php");
//     exit();
// }
if (isset($_GET['id_quizz'])) {
    $id_quizz = $_GET['id_quizz'];
    echo "ID du quiz récupéré depuis l'URL : " . $id_quizz . "<br>";  // Afficher l'ID du quiz pour vérification
    
    // Récupérer les questions pour ce quizz
    $query = "SELECT * FROM questions WHERE id_quizz = :id_quizz";
    $statement = $db->connection->prepare($query);
    if (!$statement->execute(array(':id_quizz' => $id_quizz))) {
        die("Erreur lors de l'exécution de la requête : " . $statement->errorInfo()[2]);
    }
    $questions = $statement->fetchAll(PDO::FETCH_ASSOC);
    echo "Nombre de questions récupérées : " . count($questions) . "<br>";
}else{
    echo "id quizz non trouvé dans l'url";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h1>Quizz</h1>
<form action="score.php"  method="post">
<?php

if (isset($questions) && !empty($questions)) {
    foreach ($questions as $question) {
        echo "<h2>" . $question['question'] . "</h2>";  // Afficher la question
        
        // Récupérer les réponses pour cette question
        $query = "SELECT * FROM reponses WHERE id_question = :id_question";  // Requête pour récupérer les réponses
        $statement = $db->connection->prepare($query);
        $statement->execute(array(':id_question' => $question['id_question']));  // Utiliser l'ID de la question
        $reponses = $statement->fetchAll(PDO::FETCH_ASSOC);
        shuffle($reponses);
        foreach ($reponses as $reponse) {
            echo '<input type="radio" name="reponse_' . $question['id_question'] . '" value="' . $reponse['id_reponse'] . '">';
            echo "<label>" . $reponse['reponses'] . "</label><br>";  // Afficher la réponse
        }
        

    }
    echo '<input type="submit" value="Soumettre">';
} else {
    echo "<p>Aucune question trouvée pour ce quizz.</p>";
}

?>
</form>
</body>
</html>

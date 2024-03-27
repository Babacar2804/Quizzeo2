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
    
    // Récupérer les questions pour ce quizz
    $query = "SELECT * FROM questions WHERE id_quizz = :id_quizz";
    $statement = $db->connection->prepare($query);
    if (!$statement->execute(array(':id_quizz' => $id_quizz))) {
        die("Erreur lors de l'exécution de la requête : " . $statement->errorInfo()[2]);
    }
    $questions = $statement->fetchAll(PDO::FETCH_ASSOC);
}else{
    echo "id quizz non trouvé dans l'url";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Title</title>
    <link rel="stylesheet" href="../CSS/style.css">
</head>

<body data-barba="wrapper">
    <?php include 'nav.php'; ?>

    <div class="pages" data-barba="container" data-barba-namespace="home">
        <h1><span></span><span></span><span></span><span></span><span></span> Quizz</h1>
        <!-- Mettre dans les span les lettres du mot de la page pour l'effet d'apparition -->
        <form action="score.php?id_quizz=<?php echo $id_quizz; ?>"  method="post">
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

    </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js"></script>
    <script src="https://unpkg.com/@barba/core"></script>
    <script src="../js/app.js"></script>
    <script src="../js/script.js"></script>
</body>

</html>

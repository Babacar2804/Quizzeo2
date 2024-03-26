<?php 
session_start();
include 'classes.php';

$db = new BDD();
$quizzer=new Quizzer($db);
$id_user=$_SESSION['user_id'];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $score = 0;
    
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'reponse_') !== false) {  // Vérifier si la clé correspond à une réponse
            $id_question = str_replace('reponse_', '', $key);  // Récupérer l'ID de la question à partir de la clé
            $id_reponse = $value;  // Récupérer l'ID de la réponse sélectionnée

            // Récupérer la première réponse pour cette question (la bonne réponse)
            $query = "SELECT * FROM reponses WHERE id_question = :id_question ORDER BY id_reponse ASC LIMIT 1";
            $statement = $db->connection->prepare($query);
            $statement->execute(array(':id_question' => $id_question));
            $reponse = $statement->fetch(PDO::FETCH_ASSOC);
            $quizzer->insert_reponse_user($id_user, $id_question, $id_reponse,'correcte');
            if ($reponse && $reponse['id_reponse'] == $id_reponse) {
                $score++;  // Incrémenter le score si la réponse sélectionnée est la bonne réponse
            }
        }
    }

    echo "Votre score est de : " . $score . " sur " . count($_POST) . " questions.";
} else {
    header("location: index.php");  // Rediriger vers la page d'accueil si la méthode HTTP n'est pas POST
}
?>
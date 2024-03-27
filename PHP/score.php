<?php 
session_start();
include 'classes.php';
var_dump($_SESSION);
$db = new BDD();
$quizzer = new Quizzer($db);
$id_user = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;


if ($id_user && $_SERVER["REQUEST_METHOD"] == "POST") {
    $score = 0;
    
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'reponse_') !== false) {
            $id_question = str_replace('reponse_', '', $key);
            $id_reponse = $value;

            // Vérifiez si c'est la première réponse correcte
            $query = "SELECT * FROM reponse_user WHERE id_user = :id_user AND id_question = :id_question";
            $statement = $db->connection->prepare($query);
            $statement->execute(array(':id_user' => $id_user, ':id_question' => $id_question));
            $result = $statement->fetch(PDO::FETCH_ASSOC);

            if (!$result) {
                $is_correct = $quizzer->insert_reponse_user($id_user, $id_question, $id_reponse);
            } else {
                $is_correct = $result['is_correct'];
            }

            if ($is_correct) {
                $score++;
            }
        }
    }
    // Affichez le score
    echo "Votre score est de : " . $score . " sur " . count($_POST) . " questions.";
} else {
    echo "erreur";
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

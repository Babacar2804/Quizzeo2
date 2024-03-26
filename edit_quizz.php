<?php 
session_start();

require 'classes.php';
$db = new BDD();
$user_id = $_SESSION['user_id'];
$quizzer=new Quizzer($db);
//Récupérer les quizz


// Vérifiez si l'ID du quizz à mettre à jour est défini



// Vérifiez si l'ID du quizz à mettre à jour est défini
if (isset($_GET['id_quizz'])) {
    $id_quizz = $_GET['id_quizz'];
    // Récupérer les données du quizz
$queryQuizz = "SELECT * FROM quizzes WHERE id_quizz = :idQuizz";
$paramsQuizz = [':idQuizz' => $id_quizz];
$stmt = $db->connection->prepare($queryQuizz);
$stmt->execute($paramsQuizz);
$quizzData = $stmt->fetch(PDO::FETCH_ASSOC);

// Récupérer les questions du quizz
$queryQuestions = "SELECT * FROM questions WHERE id_quizz = :idQuizz";
$paramsQuestions = [':idQuizz' => $id_quizz];
$stmt = $db->connection->prepare($queryQuestions);
$stmt->execute($paramsQuestions);
$questions = $stmt->fetchAll(PDO::FETCH_ASSOC);
if (isset($_POST['submit'])) {
    $titre = $_POST['titre'];
    $date_creation = date('Y-m-d');
    $type = $_POST['typeQuizz'];

    // Utilisez la fonction de mise à jour pour mettre à jour le quizz
    $quizzer->updateQUizz($titre,$date_creation,$type);

    // Supprimez toutes les questions et réponses existantes pour ce quizz
    $deleteQuestionsQuery = "DELETE FROM questions WHERE id_quizz = :id_quizz";
    $paramsDelete = [':id_quizz' => $id_quizz];
    $stmt = $pdo->prepare($deleteQuestionsQuery);
    $stmt->execute($paramsDelete);

    // Insérer les nouvelles questions et réponses
    foreach ($questions as $index => $question) {
        try {
            $id_question = $quizzer->insert_question($question, $id_quizz);

            if ($id_question) {
                // Récupération des réponses
                $reponses = $_POST["reponses_" . ($index + 1)];

                // Insérer les réponses
                foreach ($reponses as $reponse) {
                    $quizzer->insert_reponse($reponse, $id_question);
                }
            } else {
                echo "La question ne peut pas être ajoutée";
                break;
            }
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            break;
        }
    }
}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="script.js"></script>
</head>
<body>
<h1>Modifier Quizz</h1><br>
<form action="" method="post">
    <label for="titre">Titre du Quizz :</label><br>
    <input type="text" id="titre" name="titre" required value="<?php echo $quizzData['titre']; ?>"><br><br>


    <div id="questionsContainer">
        <!-- Les champs de question et de réponse seront ajoutés ici -->
    </div>
    <input type="hidden" id="QuizzInput" name="typeQuizz" value="">
    <!-- <button type="button" id="QCMButton" onclick="showQCM()">Ajouter un QCM</button>
    <button type="button" id="SondageButton" onclick="showSondage()">Ajouter un Sondage</button> -->
    <br><br>
    <input type="submit" name="submit" value="Modifier le Quizz">
</form>
</body>
</html>

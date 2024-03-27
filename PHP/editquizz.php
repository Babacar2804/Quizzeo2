<?php
session_start();
require 'classes.php';
$db = new BDD();
$quizzer = new Quizzer($db);

if (isset($_GET['id_quizz'])) {
    $id_quizz = $_GET['id_quizz'];

    $quizzDatas = $quizzer->getQuizzData($id_quizz);
    $questions = $quizzer->getQuestions($id_quizz);

    if (isset($_POST['submit'])) {
        $titre = $_POST['titre'];
        $date_creation = date('Y-m-d');
        $type = $_POST['typeQuizz'];

        $quizzer->updateQuizz($titre, $date_creation, $type, $id_quizz);
        $quizzer->deleteQuestions($id_quizz);

        // Insérer les nouvelles questions et réponses
        foreach ($_POST['questions'] as $index => $questionData) {
            $question = $questionData['question'];
            $id_question = $quizzer->insertQuestion($question, $id_quizz);

            if ($id_question) {
                foreach ($questionData['reponses'] as $reponse) {
                    $quizzer->insertReponse($reponse, $id_question);
                }
            } else {
                echo "La question ne peut pas être ajoutée";
                break;
            }
        }
        header("Location: quizzer.php");
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Quizz</title>
    <script src="../js/script.js"></script>
</head>
<body>
<h1>Modifier Quizz</h1><br>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id_quizz=' . $id_quizz; ?>" method="post">
    <label for="titre">Titre du Quizz :</label><br>
    <input type="text" id="titre" name="titre" required value="<?php echo $quizzDatas['titre']; ?>"><br><br>

    <!-- Afficher les questions existantes -->
    <?php foreach ($questions as $index => $question): ?>
        <div class="questionContainer">
            <label for="question_<?php echo $index; ?>">Question :</label><br>
            <input type="text" id="question_<?php echo $index; ?>" name="questions[<?php echo $index; ?>][question]" required value="<?php echo $question['question']; ?>"><br><br>
            
            <!-- Afficher les réponses existantes -->
            <?php
            $queryReponses = "SELECT * FROM reponses WHERE id_question = :idQuestion";
            $paramsReponses = [':idQuestion' => $question['id_question']];
            $stmt = $db->connection->prepare($queryReponses);
            $stmt->execute($paramsReponses);
            $reponses = $stmt->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <?php foreach ($reponses as $repIndex => $reponse): ?>
                <input type="text" name="questions[<?php echo $index; ?>][reponses][]" value="<?php echo $reponse['reponses']; ?>">
            <?php endforeach; ?>
            <br><br>
        </div>
    <?php endforeach; ?>

    <!-- Ajouter une nouvelle question -->
    <button type="button" onclick="ajouterQuestion()">Ajouter une question</button>
    
    <input type="hidden" id="QuizzInput" name="typeQuizz" value="">
    <br><br>
    <input type="submit" name="submit" value="Modifier le Quizz">
</form>
</body>
</html>

<?php 
session_start();
include 'classes.php'; 

$db = new BDD();
$quizzer=new Quizzer($db);

$lien = '';
var_dump($_SESSION);
// Récupérez l'ID de l'utilisateur à partir de la variable de session
$id_user = $_SESSION['user_id'];
// Vérifiez si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    var_dump($_POST);
    
    $titre = $_POST["titre"];
    $date_creation = date('Y-m-d');
    $type = $_POST["typeQuizz"];
    
    // Récupération des questions et des réponses
    $questions = $_POST["questions"];
    
    // Utilisez la fonction d'insertion pour ajouter le quizz
    $id_quizz = $quizzer->insert_quizz($id_user, $titre, $date_creation,  $type, $description, $statut_quizz);

    if ($id_quizz) {

        // Insérer les questions et les réponses
        foreach ($questions as $index => $question) {
            // Insérer la question
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
            // Génération du lien unique
            function generateUniqueLink($id_quizz) {
                $caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
                $lien = 'http://localhost/Projet%20Web/Quizzeo2/quizz.php?'."id_quizz=". $id_quizz . '/';
                for ($i = 0; $i < 10; $i++) {
                    $lien .= $caracteres[rand(0, strlen($caracteres) - 1)];
                }
                return $lien;
            }
         $lien = generateUniqueLink($id_quizz);
        
         // Sauvegarde du lien avec le quiz dans la base de données
         $quizzer->saveQuizLink($id_quizz, $lien);
        }
    } else {
        echo "L'insertion du quizz a échoué";
    }

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="../js/script.js"></script>
    <link rel="stylesheet" href="../CSS/style.css">
</head>
<body>
<form action="" method="post">
    <label for="titre">Titre du Quizz :</label><br>
    <input type="text" id="titre" name="titre" required><br><br>

    <div id="questionsContainer">
        <!-- Les champs de question et de réponse seront ajoutés ici -->
    </div>
    <input type="hidden" id="QuizzInput" name="typeQuizz" value="">
    <button type="button" id="QCMButton" onclick="showQCM()">Ajouter un QCM</button>
    <button type="button" id="SondageButton" onclick="showSondage()">Ajouter un Sondage</button>
    <br><br>
    <input type="submit" name="submit" value="Ajouter le Quizz">
    
</form>

</body>
</html>

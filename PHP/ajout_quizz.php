<?php 
session_start();
include 'classes.php'; 

$db = new BDD();
$quizzer=new Quizzer($db);


// Récupérez l'ID de l'utilisateur à partir de la variable de session
$id_user = $_SESSION['user_id'];
// Vérifiez si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    
    $titre = $_POST["titre"];
    $date_creation = date('Y-m-d');
    $type = $_POST["typeQuizz"];
    $status=1;
    // Récupération des questions et des réponses
    $questions = $_POST["questions"];
    
    // Utilisez la fonction d'insertion pour ajouter le quizz
    $id_quizz = $quizzer->insert_quizz($id_user, $titre, $date_creation, $type,$status);

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
    <title>Title</title>
    <script src="../js/script.js"></script>
    <link rel="stylesheet" href="../CSS/style.css">
</head>

<body data-barba="wrapper">
    <?php include 'nav.php'; ?>

    <div class="pages" data-barba="container" data-barba-namespace="home">
        <h1><span></span><span></span><span></span><span></span><span></span> Ajout Du Quizz</h1>
        <!-- Mettre dans les span les lettres du mot de la page pour l'effet d'apparition -->
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

        
    </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js"></script>
    <script src="https://unpkg.com/@barba/core"></script>
    <script src="../js/app.js"></script>
    <script src="../js/script.js"></script>
</body>

</html>

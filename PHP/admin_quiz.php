<?php
session_start();
require 'classes.php';

// Vérification de l'accès admin
if (!isset ($_SESSION['user_id']) || !isset ($_SESSION['user_role']) || $_SESSION['user_role'] != 3) {
    header("Location: 403.php");
    exit();
}
$db = new BDD();
$adminQuiz = new AdminQuiz($db);

// Traitement du formulaire de mise à jour du statut du quiz
if (isset ($_POST['update_status'])) {
    $quiz_id = $_POST['quiz_id'];
    $status = $_POST['status'];

    // Récupération du statut actuel du quiz
    $quiz = $adminQuiz->getQuizzData($quiz_id);
    $current_status = $quiz['status'];

    if ($status == 'inactive') {
        $adminQuiz->updateQuizStatus($quiz_id, $status);
    } else {
        echo "<script>alert('Vous n\'avez pas le droit de réactiver un quiz inactif.');</script>";
    }
}

// Récupération de tous les quizzes
$quizzes = $adminQuiz->Quizzes();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration des Quizzes</title>
    <link rel="stylesheet" href="../CSS/style1.css">
</head>

<body>

    <body data-barba="wrapper">
        <?php include 'nav.php'; ?>
        <div class="pages" data-barba="container" data-barba-namespace="home">
            <h1><span>A</span><span>d</span><span>m</span><span>i</span><span>n</span>
                <span>Q</span><span>u</span><span>i</span><span>z</span><span>z</span> Dashboard
            </h1><br>

            <div class="bigcard">
                <?php foreach ($quizzes as $quiz): ?>
                    <div class="card">
                        <div class="quiz-item">
                            <h3>
                                <?php echo $quiz['titre']; ?>
                            </h3>
                            <p>Statut :
                                <?php echo ($quiz['status'] == 1) ? "Actif" : "Inactif"; ?>
                            </p>
                            <form method="post">
                                <input type="hidden" name="quiz_id" value="<?php echo $quiz['id_quizz']; ?>">
                                <label for="status">Changer le statut :</label><br>
                                <select name="status">
                                    <option value="active" <?php echo ($quiz['status'] == 1) ? 'disabled' : ''; ?>>
                                        Activer
                                    </option>
                                    <option value="inactive">Désactiver</option>
                                </select>
                                <button type="submit" name="update_status">Mettre à jour</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>
        </div>


        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js"></script>
        <script src="https://unpkg.com/@barba/core"></script>
        <script src="../js/app.js"></script>
        <script src="../js/script.js"></script>
    </body>

</html>
<?php
session_start();

require 'classes.php';
$db = new BDD();
$quizz = new Quizzer($db);
$user_id = $_SESSION['user_id'];
$reqs = $quizz->affichquizz($user_id);


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset ($_POST['lance'])) {
        $quiz_id = $_POST['quiz_id'];
        $quizz->updateQuizzStatus($quiz_id, 'lance');
    } elseif (isset ($_POST['termine'])) {
        $quiz_id = $_POST['quiz_id'];
        $quizz->updateQuizzStatus($quiz_id, 'termine');
    }
}
// $quiz_id = $_POST['quiz_id'];
// $quizz->updateQuizzStatus($quiz_id, 'creation');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quizzer Dashboard</title>
    <link rel="stylesheet" href="../CSS/style.css">
</head>

<body data-barba="wrapper">
    <?php include 'nav.php'; ?>

    <div class="pages" data-barba="container" data-barba-namespace="home">
        <h1>
            <span>Q</span><span>U</span><span>I</span><span>Z</span><span>Z</span><span>E</span><span>R</span> Dashboard
        </h1>

        <div class="bigcard">
            <div class="card">
                <h2>Liste des quizzes</h2>
                <ul>
                    <?php foreach ($reqs as $req): ?>
                        <li>
                        <h3><?= $req['titre'] ?></h3>
                            <h5>Type: <?= $req['type'] ?></h5>
                            <form method="post">
                                <input type="hidden" name="quiz_id" value="<?= $req['id_quizz'] ?>">
                                <button type="submit" name="creation">
                                    <a href="editquizz.php?id=<?= $req['id_quizz'] ?>">Modifier</a>
                                </button>
                                <button type="submit" name="lance">Lancer</button>
                                <button type="submit" name="termine">Terminer</button>
                            </form>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="card">
                <!-- Autres éléments de la page -->
            </div>

            <div class="card">
                <!-- Liste des réponses -->
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js"></script>
    <script src="https://unpkg.com/@barba/core"></script>
    <script src="../js/app.js"></script>
    <script src="../js/script.js"></script>
</body>

</html>
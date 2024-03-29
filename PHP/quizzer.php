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
        $lien = generateUniqueLink($quiz_id);
        $quizz->saveQuizLink($quiz_id, $lien);
        $quizz->updateQuizzStatus($quiz_id, 'lance');
    } elseif (isset ($_POST['termine'])) {
        $quiz_id = $_POST['quiz_id'];
        $quizz->deleteQuizLink($quiz_id);
        $quizz->updateQuizzStatus($quiz_id, 'termine');
        // Insérer les réponses de tous les utilisateurs dans la table reponse_users
        $query = "SELECT ru.id_user, q.id_quizz, ru.id_question, ru.id_reponse 
    FROM reponse_user ru 
    INNER JOIN questions q ON ru.id_question = q.id_question 
    WHERE q.id_quizz = :id_quizz";

        $statement = $db->connection->prepare($query);
        $statement->execute(array(':id_quizz' => $quiz_id));
        $reponse_users = $statement->fetchAll(PDO::FETCH_ASSOC);


        // foreach ($reponse_users as $reponse_user) {
// echo "Utilisateur ID : " . $reponse_user['id_user'] . " - Quiz ID : " . $reponse_user['id_quizz'] . " - Question ID : " . $reponse_user['id_question'] . " - Réponse ID : " . $reponse_user['id_reponse'] . "<br>";
// }

        // Afficher les scores de tous les utilisateurs pour le quiz spécifique
        $query = "SELECT ru.id_user, u.pseudo, SUM(case when ru.score = 1 then 1 else 0 end) as score 
FROM reponse_user ru 
INNER JOIN questions q ON ru.id_question = q.id_question 
INNER JOIN users u ON ru.id_user = u.id_user 
WHERE q.id_quizz = :id_quizz 
GROUP BY ru.id_user";

        $statement = $db->connection->prepare($query);
        $statement->execute(array(':id_quizz' => $quiz_id));
        $scores = $statement->fetchAll(PDO::FETCH_ASSOC);

    }
}

function generateUniqueLink($quiz_id)
{
    $caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    $lien = 'http://localhost/Projet%20Web/Quizzeo2/php/quizz.php?' . "id_quizz=" . $quiz_id . '/';
    for ($i = 0; $i < 10; $i++) {
        $lien .= $caracteres[rand(0, strlen($caracteres) - 1)];
    }
    return $lien;
}
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
            <span>Q</span><span>u</span><span>i</span><span>z</span><span>z</span><span>e</span><span>r</span> Dashboard
        </h1><br>

        <div class="bigcard">
            <div class="card">
                <h2>Liste des quizzes</h2>
                <ul>
                    <?php foreach ($reqs as $req): ?>
                        <li>
                            <h3>
                                <?= $req['titre'] ?>
                            </h3>
                            <h5>Type:
                                <?= $req['type'] ?>
                            </h5>

                            <?php if ($req['status'] == 1): ?>
                                <a href="editquizz.php?id_quizz=<?= $req['id_quizz'] ?>"><button>Modifier</button></a>
                                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                    <input type="hidden" name="quiz_id" value="<?= $req['id_quizz'] ?>">
                                    <?php if ($req['statut_quizz'] !== 'lance'): ?>
                                        <button type="submit" name="lance">Lancer</button>
                                    <?php endif; ?>
                                    <button type="submit" name="termine">Terminer</button><br><br>
                                <?php else: ?>
                                    <br><h4>Quiz désactivé</h4>
                                <?php endif; ?>
                            </form>

                            <?php if ($req['statut_quizz'] == 'lance'): ?>
                                <h5>Lien du quiz: <a href="<?= $req['lien'] ?>" target="_blank">
                                        <?= $req['lien'] ?>
                                    </a></h5>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="card">
                <a href="ajout_quizz.php"><button>Creer un Quizz</button></a>
            </div>

            <div class="card">
                <!-- Liste des scores -->
                <?php if (isset ($scores) && !empty ($scores)): ?>
                    <?php foreach ($scores as $score): ?>
                        <p>Utilisateur :
                            <?= $score['pseudo'] ?> - Score :
                            <?= $score['score'] ?>
                        </p>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Aucun score disponible.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js"></script>
    <script src="https://unpkg.com/@barba/core"></script>
    <script src="../js/app.js"></script>
    <script src="../js/script.js"></script>
</body>

</html>
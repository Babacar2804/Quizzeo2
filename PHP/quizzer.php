<?php
session_start();

require 'classes.php';
$db = new BDD();
$quizz=new Quizzer($db);
$user_id = $_SESSION['user_id'];
$reqs=$quizz->affichquizz($user_id);

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
        <h1><span>Q</span><span>U</span><span>I</span><span>Z</span><span>Z</span><span>E</span><span>R</span> Dashboard</h1>
        <!-- Mettre dans les span les lettres du mot de la page pour l'effet d'apparition -->

        <div class="bigcard">
            <div class="card">
                <h2>Liste des quizzes</h2>
                <?php foreach ($reqs as $req): ?>
                        <li>
                            <?= $req['titre'] ?> 
                        </li>
                    <?php endforeach; ?>         
            </div>

            <div class="card">
            </div>

            <div class="card">
                <!-- liste des reponses  -->
            </div>
        </div>
    </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js"></script>
    <script src="https://unpkg.com/@barba/core"></script>
    <script src="../js/app.js"></script>
    <script src="../js/script.js"></script>
</body>

</html>

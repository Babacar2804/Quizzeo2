<?php
session_start();

if (!isset ($_SESSION['user_id']) || !isset ($_SESSION['user_role']) || $_SESSION['user_role'] != 5) {
    header("Location: 403.php");
    exit();
}
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
        <div class="bigcard">
            <div class="card2">
                <h1><span>B</span><span>i</span><span>e</span><span>n</span><span>v</span><span>e</span><span>n</span><span>u</span><span>e</span>
                </h1>
                <p>Quizzeo est une plateforme interactive de quiz en ligne qui vous permet de créer, partager et
                    participer à une grande variété de quiz sur divers sujets. Que vous soyez un étudiant cherchant à
                    réviser pour un examen, un enseignant voulant rendre l'apprentissage plus ludique, ou simplement
                    quelqu'un qui aime tester ses connaissances, Quizzeo a quelque chose pour vous !</p>
                <br><br><br>
                <h3>Redirection vers un Quiz pour y jouer</h3>
                <form id="redirectForm">
                    <label for="quizzeoLink">Lien de redirection :</label><br>
                    <input type="url" id="quizzeoLink" name="quizzeoLink" placeholder="Entrez le lien de redirection"
                        required><br><br>
                    <button type="button" onclick="redirect()">Rediriger</button>
                </form>
                <script>
                function redirect() {
                    var url = document.getElementById('quizzeoLink').value;
                    window.location.href = url;
                }
            </script>
            </div>
        </div>
    </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js"></script>
        <script src="https://unpkg.com/@barba/core"></script>
        <script src="../js/app.js"></script>
        <script src="../js/script.js"></script>
</body>

</html>
<?php
// Your PHP Code
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
        <h1><span></span><span></span><span></span><span></span><span></span> Dashboard</h1>
        <!-- Mettre dans les span les lettres du mot de la page pour l'effet d'apparition -->

        <div class="bigcard">
            <div class="card">
<<<<<<< HEAD:quizzer.php
                <h2>Liste des quizzes</h2>
                <?php foreach ($reqs as $req): ?>
                        <li>
                            <?= $req['titre'] ?> 
                            <a href="edit_quizz.php?id_quizz=<?php echo $req['id_quizz']; ?>"><button>Modifier</button></a>
                            <button <?php echo $req['id_quizz']; ?>>Lancer</button></a>
                            <input type="text" id="lienGenere" name="lienGenere" value="<?php echo $lien; ?>" readonly><br><br>
                            <button <?php echo $req['id_quizz']; ?>>Terminer</button></a>
                        </li>
                    <?php endforeach; ?>         
=======
                <!-- Here your code -->
>>>>>>> 98c6b4834a5671a3b75379f62a89386072d9b1f2:PHP/Template.php
            </div>

            <div class="card">
                <!-- Here your code -->
            </div>

            <div class="card">
                <!-- Here your code -->
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
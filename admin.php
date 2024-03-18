<?php
include 'classes.php'; 
$db = new BDD();
$adminSite = new AdminSite($db);

$listeUtilisateurs = $adminSite->Users();
$utilisateursConnectes = $adminSite->UsersLogged();
$listeQuizzes = $adminSite->Quizzes();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
</head>
<body>
    <h1>Admin Dashboard</h1>

    <h2>Liste des utilisateurs créés :</h2>
    <ul>
        <?php foreach ($listeUtilisateurs as $utilisateur) : ?>
            <li><?= $utilisateur['pseudo'] ?> - <?= $utilisateur['email'] ?></li>
        <?php endforeach; ?>
    </ul>

    <h2>Utilisateurs connectés en ce moment :</h2>
    <ul>
        <?php foreach ($utilisateursConnectes as $utilisateur) : ?>
            <li><?= $utilisateur['pseudo'] ?></li>
        <?php endforeach; ?>
    </ul>

    <h2>Liste des quizzes :</h2>
    <ul>
        <?php foreach ($listeQuizzes as $quiz) : ?>
            <li><?= $quiz['titre'] ?> - <?= $quiz['date_creation'] ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>

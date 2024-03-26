<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar</title>
    <link rel="stylesheet" href="../CSS/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="navbar-brand">
            <a href="../index.php"><img src="../img/bg.png" alt="Logo"></a>
        </div>
        <ul class="navbar-links">
            <?php
            if (isset($_SESSION['user_id'])) {
                echo '<li class="navbar-link"><a href="deconnexion.php">Déconnexion</a></li>';
                echo '<li class="navbar-link"><a href="votre_compte.php">Votre Compte</a></li>';
            } else {
                echo '<li class="navbar-link"><a href="inscription.php">Inscription</a></li>';
                echo '<li class="navbar-link"><a href="connexion.php">Connexion</a></li>';
            }
            ?>
        </ul>
    </nav>
</body>
</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Deco.css">
    <title>inscriptiond&co</title>
</head>

<body>
    <?php include 'navbar.php'; ?><br><br>

    <br><br>
    <div class="inscription">
        <h1>Inscription</h1>
        <form method="post" id="registrationForm" action="#">
            <input type="text" id="pseudo" name="pseudo" placeholder="pseudo" required></input><br><br>
            <input type="email" id="email" name="email" placeholder="email" required></input><br><br>
            <input type="password" id="password" name="password" placeholder="mot de passe" required></input><br><br>
            <img src="\Quizzeo2\captcha.php" /><br><br>
            <input type="text" name="captcha" placeholder="rentrez le captcha"></input><br><br>
            <button type="submit"name="submit" class="api"><script></script> S'inscrire</button>
        </form>
    </div>

</body>
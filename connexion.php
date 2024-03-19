<?php
require 'classes.php';

$db = new BDD();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["pseudo"]) && isset($_POST["password"])) {
        $username = $_POST["pseudo"];
        $password = $_POST["password"];
        $query = "SELECT id_user, pseudo, password, id_role FROM Users WHERE pseudo = :pseudo AND password = :password";
        $statement = $db->executeQuery($query, array(':pseudo' => $username, ':password' => $password));
        $user = $statement->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            switch ($user['id_role']) {
                case 1: 
                    header("Location: admin.php");
                    break;
                case 2: 
                    header("Location: val_compte.php");
                    break;
                case 3: 
                    header("Location: admin_quiz.php");
                    break;
                case 4: 
                    header("Location: quizzer.php");
                    break;
                case 5: 
                    header("Location: user.php");
                    break;
                default:
                    echo "Rôle non reconnu.";
                    break;
            }
            exit(); 
        } else {
            echo "Identifiants invalides. Veuillez réessayer.";
        }
    } else {
        echo "Veuillez remplir tous les champs du formulaire.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
</head>
<body>
    <h1>Connexion</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="pseudo">Pseudo :</label>
        <input type="text" id="pseudo" name="pseudo" required><br><br>
        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required><br><br>
        <input type="submit" value="Se connecter">
    </form>
</body>
</html>

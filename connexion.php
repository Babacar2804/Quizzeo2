<?php
session_start();

require 'classes.php';
$db = new BDD();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])){
    $username = $_POST["username"];
    $password = $_POST["password"];

    $query = "SELECT id_user, pseudo, password, id_role FROM Users WHERE pseudo = :username";
    $statement = $db->connection->prepare($query);
    $statement->execute(array(':username' => $username));
    $user = $statement->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_pseudo'] = $user['pseudo'];
        $_SESSION['user_id'] = $user['id_user'];
        $_SESSION['user_role'] = $user['id_role'];
    
        $adminSite = new AdminSite($db);
        $adminSite->updateStatus($user['id_user'], "active");    
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
        // var_dump($user); 
        // var_dump(password_verify($password, $user['password'])); 
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
        <label for="username">Nom d'utilisateur :</label>
        <input type="text" name="username" required><br><br>
        <label for="password">Mot de passe :</label>
        <input type="password" name="password" required><br><br>
        <input type="submit" name="login" value="Se connecter">
    </form>
</body>
</html>

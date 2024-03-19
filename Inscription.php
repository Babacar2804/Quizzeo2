<?php 
require 'classes.php';
$db = new BDD();
$adminSite = new AdminSite($db);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $pseudo = $_POST["pseudo"];
        $email = $_POST["email"];
        $password = $_POST["password"];
            
        // $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        // $query = "INSERT INTO users (pseudo, email, password, statut_compte) VALUES (:pseudo, :email, :password, 'active')";
        // $params = array(':pseudo' => $pseudo, ':email' => $email, ':password' => $hashedPassword);
        // $statement = $db->executeQuery($query, $params);
        // return $statement->execute();

        $user = $adminSite->addUsers($pseudo, $email, $password);
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Inscription</title>
    </head>
    <body>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="pseudo">Pseudo:</label>
            <input type="text" id="pseudo" name="pseudo" required><br><br>

            <label for="mail">email</label>
            <input type="email"id="email" name="email" required><br><br>

            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password" required><br><br>

            <input type="submit" value="Se connecter">
        </form>
    </body>
</html>
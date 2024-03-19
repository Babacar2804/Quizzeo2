<?php 
require 'classes.php';
$db = new BDD();
$adminSite = new AdminSite($db);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    $pseudo = $_POST["pseudo"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $role = 5; 
            
    if (empty($pseudo) || empty($email) || empty($password)) {
        $error = "Tous les champs sont requis.";
    } else {
        $existingUser = $adminSite->getUserByEmail($email);
        if ($existingUser) {
            $error = "Cet email est déjà utilisé. Veuillez choisir un autre.";
        } else {
            $result = $adminSite->addUsers($pseudo, $email, $password, $role);
            if ($result) {
                echo "Utilisateur ajouté avec succès.";
            } else {
                echo "Une erreur s'est produite lors de l'ajout de l'utilisateur.";
            }
        }
    }
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
    <h1>Inscription</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="pseudo">Pseudo:</label>
        <input type="text" id="pseudo" name="pseudo" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required><br><br>

        <input type="submit" name="submit" value="S'inscrire">
    </form>
</body>
</html>

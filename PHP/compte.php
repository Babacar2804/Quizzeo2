<?php
session_start();
require 'classes.php';
$db = new BDD();
$user = null;

if (isset ($_SESSION['user_id'])) {
    $session_user_id = $_SESSION['user_id'];
    $query = "SELECT * FROM Users WHERE id_user = :session_user_id";
    $statement = $db->connection->prepare($query);
    $statement->bindParam(':session_user_id', $session_user_id);
    $statement->execute();
    $user = $statement->fetch(PDO::FETCH_ASSOC);
}

if ($user) {
    if (isset ($_POST['update'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $queryUpdate = "UPDATE Users SET pseudo = :username, email = :email, password = :password WHERE id_user = :session_user_id";
        $stmt = $db->connection->prepare($queryUpdate);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':session_user_id', $session_user_id);
        $stmt->execute();

        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modification utilisateur</title>
    <link rel="stylesheet" href="../CSS/style.css">
</head>

<body>

    <body data-barba="wrapper">
        <?php include 'nav.php'; ?>

        <div class="pages" data-barba="container" data-barba-namespace="home">
            <!-- Mettre dans les span les lettres du mot de la page pour l'effet d'apparition -->
            <div class="bigcard">
                <div class="card">
                    <?php if ($user): ?>
                        <h3>Modification de l'utilisateur</h3><br>
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <label for="username">Nom d'utilisateur:</label>
                            <input type="text" id="username" name="username" value="<?php echo $user['pseudo']; ?>"
                                required><br>
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>"
                                required><br>
                            <label for="email">Mot De passe:</label>
                            <input type="password" id="password" name="password" required><br><br>

                            <input type="submit" name="update" value="Mettre à jour">
                        </form>
                    <?php else: ?>
                        <p>Utilisateur non trouvé ou non connecté.</p>
                    <?php endif; ?>
                </div>
                <div class="card">
                    <br>
                    <button type="button" id="generateApiKey" name="generateApiKey"
                        data-session-id="<?php echo $session_user_id; ?>">Récupérer ma clé API</button><br>
                        <div id="apiKeyContainer"></div>
                </div>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
            <script src='../js/api.js'></script>
    </body>

</html>
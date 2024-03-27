<?php
session_start();
require 'classes.php';
$db = new BDD();
$user = null;

if(isset($_SESSION['user_id'])) {
    $session_user_id = $_SESSION['user_id'];
    $query = "SELECT * FROM Users WHERE id_user = :session_user_id";
    $statement = $db->connection->prepare($query);
    $statement->bindParam(':session_user_id', $session_user_id);
    $statement->execute();
    $user = $statement->fetch(PDO::FETCH_ASSOC);
}

// Si l'utilisateur est connecté et ses informations sont récupérées
if($user) {
    if(isset($_POST['update'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        
        $queryUpdate = "UPDATE Users SET pseudo = :username, email = :email WHERE id_user = :session_user_id";
        $stmt = $db->connection->prepare($queryUpdate);
        $stmt->bindParam(':pseudo', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':session_user_id', $session_user_id);
        $stmt->execute();
        
        header("Location: ".$_SERVER['PHP_SELF']);
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
</head>
<body>
    <?php if($user): ?>
    <h1>Modification de l'utilisateur</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="username">Nom d'utilisateur:</label><br>
        <input type="text" id="username" name="username" value="<?php echo $user['pseudo']; ?>" required><br>
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>" required><br><br>
        <input type="submit" name="update" value="Mettre à jour">
    </form>
    <?php else: ?>
    <p>Utilisateur non trouvé ou non connecté.</p>
    <?php endif; ?>
    <br>
    <button type="button" id="generateApiKey" name="generateApiKey" data-session-id="<?php echo $session_user_id; ?>">Générer ma clé API</button>
    
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="../js/api.js"></script>
</body>
</html>

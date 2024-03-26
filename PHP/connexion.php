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
        session_regenerate_id(true);
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
        echo "<script>alert('Identifiants invalides. Veuillez réessayer.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CONNEXION</title>
    <link rel="stylesheet" href="../CSS/style.css">
</head>
<body data-barba="wrapper">
<?php include 'nav.php'; ?>

<div>
    <div class="pages" data-barba="container" data-barba-namespace="about">
        <div class="cover">
            <span></span><span></span><span></span><span></span><span></span>
        </div>

        <div class="container">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
        <h2>CONNEXION</h2>

            <div class="txt_field">
                <input type="text" name="username" required>
                <span></span>
                <label>Pseudo</label>
            </div>
            <div class="txt_field">
                <input type="password" name="password" required>
                <span></span>
                <label>Mot De Passe</label>
            </div>
            <input name="login" type="Submit" value="Se connecter"><br><br>
            <label>Pas encore inscrit? <a href="inscription.php">Inscription</a></label>

        </form>
        </div>
    </div>
</div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js"></script>
    <script src="https://unpkg.com/@barba/core"></script>
    <script src="../js/app.js"></script>
</body>
</html>

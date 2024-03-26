<?php
session_start();

require 'classes.php';
$db = new BDD();

$user_id = $_SESSION['user_id'];

$query = "SELECT statut_compte FROM Users WHERE id_user = :user_id";
$statement = $db->connection->prepare($query);
$statement->execute(array(':user_id' => $user_id));
$user = $statement->fetch(PDO::FETCH_ASSOC);

if ($user['statut_compte'] == 0) {
    $message = "Votre compte est en attente de validation.";
} else {
    header("Location: user.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attente de validation du compte</title>
    <link rel="stylesheet" href="../CSS/style.css">
</head>
<?php include 'nav.php'; ?>
<body data-barba="wrapper">
<div>
    <div class="pages" data-barba="container" data-barba-namespace="about">
        <div class="cover">
            <span></span><span></span><span></span><span></span><span></span>
        </div>
    <h2>Attente de validation du compte</h2>
    <p><?php echo $message; ?></p>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js"></script>
    <script src="https://unpkg.com/@barba/core"></script>
    <script src="../js/app.js"></script>
</body>
</html>

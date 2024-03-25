<?php 
session_start();
require 'classes.php';
$db = new BDD();
$users = new Users($db);

if (isset($_POST['captcha'])) {
    if ($_POST['captcha'] == $_SESSION['captcha']) {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {

            $pseudo = $_POST["pseudo"];
            $email = $_POST["email"];
            $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
            $role = 5;

            if (empty($pseudo) || empty($email) || empty($password)) {
                echo "<script>alert('Tous les champs sont requis.')</script>";
            } else {
                $existingUser = $users->getUserByEmail($email);
                if ($existingUser) {
                    echo "<script>alert('Cet email est déjà utilisé. Veuillez choisir un autre.')</script>";
                } else {
                    $query = "INSERT INTO users (pseudo, email, password, statut_compte, id_role) VALUES (:pseudo, :email, :password, 'active', :id_role)";
                    $params = array(':pseudo' => $pseudo, ':email' => $email, ':password' => $password, ':id_role' => $role);
                    $statement = $db->executeQuery($query, $params);

                    if ($statement) {
                        $lastUserId = $db->getLastInsertedId();
                        $_SESSION['user_id'] = $lastUserId;
                        $_SESSION['user_pseudo'] = $pseudo;
                        $_SESSION['user_role'] = $role;
                        header("Location: attente.php");
                        exit();
                    }
                }
            }
        }
        echo "<script>alert('Captcha valide.')</script>";
    } else {
        echo "<script>alert('Captcha invalide. Une erreur s'est produite lors de l'ajout de l'utilisateur.')</script>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INSCRIPTION</title>
    <link rel="stylesheet" href="style1.css">
</head>
<body data-barba="wrapper">
<?php include 'nav.php'; ?>
    <div class="pages" data-barba="container" data-barba-namespace="about">

        <div class="cover">
            <span></span><span></span><span></span><span></span><span></span>
        </div>

        <div class="container">
            <h2>INSCRIPTION</h2>
            <form id="registrationForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <div class="txt_field">
                    <input type="text" id="pseudo" name="pseudo" placeholder="Pseudo" required ></input>
                </div>
                <div class="txt_field">
                    <input type="email" id="email" name="email" placeholder="Email" required></input>
                </div>
                <div class="txt_field">
                    <input type="password" id="password" name="password" placeholder="Mot De Passe" required></input>
                </div>
                <div class="txt_field">
                    <img src="captcha.php" />
                    <input type="text" name="captcha" placeholder="Rentrer le captcha"></input>
                    </div>
                <input name="submit" type="Submit" value="S'inscrire"><br><br>
                <label>Déjà inscrit? <a href="connexion.php">Connexion</a></label>

            </form>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js"></script>
    <script src="https://unpkg.com/@barba/core"></script>
    <script src="app.js"></script>
</body>

</html>

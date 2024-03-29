<?php
session_start();
include 'classes.php';
$db = new BDD();
$adminSite = new AdminSite($db);
$users = new AdminSite($db);
$adminQuiz = new AdminQuiz($db);


$password = '';

if (!isset ($_SESSION['user_id']) || !isset ($_SESSION['user_role']) || $_SESSION['user_role'] != 1) {
    header("Location: 403.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset ($_POST["user_id"]) && isset ($_POST["status"])) {
    $user_id = $_POST["user_id"];
    $status = $_POST["status"];
    $adminSite->updateUserStatus($user_id, $status);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset ($_POST["submit"])) {
    $pseudo = $_POST["pseudo"];
    $email = $_POST["email"];
    $hashed_password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $role = 5;
    $compte = 1;

    if (empty ($pseudo) || empty ($email) || empty ($_POST["password"])) {
        $error = "Tous les champs sont requis.";
    } else {
        $existingUser = $users->getUserByEmail($email);
        if ($existingUser) {
            $error = "Cet email est déjà utilisé. Veuillez choisir un autre.";
        } else {
            $query = "INSERT INTO users (pseudo, email, password, statut_compte, id_role) VALUES (:pseudo, :email, :password, :compte, :id_role)";
            $params = array(':pseudo' => $pseudo, ':email' => $email, ':password' => $hashed_password, ':compte' => $compte, ':id_role' => $role);
            $statement = $db->executeQuery($query, $params);

            if ($statement) {
                echo '<script>alert("Utilisateur ajouté avec succès.");</script>';
            } else {
                $error = "Une erreur s'est produite lors de l'ajout de l'utilisateur.";
            }
        }
    }
}
if (isset ($_POST['update_status'])) {
    $quiz_id = $_POST['quiz_id'];
    $status = $_POST['status'];

    // Récupération du statut actuel du quiz
    $quiz = $adminQuiz->getQuizzData($quiz_id);
    $current_status = $quiz['status'];

    if ($status == 'inactive') {
        $adminQuiz->updateQuizStatus($quiz_id, $status);
    } else {
        $status == 'active';
        $adminQuiz->updateQuizStatus($quiz_id, $status);
    }
}
$quizzes = $adminQuiz->Quizzes();
$listeUtilisateurs = $adminSite->Users();
$utilisateursCo = $adminSite->getUsersByStatus(1);
$listeQuizzes = $adminSite->Quizzes();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../CSS/style.css">
</head>

<body data-barba="wrapper">
    <?php include 'nav.php'; ?>

    <div class="pages" data-barba="container" data-barba-namespace="home">
        <h1><span>A</span><span>d</span><span>m</span><span>i</span><span>n</span> Dashboard</h1>
        <div class="bigcard">
            <div class="card">
                <h2>Liste des utilisateurs créés :</h2><br>
                <ul>
                    <?php foreach ($listeUtilisateurs as $utilisateur): ?>
                        <?php if ($utilisateur['id_user'] != $_SESSION['user_id']): ?>
                            <li>
                                <?= $utilisateur['pseudo'] ?> -
                                <?= $utilisateur['email'] ?>
                                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                    <input type="hidden" name="user_id" value="<?= $utilisateur['id_user'] ?>">
                                    <button type="submit" name="status"
                                        value="<?= $utilisateur['statut_compte'] ? 'inactive' : 'active' ?>">
                                        <?= $utilisateur['statut_compte'] ? 'Désactiver' : 'Activer' ?>
                                    </button><br>
                                </form>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="card">
                <h2>Utilisateurs connectés en ce moment :</h2><br>
                <ul>
                    <?php foreach ($utilisateursCo as $utilisateur): ?>
                        <li>
                            <?= $utilisateur['pseudo'] ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="card">
                <h2>Créer un compte</h2><br>
                <button onclick="showForm()">Cliquer ici</button><br>
                <div id="creationForm" style="display: none;">
                    <br>
                    <form id="userCreationForm" method="post"
                        action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <label for="pseudo">Pseudo:</label>
                        <input type="text" id="pseudo" name="pseudo" required><br><br>

                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required><br><br>

                        <label for="password">Mot de passe :</label>
                        <input type="password" id="password" name="password" required><br><br>

                        <label for="generatedPassword">Mot de passe généré:</label>
                        <span id="generatedPassword"></span><br><br>

                        <button onclick="generatePassword()">Générer un mot de passe</button><br><br>

                        <input type="submit" name="submit" value="Ajouter l'utilisateur">
                    </form>
                </div>
            </div>
            <div class="card">
                <?php foreach ($quizzes as $quiz): ?>

                    <h3>
                        <?php echo $quiz['titre']; ?>
                    </h3>
                    <p>Statut :
                        <?php echo ($quiz['status'] == 1) ? "Actif" : "Inactif"; ?>
                    </p>
                    <form method="post">
                        <input type="hidden" name="quiz_id" value="<?php echo $quiz['id_quizz']; ?>">
                        <label for="status">Changer le statut :</label><br>
                        <select name="status">
                            <option value="active" <?php echo ($quiz['status'] == 1) ? 'disabled' : ''; ?>>
                                Activer
                            </option>
                            <option value="inactive">Désactiver</option>
                        </select>
                        <button type="submit" name="update_status">Mettre à jour</button>
                    </form>

                <?php endforeach; ?>

            </div>
        </div>

    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js"></script>
    <script src="https://unpkg.com/@barba/core"></script>
    <script src="../js/app.js"></script>
    <script src="../js/script.js"></script>
</body>

</html>
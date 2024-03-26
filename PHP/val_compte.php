<?php
session_start();
require 'classes.php';
$db = new BDD();
$valCompte = new ValCompte($db);
$inactiveAccounts = $valCompte->InactiveAccounts();
$usersAccounts = $valCompte->UsersAccounts();

if (!isset ($_SESSION['user_id']) || !isset ($_SESSION['user_role']) || $_SESSION['user_role'] != 2) {
    header("Location: 403.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset ($_POST["maj"])) {
    $userId = $_POST["userId"];
    $newRole = $_POST["newRole"];

    if (!empty ($userId)) {
        $success = $valCompte->updateUserRole($userId, $newRole);
        if ($success) {
            echo "<script>alert('Le rôle de l\'utilisateur a été mis à jour avec succès.');</script>";
        } else {
            echo "<script>alert('Une erreur s\'est produite lors de la mise à jour du rôle de l\'utilisateur.');</script>";
        }
    } else {
        echo "<script>alert('Veuillez saisir l\'ID de l\'utilisateur.');</script>";
    }
}




if ($_SERVER["REQUEST_METHOD"] == "POST" && isset ($_POST["validate"])) {
    $user_id = $_POST["user_id"];
    $activation_success = $valCompte->activateAccount($user_id);
    if ($activation_success) {
        echo '<script>alert("Le compte a été activé avec succès.");</script>';
    } else {
        $error = "Une erreur s'est produite lors de l'activation du compte. Veuillez réessayer.";
    }
}
if (!empty ($error)) {
    echo "<script>alert('$error');</script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validateur de Compte</title>
    <link rel="stylesheet" href="../CSS/style.css">

</head>

<body data-barba="wrapper">
<?php include 'nav.php'; ?>

    <div class="pages" data-barba="container" data-barba-namespace="home">
        <h2><span>V</span><span>a</span><span>l</span><span>i</span><span>d</span><span>a</span><span>t</span><span>e</span><span>u</span><span>r</span>
            Dashboard</h2>
        <div class="bigcard">
            <div class="card">
                <h2>Comptes en attente de validation</h2>
                <ul>
                    <?php foreach ($inactiveAccounts as $account): ?>
                        <li>
                            <?= $account['pseudo'] ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <h2>Validation des comptes</h2>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <label for="user_id">Sélectionner un utilisateur :</label>
                    <select name="user_id" id="user_id" required>
                        <?php foreach ($inactiveAccounts as $account): ?>
                            <option value="<?= $account['id_user'] ?>">
                                <?= $account['pseudo'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select><br><br>
                    <input type="submit" name="validate" value="Valider">
                </form>
            </div>
            <div class="card">
                <h2>Privilèges</h2>
                <ul>
                    <?php foreach ($usersAccounts as $userAccount): ?>
                        <li>
                            <?= $userAccount['pseudo'] ?>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <label for="userId">Sélectionner l'utilisateur :</label>
                    <select name="userId" id="userId" required>
                        <?php foreach ($usersAccounts as $userAccount): ?>
                            <option value="<?= $userAccount['id_user'] ?>">
                                <?= $userAccount['pseudo'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select><br><br>

                    <label for="newRole">Sélectionner le nouveau rôle :</label>
                    <select name="newRole" id="newRole" required>
                        <option value="3">Admin Quiz</option>
                        <option value="4">Quizzer</option>
                    </select><br><br>

                    <input type="submit" name="maj" value="Mettre à jour le rôle">
                </form>

            </div>

        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js"></script>
    <script src="https://unpkg.com/@barba/core"></script>
    <script src="../js/app.js"></script>
    <script src="../js/script.js"></script>
</body>

</html>
<?php 
session_start();
require 'classes.php';
$db = new BDD();
$users = new Users($db);

if(isset($_POST['captcha'])){
    if($_POST['captcha'] == $_SESSION['captcha']){
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {

            $pseudo = $_POST["pseudo"];
            $email = $_POST["email"];
            $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
            $role= 5;
    
                
        if (empty($pseudo) || empty($email) || empty($password)) {
            $error = "Tous les champs sont requis.";
        } else {
            $existingUser = $users->getUserByEmail($email);
            if ($existingUser) {
                $error = "Cet email est déjà utilisé. Veuillez choisir un autre.";
                echo $error;
            } else {
                $query = "INSERT INTO users (pseudo, email, password, statut_compte, id_role) VALUES (:pseudo, :email, :password, 'active', :id_role)";
                $params = array(':pseudo' => $pseudo, ':email' => $email, ':password' => $password, ':id_role' => $role);
                $statement = $db->executeQuery($query, $params);
                
                if ($statement) {
                    echo "Utilisateur ajouté avec succès.";
                } 
            }
        }
    }    
        echo "Captcha valide";
    }else{
        echo "Captcha invalide";
        echo "Une erreur s'est produite lors de l'ajout de l'utilisateur.";
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
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <h1>Inscription</h1>
    <form method="post" id="registrationForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label for="pseudo">Pseudo:</label>
        <input type="text" id="pseudo" name="pseudo" required></input><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required></input><br><br>

        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required></input><br><br>
        <img src="captcha.php"/>
        <input type="text"  name="captcha"></input>
        <input type="submit" id ="submit" name="submit" value="S'inscrire"></input>
    </form>    
</body>

</html>

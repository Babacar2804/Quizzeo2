<?php
session_start();
require 'classes.php';
$db = new BDD();
var_dump($_SESSION);
$session_user_id = $_SESSION['user_id'];
// Vérifie si l'utilisateur est connecté
if(isset($session_user_id)) {
    // Récupération de l'ID utilisateur de la session
    
    var_dump($session_user_id);
   // Requête pour récupérer l'ID utilisateur de la base de données correspondant à celui de la session
    $query = "SELECT id_user FROM Users WHERE id_user = :session_user_id";
    $statement = $db->connection->prepare($query);
    $statement->bindParam(':session_user_id', $session_user_id);
    $statement->execute();
    $user = $statement->fetch(PDO::FETCH_ASSOC);


    // Comparaison des ID utilisateur de la session et de la base de données
    if($user && $session_user_id == $user['id_user']) {
        //vérifier si l'utilisateur a déjà une clé API
        var_dump($user['id_user']);
        // Renvoie une réponse JSON avec succès
        echo json_encode(array("success" => true));
    } else {
        // L'utilisateur n'est pas connecté ou son ID ne correspond pas à celui de la session
        // Renvoie une réponse JSON avec erreur
        echo json_encode(array("error" => "L'utilisateur n'est pas connecté"));
    }
} else {
    // Renvoie une réponse JSON avec erreur
    echo json_encode(array("error" => "L'utilisateur n'est pas connecté"));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User</title>
    
</head>

<body>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <button type="button" id="generateApiKey" name="generateApiKey" data-session-id="<?php echo $session_user_id; ?>">Récupérer mon API</button>
    <!-- section pour rejoindre un quizz (coller un lien)  -->
    <script src='api.js'></script>
</body>
</html>

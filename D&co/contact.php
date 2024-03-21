<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Contact</title>
</head>
<body>
    <?php
    if (isset($_POST["button"])) {
        $nom = $_POST['nom'];
        $mail = $_POST['mail'];
        $sujet = $_POST['sujet'];
        $message = $_POST['message'];
        $to = "j.dubois@ecole-ipssi.net";

        // Vérif des champs
        if (empty(trim($nom)) || empty(trim($message))) { // Champs Vides
            echo "<span class='error'>Erreur : Pas de champs vides autorisés.</span>\n";
        } elseif (!preg_match('/^[a-zA-Z][a-zA-Z\s]*$/', $nom)) { // Vérif Symboles
            echo "<span class='error'>Erreur : Le nom ne doit contenir que des lettres.</span>\n";
        } elseif (!filter_var($mail, FILTER_VALIDATE_EMAIL)) { // Vérif Mail
            echo "<span class='error'>Erreur : Adresse mail invalide.</span>\n"; 
        } else {
            // Envoi du mail
            $headers = "From: $nom <$mail>";
            if (mail($to, $sujet, $message, $headers)) {
                echo "<span class='success'>Votre message a été envoyé avec succès :)</span>";
            } else {
                echo "<span class='error'>Erreur lors de l'envoi du message :(</span>";
            }
        }        
    }
    ?>
    <div class="container">
        <div class="contact-box">
            <form action="" method="post">
                <h2>Contact</h2>
                <input type="text" name="nom" class="field" placeholder="Votre Nom" required><br>
                <input type="email" name="mail" class="field" placeholder="Votre Mail" required><br>
                <input type="text" name="sujet" class="field" placeholder="Sujet" required><br>
                <textarea name="message" class="field" placeholder="Message" required></textarea><br><br>
                <input type="submit" name="button" class="btn" value="Envoyer">
            </form>
        </div>
    </div>
</body>
</html>
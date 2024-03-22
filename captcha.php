<?php 
session_start();

// Génération du captcha
$_SESSION['captcha'] = mt_rand(1000, 9999);

// Création de l'image
$img = imagecreate(150, 50);

// Couleurs aléatoires pour le fond et le texte
$bg = imagecolorallocate($img, rand(200, 255), rand(200, 255), rand(200, 255));
$textcolor = imagecolorallocate($img, rand(0, 100), rand(0, 100), rand(0, 100));

// Dessiner des lignes de bruit (moins de lignes pour moins d'encombrement)
for ($i = 0; $i < 5; $i++) {
    $noise_color = imagecolorallocate($img, rand(0, 255), rand(0, 255), rand(0, 255));
    imageline($img, rand(0, 150), rand(0, 50), rand(0, 150), rand(0, 50), $noise_color);
}

// Utilisation d'une police de caractères différente
$font = 'fonts\28 Days Later.ttf';

// Dessiner le texte avec une rotation et une inclinaison aléatoires
$angle = rand(-5, 5);
imagettftext($img, 23, $angle, 10, 40, $textcolor, $font, $_SESSION['captcha']);

// Ajout de distorsion au texte (distorsion plus subtile)
$distortion = rand(-3, 3);
imagettftext($img, 23, $angle, 10 + $distortion, 40, $textcolor, $font, $_SESSION['captcha']);

// Envoyer l'image
header('Content-type: image/jpeg');
imagejpeg($img);

// Libérer la mémoire
imagedestroy($img);
?>

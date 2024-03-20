<?php
session_start();
require 'classes.php';
$db = new BDD();
$susers= new SimpleUsers($db);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User</title>
</head>

<body>
<button type="button" id="boutapi" name="boutapi"><script></script> récupérer mon api</button>
    <!--section pour rejoindre un quizz (coller un lien)  -->

</body>
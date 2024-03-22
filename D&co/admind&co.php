<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Deco.css">
    <title>admind&co</title>
</head>

<body>
    <?php include 'navbar.html'; ?><br><br>

    <div class="containera">
        <h1>Admin Dashbord</h1>
        <ul class="containerli">
            <li>util1 <button class="api">Activer</button><button class="api">Desactiver</button></li><br>
            <li>util2 <button class="api">Activer</button><button class="api">Desactiver</button></li><br>
            <li>util3 <button class="api">Activer</button><button class="api">Desactiver</button></li><br>
            <li>util4 <button class="api">Activer</button><button class="api"> Desactiver</button></li><br>
        </ul>
    </div>
    <br><br>
    <div class="containerb">
        <h3>Rejoindre un Quizz</h3> <br>
        <input class="textarea" type="textarea" placeholder="collez le lien ici"> </input>
    </div><br><br>
    <div class="containerc">
        <h3> Recuperer ma clé API</h3>
        <button type="button" id="boutapi" name="boutapi" class="apibut" class="api">
            <script></script> récupérer mon api
        </button>
    </div>


</body>
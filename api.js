document.getElementById('generateApiKey').addEventListener('click', function(event) {
    event.preventDefault(); // Empêche le comportement par défaut du clic sur le bouton
    // Envoi d'une requête au serveur Node.js pour générer la clé API
    axios.post('http://localhost:3000/generateApiKey')
    .then(function (response) {
        console.log(response.data); // Affiche la réponse du serveur Node.js
        var apiKey = response.data.apiKey;
        console.log('Clé API générée:', apiKey);
        // Faites ce que vous voulez avec la clé API générée, par exemple l'afficher sur la page
        alert('Clé API générée: ' + apiKey);
    })
    .catch(function (error) {
        console.error("Une erreur s'est produite lors de la requête :", error);
        // Gérer les erreurs
    });
});

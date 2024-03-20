document.getElementById('generateApiKey').addEventListener('click', function(event) {
    event.preventDefault(); // Empêche le comportement par défaut du clic sur le bouton

    var pseudo = document.getElementById('pseudo').value;
    var email = document.getElementById('email').value;
    var password = document.getElementById('password').value;

    // Envoi des données du formulaire à votre serveur Node.js pour générer la clé API
    axios.post('http://localhost:3000/createApiKey', { pseudo, email, password })
    .then(function (response) {
        console.log(response.data); // Affiche la réponse de votre serveur avec la clé API
        var apiKey = response.data.apiKey;
        console.log('Clé API générée:', apiKey);
        
        // Mettre à jour la valeur du champ caché avec la clé API générée
        document.getElementById('apiKey').value = apiKey;
    })
    .catch(function (error) {
        console.error("Une erreur s'est produite lors de la requête :", error);
        // Gérer les erreurs
    });

});



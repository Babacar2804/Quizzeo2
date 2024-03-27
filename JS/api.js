document.getElementById('generateApiKey').addEventListener('click', function(event) {
    event.preventDefault();
    var sessionId = document.getElementById('generateApiKey').getAttribute('data-session-id');
    axios.post('http://localhost:3000/createApiKey', { sessionId: sessionId })
    .then(function (response) {
        var apiKey = response.data.apiKey;
        document.getElementById('apiKeyContainer').innerHTML = 'Clé API générée: ' + apiKey;
    })
    .catch(function (error) {
        console.error("Une erreur s'est produite lors de la requête :", error);
    });
});


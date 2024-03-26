const express = require('express');
const bodyParser = require('body-parser');
const connection = require('./config');


const uniqid = require('uniqid');

const app = express();
app.use(bodyParser.urlencoded({ extended: true }));
app.use(bodyParser.json());

app.use((req, res, next) => {
    res.header('Access-Control-Allow-Origin', '*'); // Autoriser tous les domaines
    res.header('Access-Control-Allow-Headers', 'Origin, X-Requested-With, Content-Type, Accept');
    next();
});

// Route pour créer une clé API
app.post('/createApiKey', (req, res) => {
    const apiKey = uniqid(); // Générer une clé API unique
    const sessionid = req.body.sessionId; // Récupérer l'ID de l'utilisateur depuis la session
    // Mettre à jour la clé API dans la base de données pour l'utilisateur existant
    connection.query('UPDATE users SET api_key = ? WHERE id_user = ?', [apiKey, sessionid], (error, results, fields) => {
        if (error) {
            console.error('Erreur lors de la mise à jour de la clé API :', error);
            res.status(500).json({ error: 'Erreur lors de la mise à jour de la clé API' });
        } else {
            console.log(sessionid);

            res.json({ apiKey }); // Envoyer la clé API générée en réponse
        }
    });
});

// D'autres routes et fonctionnalités de votre API...

const PORT = process.env.PORT || 3000;
app.listen(PORT, () => {
    console.log(`Serveur démarré sur le port ${PORT}`);
});

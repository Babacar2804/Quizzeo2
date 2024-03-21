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

    // Enregistrer la clé API dans la base de données
    connection.query('INSERT INTO users (api_key) VALUES (?)', [apiKey],  (error, results, fields) => {
        if (error) {
            console.error('Erreur lors de la création de la clé API :', error);
            res.status(500).json({ error: 'Erreur lors de la création de la clé API' });
        } else {
            res.json({ apiKey }); // Envoyer la clé API générée en réponse
        }
    });
});

// D'autres routes et fonctionnalités de votre API...

const PORT = process.env.PORT || 3000;
app.listen(PORT, () => {
    console.log(`Serveur démarré sur le port ${PORT}`);
});

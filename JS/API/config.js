const mysql = require('mysql');
// Connexion à la base de données MySQL
const connection = mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: '',
    database: 'quizzeo2'
  });
connection.connect((err) => {
    if (err) {
      console.error('Erreur lors de la connexion à la base de données :', err);
      throw err;
    }
    console.log('Connexion à la base de données réussie');
  });
  
module.exports = connection;
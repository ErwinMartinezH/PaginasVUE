const mysql = require('mysql');

const dbConnection = mysql.createConnection({
  host: '127.0.0.1',
  user: 'root',
  password: '123',
  database: 'proyecto2024'
});

dbConnection.connect((err) => {
  if (err) {
    console.error('Error de conexión a la base de datos:', err);
    return;
  }

  console.log('Conexión exitosa a la base de datos.');
});

module.exports = dbConnection;
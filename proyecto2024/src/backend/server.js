const express = require('express');
const mariadb = require('mariadb');
const app = express();
//añadimos el cors para que se pueda acceder desde el front y no de error Access-Control-Allow-Origin
const cors = require('cors');
app.use(cors());

app.use(express.urlencoded({ extended: true }));

app.use(express.static('public'));


const pool = mariadb.createPool({
  host: '127.0.0.1',
  user: 'root',
  password: '123',
  database: 'proyecto2024',
  connectionLimit: 5
});

app.use(express.json());

// Endpoint para abrir una nueva sesión alumno
app.post('/login', async (req, res) => {
  const { noControl, password } = req.body;
  try {
    const conn = await pool.getConnection();
    const [rows] = await conn.query('SELECT * FROM alumno WHERE noControl = ? AND password = ?', [noControl, password]);
    conn.release();
    if (rows.length > 0) {
      res.status(200).json({ message: 'Sesión iniciada exitosamente' });
    } else {
      res.status(401).json({ error: 'Credenciales incorrectas' });
    }
  } catch (error) {
    console.error('Error al iniciar sesión: ', error);
    res.status(500).json({ error: 'Error al iniciar sesión' });
  }
});

//Endpoint para cerrar sesion actual
app.get('/logout', (req, res) => {
  res.status(200).json({ message: 'Sesión cerrada exitosamente' });
});

app.post('/register', async (req, res) => {
  const { noControl, nombre, apellidos, telefono, email, password, status} = req.body;

  try {
    const conn = await pool.getConnection();
    await conn.query('INSERT INTO alumnos (noControl, nombre, apellidos, telefono, email, password, status) VALUES (?, ?, ?, ?, ?, ?, ?)', [noControl, nombre, apellidos, telefono, email, password, status]);
    conn.release();
    res.status(200).json({ message: 'Usuario registrado exitosamente' });
  } catch (error) {
    console.error('Error al registrar el usuario: ', error);
    res.status(500).json({ error: 'Error al registrar el usuario' });
  }
});

// Endpoint para obtener el usuario en sesión




app.listen(3000, () => {
  console.log('Servidor backend iniciado en el puerto 3000');
});

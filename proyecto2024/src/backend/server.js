const express = require('express');
const mariadb = require('mariadb');
const cors = require('cors');
const session = require('express-session');
const app = express();

const corsOptions = {
  origin: 'http://localhost:8080',
  credentials: true,
  methods: 'GET,HEAD,PUT,PATCH,POST,DELETE',
  allowedHeaders: 'Content-Type, Accept'
};

app.use(cors(corsOptions));
app.use(express.urlencoded({ extended: true }));
app.use(express.static('public'));
app.use(express.json());


const pool = mariadb.createPool({
  host: '127.0.0.1',
  user: 'root',
  password: '123',
  database: 'proyecto2024',
  connectionLimit: 5
});


app.post('/login', async (req, res) => {
  const { noControl, password } = req.body;

  try {
    const conn = await pool.getConnection();
    const rows = await conn.query('SELECT * FROM alumnos WHERE noControl = ? AND password = ?', [noControl, password]);
    conn.release();

    if (rows.length > 0) {
      res.status(200).json({ message: 'Sesión iniciada exitosamente' });
      localStorage.setItem('noControl', noControl);
      localStorage.setItem('password', password);
      localStorage.setItem('isAuthenticated', true);
    } else {
      res.status(401).json({ error: 'Credenciales incorrectas' });
    }
  } catch (error) {
    console.error('Error al iniciar sesión: ', error);
    res.status(500).json({ error: 'Error al iniciar sesión' });
  }
});

app.get('/logout', (req, res) => {
  req.session.destroy((err) => {
    if (err) {
      return res.status(500).json({ error: 'Error al cerrar sesión' });
    }
    res.status(200).json({ message: 'Sesión cerrada exitosamente' });
  });
});

//endpoint para visualizar el nombre y apellidos del alumno. se requiere una sesion iniciada y el noControl del alumno
app.get('/alumno', async (req, res) => {
  const noControl = req.session.noControl;
  try {
    const conn = await pool.getConnection();
    const rows = await conn.query('SELECT nombre, apellidos FROM alumnos WHERE noControl = ?', [noControl]);
    conn.release();
    if (rows.length > 0) {
      res.status(200).json({ nombre: rows[0].nombre, apellidos: rows[0].apellidos });
    } else {
      res.status(404).json({ error: 'Alumno no encontrado' });
    }
  } catch (error) {
    console.error('Error al obtener datos del alumno: ', error);
    res.status(500).json({ error: 'Error al obtener datos del alumno' });
  }
});

app.listen(3000, () => {
  console.log('Servidor backend iniciado en el puerto 3000');
});

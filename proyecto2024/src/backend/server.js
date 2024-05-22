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

app.use(session({
  secret: 'secret',
  resave: false,
  saveUninitialized: false,
  cookie: { secure: false, maxAge: 60000 }
}));

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
      req.session.noControl = noControl; // Guardamos el noControl en la sesión del servidor
      res.status(200).json({ message: 'Sesión iniciada exitosamente', noControl });
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

app.get('/alumno', async (req, res) => {
  if (!req.session.noControl) {
    return res.status(401).json({ error: 'No autorizado' });
  }

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
app.get('/asistencias', async (req, res) => {
  if (!req.session.noControl) {
    return res.status(401).json({ error: 'No autorizado' });
  }
  const noControl = req.session.noControl;
  try {
    const conn = await pool.getConnection();
    const rows = await conn.query('SELECT * FROM vtaalumnogrupos WHERE noControl = ?', [noControl]);
    conn.release();
    if (rows.length > 0) {
      res.status(200).json(rows);
    } else {
      res.status(404).json({ error: 'Asistencias no encontradas' });
    }
  } catch (error) {
    console.error('Error al obtener asistencias: ', error);
    res.status(500).json({ error: 'Error al obtener asistencias' });
  }
});




app.listen(3000, () => {
  console.log('Servidor backend iniciado en el puerto 3000');
});

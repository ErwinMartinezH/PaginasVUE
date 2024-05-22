const express = require('express');
const mariadb = require('mariadb');
const cors = require('cors');
const app = express();

app.use(cors());
app.use(express.urlencoded({ extended: true }));
app.use(express.static('public'));
app.use(express.json());

const usuariosLogueados = {};

const pool = mariadb.createPool({
  host: '127.0.0.1',
  user: 'root',
  password: '123',
  database: 'proyecto2024',
  connectionLimit: 5
});

// Endpoint para iniciar sesión
app.post('/login', async (req, res) => {
  const { noControl, password } = req.body;
  try {
    const conn = await pool.getConnection();
    const rows = await conn.query('SELECT * FROM alumnos WHERE noControl = ? AND password = ?', [noControl, password]);
    conn.release();
    if (rows.length > 0) {
      usuariosLogueados[req.sessionID] = noControl;
      res.status(200).json({ message: 'Sesión iniciada exitosamente' });
    } else {
      res.status(401).json({ error: 'Credenciales incorrectas' });
    }
  } catch (error) {
    console.error('Error al iniciar sesión: ', error);
    res.status(500).json({ error: 'Error al iniciar sesión' });
  }
});

// Endpoint para registro
app.post('/register', async (req, res) => {
  const { noControl, nombre, apellidos, telefono, email, password, status } = req.body;
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

// Endpoint para obtener los datos del alumno y sus materias
app.get('/alumno/materias', async (req, res) => {
  const noControl = req.headers['nocontrol']; // Obtiene el número de control del encabezado de la solicitud
  try {
    const conn = await pool.getConnection();
    const alumno = await conn.query('SELECT * FROM alumnos WHERE noControl = ?', [noControl]);
    const materias = await conn.query(`
      SELECT m.idmateria, m.nombre AS materia, g.idgrupo, concat(p.apellidos, ' ', p.nombre) AS profesor
      FROM alumnogrupos ag
      JOIN materias m ON ag.idmateria = m.idmateria
      JOIN profesorgrupos pg ON m.idmateria = pg.idmateria AND ag.idgrupo = pg.idgrupo
      JOIN profesores p ON pg.idprofesor = p.idprofesor
      WHERE ag.noControl = ?
    `, [noControl]);
    conn.release();
    if (alumno.length > 0) {
      res.status(200).json({ alumno: alumno[0], materias });
    } else {
      res.status(404).json({ error: 'Alumno no encontrado' });
    }
  } catch (error) {
    console.error('Error al obtener datos del alumno: ', error);
    res.status(500).json({ error: 'Error al obtener datos del alumno' });
  }
});

// Endpoint para cerrar sesión
app.get('/logout', (req, res) => {
  // Borrar el número de control de la variable de sesión
  delete usuariosLogueados[req.sessionID];
  res.redirect('/login');
});


// Iniciar servidor
app.listen(3000, () => {
  console.log('Servidor backend iniciado en el puerto 3000');
});

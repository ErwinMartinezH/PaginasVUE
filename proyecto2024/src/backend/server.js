const express = require("express");
const mariadb = require("mariadb");
const cors = require("cors");
const session = require("express-session");
const app = express();

const corsOptions = {
  origin: "http://localhost:8080",
  credentials: true,
  methods: "GET,HEAD,PUT,PATCH,POST,DELETE",
  allowedHeaders: "Content-Type, Accept",
};

app.use(cors(corsOptions));
app.use(express.urlencoded({ extended: true }));
app.use(express.static("public"));
app.use(express.json());

app.use(
  session({
    secret: "secret",
    resave: false,
    saveUninitialized: false,
    cookie: { secure: false, maxAge: 60000 },
  })
);

const pool = mariadb.createPool({
  host: "127.0.0.1",
  user: "root",
  password: "123",
  database: "proyecto2024",
  connectionLimit: 5,
});

app.post("/register", async (req, res) => {
  const { noControl, nombre, apellidos, telefono, email, password, status } = req.body;

  try {
    const conn = await pool.getConnection();
    // Verificar si el usuario ya existe
    const [existingUser] = await conn.query(
      "SELECT * FROM alumnos WHERE noControl = ?",
      [noControl]
    );

    if (existingUser) {
      conn.release();
      return res.status(400).json({ message: "El usuario ya existe" });
    }

    // Insertar nuevo usuario
    await conn.query(
      "INSERT INTO alumnos (noControl, nombre, apellidos, telefono, email, password, status) VALUES (?, ?, ?, ?, ?, ?, ?)",
      [noControl, nombre, apellidos, telefono, email, password, status]
    );
    conn.release();
    res.status(201).json({ message: "Usuario registrado exitosamente" });
  } catch (error) {
    console.error("Error al registrar usuario: ", error);
    res.status(500).json({ error: "Error al registrar usuario" });
  }
});

app.post("/login", async (req, res) => {
  const { noControl, password } = req.body;

  try {
    const conn = await pool.getConnection();
    const rows = await conn.query(
      "SELECT * FROM alumnos WHERE noControl = ? AND password = ?",
      [noControl, password]
    );
    conn.release();

    if (rows.length > 0) {
      req.session.noControl = noControl; // Guardamos el noControl en la sesión del servidor
      res
        .status(200)
        .json({ message: "Sesión iniciada exitosamente", noControl });
    } else {
      res.status(401).json({ error: "Credenciales incorrectas" });
    }
  } catch (error) {
    console.error("Error al iniciar sesión: ", error);
    res.status(500).json({ error: "Error al iniciar sesión" });
  }
});

app.get("/logout", (req, res) => {
  req.session.destroy((err) => {
    if (err) {
      return res.status(500).json({ error: "Error al cerrar sesión" });
    }
    res.status(200).json({ message: "Sesión cerrada exitosamente" });
  });
});

app.get("/alumno", async (req, res) => {
  if (!req.session.noControl) {
    return res.status(401).json({ error: "No autorizado" });
  }

  const noControl = req.session.noControl;
  try {
    const conn = await pool.getConnection();
    const rows = await conn.query(
      "SELECT nombre, apellidos FROM alumnos WHERE noControl = ?",
      [noControl]
    );
    conn.release();
    if (rows.length > 0) {
      res
        .status(200)
        .json({ nombre: rows[0].nombre, apellidos: rows[0].apellidos });
    } else {
      res.status(404).json({ error: "Alumno no encontrado" });
    }
  } catch (error) {
    console.error("Error al obtener datos del alumno: ", error);
    res.status(500).json({ error: "Error al obtener datos del alumno" });
  }
});
app.get("/asistencias", async (req, res) => {
  if (!req.session.noControl) {
    return res.status(401).json({ error: "No autorizado" });
  }
  const noControl = req.session.noControl;
  try {
    const conn = await pool.getConnection();
    const rows = await conn.query(
      "SELECT * FROM vtaalumnogrupos WHERE noControl = ?",
      [noControl]
    );
    conn.release();
    if (rows.length > 0) {
      res.status(200).json(rows);
    } else {
      res.status(404).json({ error: "Asistencias no encontradas" });
    }
  } catch (error) {
    console.error("Error al obtener asistencias: ", error);
    res.status(500).json({ error: "Error al obtener asistencias" });
  }
});

// Ruta para obtener los datos de la materia, grupo y profesor para la fecha y hora actuales
app.get("/datosPasarLista", async (req, res) => {
  try {
    const fecha = new Date().toISOString().split("T")[0]; 
    const hora = new Date().toLocaleTimeString([], { hour: "2-digit", minute: "2-digit", hour12: false }); 
    const query = `
      SELECT * FROM vtaalumnogrupos
      WHERE fecha = ? AND hora = ?;
    `;
    const [row] = await pool.query(query, [fecha, hora]);
    res.json(row); 
  } catch (error) {
    console.error("Error al obtener datos para pasar lista:", error);
    res.status(500).json({ error: "Error al obtener datos para pasar lista" });
  }
});



// Ruta para obtener las asistencias de una materia con un profesor específico
app.get("/asistencias/:idmateria/:idgrupo/:idprofesor", async (req, res) => {
  if (!req.session.noControl) {
    return res.status(401).json({ error: "No autorizado" });
  }

  const { idmateria, idgrupo, idprofesor } = req.params;
  const noControl = req.session.noControl;

  try {
    const conn = await pool.getConnection();
    const rows = await conn.query(
      "SELECT * FROM asistencia WHERE noControl = ? AND idmateria = ? AND idgrupo = ? AND idprofesor = ?",
      [noControl, idmateria, idgrupo, idprofesor]
    );
    conn.release();
    if (rows.length > 0) {
      res.status(200).json(rows);
    } else {
      res.status(404).json({ error: "Asistencias no encontradas" });
    }
  } catch (error) {
    console.error("Error al obtener asistencias: ", error);
    res.status(500).json({ error: "Error al obtener asistencias" });
  }
});

app.listen(3000, () => {
  console.log("Servidor backend iniciado en el puerto 3000");
});

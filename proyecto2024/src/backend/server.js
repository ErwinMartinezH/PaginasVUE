const express = require("express");
const mariadb = require("mariadb");
const cors = require("cors");
const session = require("express-session");
const app = express();

const corsOptions = {
  origin: function (origin, callback) {
    // Lista de orígenes permitidos
    const allowedOrigins = [
      "http://localhost:8080",
      "http://192.168.1.71:8080",
    ];

    // Si la solicitud no incluye el encabezado 'Origin' o si el origen está permitido, permitir la solicitud
    if (!origin || allowedOrigins.includes(origin)) {
      callback(null, true);
    } else {
      callback(new Error("Not allowed by CORS"));
    }
  },
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
    cookie: { secure: false, maxAge: 980000 },
  })
);

const pool = mariadb.createPool({
  host: "127.0.0.1",
  user: "root",
  password: "123",
  database: "proyecto2024",
  connectionLimit: 5,
});

/*Ruta para iniciar sesión*/
app.post("/login", async (req, res) => {
  const { noControl, password } = req.body;

  try {
    const conn = await pool.getConnection();
    const rows = await conn.query(
      "SELECT * FROM alumnos WHERE noControl = ? AND password = ?",
      [noControl, password]
    );
    conn.release(); // Cerramos la base de datos

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

/*Ruta para cerrar sesión*/
app.get("/logout", (req, res) => {
  req.session.destroy((err) => {
    if (err) {
      return res.status(500).json({ error: "Error al cerrar sesión" });
    }
    res.status(200).json({ message: "Sesión cerrada exitosamente" });
  });
});

/*Ruta para obtener datos del usuario logueado*/
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

/*Ruta para obtener asistencias del usuario logueado*/
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

/*Ruta para registrar asistencia*/
app.post("/pasarLista", async (req, res) => {
  const { noControl, idmateria, idgrupo, idprofesor, fecha, hora } = req.body;
  //unir fecha y hora
  const horActual = `${fecha} ${hora}`;
  try {
    const conn = await pool.getConnection();
    // Insertamos la nueva asistencia
    await conn.query(
      "INSERT INTO asistencia (noControl, idmateria, idgrupo, idprofesor, fecha, hora, reg_fecha, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)",
      [noControl, idmateria, idgrupo, idprofesor, fecha, hora, horActual, 1] // reg_fecha es la fecha actual
    );
    conn.release();
    res.status(201).json({ message: "Asistencia registrada exitosamente" });
  } catch (error) {
    console.error("Error al registrar asistencia: ", error);
    res.status(500).json({ error: "Error al registrar asistencia" });
  }
});

/*Ruta para registrar un usuario*/
app.post("/register", async (req, res) => {
  const { noControl, nombre, apellidos, telefono, email, password, status } =
    req.body;

  try {
    const conn = await pool.getConnection();
    // Verificar si el usuario ya existe
    const rows = await conn.query("SELECT * FROM alumnos WHERE noControl = ?", [
      noControl,
    ]);
    if (rows.length > 0) {
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
    res
      .status(500)
      .json({ error: "Error al registrar usuario", details: error.message });
  }
});

/*Ruta para obtener datos para pasar lista*/
app.get(
  "/datosPasarLista/:idmateria/:idgrupo/:idprofesor",
  async (req, res) => {
    if (!req.session.noControl) {
      return res.status(401).json({ error: "No autorizado" });
    }

    const { idmateria, idgrupo, idprofesor } = req.params; // Obtener los parámetros de la ruta
    const noControl = req.session.noControl;

    try {
      const conn = await pool.getConnection();
      const rows = await conn.query(
        "SELECT a.fecha, a.hora, m.nombre AS nombre_materia, m.idmateria, g.idgrupo, p.nombre AS nombre_profesor, p.idprofesor FROM asistencia a INNER JOIN materias m ON a.idmateria = m.idmateria INNER JOIN grupos g ON a.idgrupo = g.idgrupo INNER JOIN profesores p ON a.idprofesor = p.idprofesor WHERE a.noControl = ? AND a.idmateria = ? AND a.idgrupo = ? AND a.idprofesor = ?",
        [noControl, idmateria, idgrupo, idprofesor]
      );
      conn.release();

      if (rows.length > 0) {
        res.status(200).json(rows[0]);
      } else {
        res
          .status(404)
          .json({ error: "Datos para pasar lista no encontrados" });
      }
    } catch (error) {
      console.error("Error al obtener datos para pasar lista:", error);
      res
        .status(500)
        .json({ error: "Error al obtener datos para pasar lista" });
    }
  }
);

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

// Ruta para darse de baja
app.post("/darseDeBaja", async (req, res) => {
  const { noControl, idmateria, idprofesor, idgrupo } = req.body;

  try {
    const conn = await pool.getConnection();
    // Actualizamos el campo status en la tabla alumnogrupos
    await conn.query(
      "UPDATE alumnogrupos SET status = 0 WHERE noControl = ? AND idmateria = ? AND idprofesor = ? AND idgrupo = ?",
      [noControl, idmateria, idprofesor, idgrupo]
    );
    conn.release();
    res.status(200).json({ message: "Alumno dado de baja exitosamente" });
  } catch (error) {
    console.error("Error al dar de baja al alumno: ", error);
    res.status(500).json({ error: "Error al dar de baja al alumno" });
  }
});

app.get("/grupos", async (req, res) => {
  const noControl = req.query.noControl;
  if (!noControl) {
    return res.status(400).json({ error: "NoControl es requerido" });
  }
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
      res.status(404).json({ error: "Grupos no encontrados" });
    }
  } catch (error) {
    console.error("Error al obtener grupos: ", error);
    res.status(500).json({ error: "Error al obtener grupos" });
  }
});

// Endpoint para obtener los grupos disponibles
app.get("/gruposDisponibles", async (req, res) => {
  try {
    const conn = await pool.getConnection();
    const rows = await pool.query(
      "SELECT * FROM proyecto2024.vtaprofesorgrupos"
    );
    conn.release();
    if (rows.length > 0) {
      res.status(200).json(rows);
    } else {
      res.status(404).json({ error: "Grupos no encontrados" });
    }
  } catch (error) {
    console.error("Error al obtener grupos: ", error);
    res.status(500).json({ error: "Error al obtener grupos" });
  }
});

// Endpoint para darse de alta en un grupo
app.post("/darseDeAlta", async (req, res) => {
  const { noControl, idprofesor, idmateria, idgrupo } = req.body;
  try {
    const conn = await pool.getConnection();
   //si el alumno ya tenia un grupo y marca status = 0, debera cambiar el status a 1, de lo contrario se inserta en la tabla
    if(await conn.query("SELECT * FROM alumnogrupos WHERE noControl = ? AND idmateria = ? AND idprofesor = ? AND idgrupo = ? AND status = 0", [noControl, idmateria, idprofesor, idgrupo])){
      await conn.query(
        "UPDATE alumnogrupos SET status = 1 WHERE noControl = ? AND idmateria = ? AND idprofesor = ? AND idgrupo = ?",
        [noControl, idmateria, idprofesor, idgrupo]
      );
    }else{
      await conn.query(
        "INSERT INTO alumnogrupos (noControl, idmateria, idprofesor, idgrupo, status) VALUES (?, ?, ?, ?, ?)",
        [noControl, idmateria, idprofesor, idgrupo, 1]
      );
    }
    conn.release();
    res.status(200).json({ message: "Alumno dado de alta exitosamente en el grupo" });
  } catch (error) {
    console.error("Error al dar de alta al alumno en el grupo:", error);
    res.status(500).json({ error: "Error al dar de alta al alumno en el grupo" });
  }
});


/*Ejecutamos el servidor en el puerto 3000*/
app.listen(3000, () => {
  console.log("Servidor backend iniciado en el puerto 3000");
});

//recargar servidor en caso de error
process.on("uncaughtException", (err) => {
  console.error("Uncaught Exception: ", err);
  process.exit(1);
});

//recarga servidor en automatico
process.on("SIGINT", () => {
  process.exit(0);
})
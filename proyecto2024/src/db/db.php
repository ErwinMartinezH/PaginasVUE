<!--Conexion a la base de datos MariaDB por PHP
  host: '127.0.0.1',
  user: 'root',
  password: '123',
  database: 'proyecto2024'

  Crear un metodo para registrar un alumno
  y crear un metodo para consultar si existe el no. de control y contraseña
-->

<?php

  $servername = "127.0.0.1";
  $username = "root";
  $password = "123";
  $dbname = "proyecto2024";

  $conn = new mysqli($servername, $username, $password, $dbname);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  function registerAlumno($alumnoData) {
    global $conn;

    $noControl = $alumnoData["noControl"];
    $nombre = $alumnoData["nombre"];
    $apellido = $alumnoData["apellido"];
    $telefono = $alumnoData["telefono"];
    $correo = $alumnoData["correo"];
    $password = $alumnoData["password"];

    // Verificar si el alumno ya existe
    $sql = "SELECT * FROM alumnos WHERE noControl = '$noControl'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "El alumno ya está registrado.";
        return;
    }

    // Insertar nuevo alumno
    $sql = "INSERT INTO alumnos (noControl, nombre, apellido, telefono, correo, password) VALUES ('$noControl', '$nombre', '$apellido', '$telefono', '$correo', '$password')";

    if ($conn->query($sql) === TRUE) {
        echo "Registro exitoso";
    } else {
        echo "Error al registrar: " . $conn->error;
    }
}

  function consultarAlumno($noControl) {
    global $conn;

    $sql = "SELECT * FROM alumno WHERE noControl = '$noControl'";

    $result = $conn->query($sql);
  }
?>
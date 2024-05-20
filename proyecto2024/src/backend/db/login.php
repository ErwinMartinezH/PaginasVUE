<!--aqui haremos el login, necesitaremos conexion a la base de datos
y los datos de usuario:
noControl y password

la base de datos su conexion es:
  host: '127.0.0.1',
  user: 'root',
  password: '123',
  database: 'proyecto2024'
-->
<?php

$host = '127.0.0.1';
$user = 'root';
$password = '123';
$database = 'proyecto2024';

$connection = mysqli_connect($host, $user, $password, $database);

if (!$connection) {
    die('Error de conexión: ' . mysqli_connect_error());
}

// Validar los datos de inicio de sesión
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $noControl = $_POST['noControl'];
    $password = $_POST['password'];

    $query = "SELECT * FROM usuarios WHERE noControl = '$noControl' AND password = '$password'";
    $result = mysqli_query($connection, $query);

    if (mysqli_num_rows($result) > 0) {
        // Inicio de sesión exitoso
        session_start();
        $_SESSION['noControl'] = $noControl;
        $_SESSION['password'] = $password;
        // Redirigir al usuario a la página de inicio localhost:8080/main
        header('Location: http://localhost:8080/main');
        exit();
    } else {
        // Inicio de sesión fallido
        $error = 'Credenciales incorrectas';
    }
}

mysqli_close($connection);
?>
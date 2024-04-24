<?php
// Incluir el archivo de conexión
require_once 'conexion.php';

// Obtener los datos enviados por el formulario de registro
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Realizar la consulta para insertar un nuevo usuario en la base de datos
    $sql = "INSERT INTO usuarios (nombre, apellido, email, password) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $nombre, $apellido, $email, $password);
    
    if ($stmt->execute()) {
        // Redirigir al usuario a la página de inicio de sesión después del registro exitoso
        header("Location: login.php");
        exit();
    } else {
        // Mostrar un mensaje de error si ocurre algún problema durante el registro
        $error = "Error al registrar el usuario. Inténtalo de nuevo.";
    }
}
?>

<html><head>
  <title>Registro de cuenta</title>
  <style>
    .container {
      position: fixed;
      top: 0;
      right: 0;
      bottom: 0;
      left: 0;
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
      background-image: url("/fakebook/assets/biblioteca.jpg");
      width: 100vw;
      height: 100vh;
    }

    .registration {
      background-color: rgba(255, 255, 255, 0.9);
      border-radius: 20px;
      box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.1);
      display: flex;
      overflow: hidden;
      animation: fadeIn 0.5s ease forwards;
    }

    .form-container {
      flex: 1;
      padding: 50px;
      margin-top: -30px;
      margin-bottom: -40px;
    }

    .title {
      font-size: 24px;
      font-weight: bold;
      margin-bottom: 20px;
      color: #000000;
      text-shadow: none;
    }

    .form-group {
      margin-bottom: 20px;
    }

    label {
      color: #333333;
    }

    .input {
      width: 100%;
      padding: 15px;
      border-radius: 10px;
      border: 1px solid #cccccc;
      outline: none;
      transition: border-color 0.3s ease;
    }

    .input:focus {
      border-color: #764ba2;
    }

    .button {
      width: 100%;
      background-color: #764ba2;
      color: #ffffff;
      padding: 15px;
      border: none;
      border-radius: 10px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .button:hover {
      background-color: #5c3998;
    }

    .message {
      font-size: 14px;
      margin-top: 20px;
    }

    .message a {
      color: #764ba2;
      text-decoration: none;
    }

    .message a:hover {
      text-decoration: underline;
    }

    .logo-container {
      display: flex;
      align-items: center;
      justify-content: center;
      margin-right: -20px;
    }

    .logo {
      max-width: auto;
      height: auto;
      margin-left: 10px ;
      margin-top: 20px;
      margin-bottom: 10px;
    }
  </style>
<style>undefined</style></head>
<body>
  <div class="container">
    <div class="registration">
      <div class="logo-container">
        <img src="http://localhost/fakebook/assets/logoF.png" class="logo" alt="Biblioteca">
      </div>
      <div class="form-container">
        <h1 class="title">Registro de cuenta</h1>
        <form action="registro.php" method="POST">
          <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" placeholder="Ingrese su nombre" class="input" required>
          </div>
          <div class="form-group">
            <label for="apellido">Apellido:</label>
            <input type="text" id="apellido" name="apellido" placeholder="Ingrese su apellido" class="input" required>
          </div>
          <div class="form-group">
            <label for="email">Correo electrónico:</label>
            <input type="email" id="email" name="email" placeholder="Ingrese su correo electrónico" class="input" required>
          </div>
          <div class="form-group">
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" placeholder="Ingrese su contraseña" class="input" required>
          </div>
          <div class="form-group">
            <label for="confirmPassword">Confirmar contraseña:</label>
            <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirme su contraseña" class="input" required>
          </div>
          <button type="submit" class="button">Crear cuenta</button>
        </form>
        <p class="message">¿Ya tienes una cuenta? <a href="/fakebook/views/login.php">Iniciar sesión</a></p>
      </div>
    </div>
  </div>
</body></html>
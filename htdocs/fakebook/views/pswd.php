<?php
// Incluir el archivo de conexión
require_once 'conexion.php';

// Verificar si el usuario ha iniciado sesión
session_start();
if (!isset($_SESSION["email"])) {
    // Redirigir al usuario a la página de inicio de sesión si no ha iniciado sesión
    header("Location: login.php");
    exit();
}

// Obtener el email del usuario actual
$email = $_SESSION["email"];

// Obtener los detalles del usuario de la base de datos
$sql = "SELECT * FROM usuarios WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$userResult = $stmt->get_result();
$user = $userResult->fetch_assoc();

// Verificar si se enviaron los datos del formulario de cambio de contraseña
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos enviados por el formulario
    $password_actual = $_POST["password_actual"];
    $nueva_password = $_POST["nueva_password"];
    $confirmar_password = $_POST["confirmar_password"];

    // Validar los datos del formulario
    $errors = array();

    // Verificar si la contraseña actual coincide con la contraseña almacenada en la base de datos
    if ($password_actual !== $user["password"]) {
        $errors[] = "La contraseña actual es incorrecta.";
    }

    // Verificar si la nueva contraseña y la confirmación coinciden
    if ($nueva_password !== $confirmar_password) {
        $errors[] = "La nueva contraseña y la confirmación no coinciden.";
    }

    if (empty($errors)) {
        // Actualizar la contraseña del usuario en la base de datos
        $updateSql = "UPDATE usuarios SET password = ? WHERE email = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("ss", $nueva_password, $email);

        if ($updateStmt->execute()) {
            // Redirigir al usuario a la página de configuración con un mensaje de éxito
            header("Location: pswd.php?success=true");
            exit();
        } else {
            // Mostrar un mensaje de error si ocurre algún problema durante la actualización
            $error = "Error al cambiar la contraseña. Inténtalo de nuevo.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cambiar Contraseña - Fakebook Library</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: 'Roboto', sans-serif;
      background-color: #f8f9fa;
    }

    .container {
      max-width: 800px;
      margin: 0 auto;
      padding-top: 60px; /* Espacio para el encabezado */
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .header {
      position: fixed;
      top: 0;
      background-color: #343a40;
      color: #ffffff;
      padding: 10px;
      width: 100%;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .logo-container {
      display: flex;
      align-items: center;

    }

    .logo {
      font-weight: bold;
      font-size: 24px;
    }

    .logo img {
      max-height: 50px;
      margin-right: 10px;
    }

    .user-info {
      display: flex;
      align-items: center;
    }

    .user-info span {
      margin-right: 15px;
    }

    .user-menu {
      position: relative;
      cursor: pointer;
    }

    .user-menu-content {
      display: none;
      position: absolute;
      background-color: #ffffff;
      box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.2);
      z-index: 1;
      top: 100%; /* Posicionamiento debajo del menú */
      right: 0;
    }

    .user-menu:hover .user-menu-content {
      display: block;
    }

    .user-menu-item {
      padding: 10px;
      cursor: pointer;
      transition: background-color 0.3s ease;
      color: #0a0a0a;
      text-decoration: none;
      display: inline-block;
      margin-right: 10px;
    }

    .user-menu-item:hover {
      background-color: #6c757d;
    }

    .logout-link {
      display: block;
      margin-top: 10px;
      color: #f00;
      text-align: center;
      text-decoration: none;
    }

    form {
      background-color: #fff;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 400px;
    }

    h1 {
      text-align: center;
      margin-bottom: 30px;
    }

    label {
      display: block;
      font-weight: bold;
      margin-bottom: 5px;
    }

    input[type="text"],
    input[type="email"],
    input[type="password"] {
      width: 100%;
      padding: 10px;
      margin-bottom: 20px;
      border: 1px solid #ced4da;
      border-radius: 5px;
      box-sizing: border-box;
    }

    button[type="submit"] {
      background-color: #007bff;
      color: #ffffff;
      border: none;
      border-radius: 5px;
      padding: 10px 20px;
      cursor: pointer;
      font-size: 16px;
      width: 100%;
    }

    button[type="submit"]:hover {
      background-color: #0056b3;
    }

    .message {
      margin-top: 20px;
      padding: 10px;
      border-radius: 5px;
    }

    .success-message {
      background-color: #d4edda;
      color: #155724;
    }

    .error-message {
      background-color: #f8d7da;
      color: #721c24;
    }
  </style>
</head>
<body>
  <!-- Encabezado -->
  <div class="header">
  <div class="logo-container">
    <img src="/fakebook/assets/logoF.png" class="logo" alt="Biblioteca" style="width: 50px; height: auto;">
    <div class="logo">Fakebook Library</div>
</div>

    <!-- Menú de usuario -->
    <div class="user-info">
      <a style="color: white;" href="user.php" class="user-menu-item">Inicio</a>
      <span>Bienvenido, <?php echo $user["nombre"] . ' ' . $user["apellido"]; ?></span>
      <div class="user-menu">
            <span>☰</span>
            <div class="user-menu-content">
              <a class="user-menu-item" href="conf.php">Configuracion</a>
              <?php if($user["rol"] == 1): ?>
            <a class="user-menu-item" href="book.php">Administrar libros</a>
        <?php endif; ?>
              <a class="user-menu-item" href="logout.php">Cerrar sesión</a>
            </div>
          </div>
    </div>
  </div>

  <!-- Contenido principal -->
  <div class="container">
    <h1>Cambiar Contraseña</h1>

    <!-- Formulario para cambiar contraseña -->
    <form method="post">
      <div class="form-group">
        <label for="password_actual">Contraseña Actual:</label>
        <input type="password" name="password_actual" id="password_actual" required>
      </div>

      <div class="form-group">
        <label for="nueva_password">Nueva Contraseña:</label>
        <input type="password" name="nueva_password" id="nueva_password" required>
      </div>

      <div class="form-group">
        <label for="confirmar_password">Confirmar Nueva Contraseña:</label>
        <input type="password" name="confirmar_password" id="confirmar_password" required>
      </div>

      <button type="submit">Cambiar Contraseña</button>
    </form>

    <!-- Mostrar mensajes de éxito o error -->
    <?php if (!empty($errors)): ?>
      <ul class="message error-message">
        <?php foreach ($errors as $error): ?>
          <li><?php echo $error; ?></li>
        <?php endforeach; ?>
      </ul>
    <?php elseif (isset($error)): ?>
      <p class="message error-message"><?php echo $error; ?></p>
    <?php endif; ?>
  </div>

</body>
</html>

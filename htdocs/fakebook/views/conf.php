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

// Verificar si se enviaron los datos del formulario de configuración
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos enviados por el formulario
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $nuevoEmail = $_POST["email"];

    // Validar los datos del formulario
    $errors = array();

    if (empty($nombre)) {
        $errors[] = "El campo Nombre es requerido.";
    }

    if (empty($apellido)) {
        $errors[] = "El campo Apellido es requerido.";
    }

    if (empty($nuevoEmail)) {
        $errors[] = "El campo Email es requerido.";
    } elseif (!filter_var($nuevoEmail, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "El Email ingresado no es válido.";
    }

    if (empty($errors)) {
        // Actualizar los datos del usuario en la base de datos
        $updateSql = "UPDATE usuarios SET nombre = ?, apellido = ?, email = ? WHERE email = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("ssss", $nombre, $apellido, $nuevoEmail, $email);

        if ($updateStmt->execute()) {
            // Actualizar el email en la sesión si ha cambiado
            if ($nuevoEmail != $email) {
                $_SESSION["email"] = $nuevoEmail;
            }

            // Redirigir al usuario a la página de configuración con un mensaje de éxito
            header("Location: conf.php?success=true");
            exit();
        } else {
            // Mostrar un mensaje de error si ocurre algún problema durante la actualización
            $error = "Error al actualizar los datos. Inténtalo de nuevo.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Configuración de Usuario - Fakebook Library</title>
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
  <div class="header">
  <div class="logo-container">
    <img src="/fakebook/assets/logoF.png" class="logo" alt="Biblioteca" style="width: 50px; height: auto;">
    <div class="logo">Fakebook Library</div>
</div>

    <div class="user-info">
      <a style="color: white;" href="user.php" class="user-menu-item">Inicio</a>
      <span>Bienvenido, <?php echo $user["nombre"] . ' ' . $user["apellido"]; ?></span>
      <div class="user-menu">
            <span>☰</span>
            <div class="user-menu-content">
              <a class="user-menu-item" href="pswd.php">Cambiar Contraseña</a>
              <?php if($user["rol"] == 1): ?>
            <a class="user-menu-item" href="book.php">Administrar libros</a>
        <?php endif; ?>
              <a class="user-menu-item" href="logout.php">Cerrar sesión</a>
            </div>
          </div>
    </div>
  </div>

  <div class="container">
    <h1>Configuración de Usuario</h1>

    <form method="post">
      <h2>Actualizar Información</h2>
      <div class="form-group">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" value="<?php echo htmlspecialchars($user["nombre"]); ?>" required>
      </div>

      <div class="form-group">
        <label for="apellido">Apellido:</label>
        <input type="text" name="apellido" id="apellido" value="<?php echo htmlspecialchars($user["apellido"]); ?>" required>
      </div>

      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($user["email"]); ?>" required>
      </div>

      <button type="submit">Guardar Cambios</button>
    </form>

    <?php
    // Mostrar mensajes de éxito o error
    if (isset($_GET["success"]) && $_GET["success"] == "true"): ?>
      <p class="message success-message">Los datos se actualizaron correctamente.</p>
    <?php elseif (!empty($errors)): ?>
      <ul class="message error-message">
        <?php foreach ($errors as $error): ?>
          <li><?php echo $error; ?></li>
        <?php endforeach; ?>
      </ul>
    <?php elseif (isset($error)): ?>
      <p class="message error-message"><?php echo $error; ?></p>
    <?php endif; ?>
  </div>

  <script>
    // Agregar funcionalidad de despliegue del menú de usuario
    const userMenu = document.querySelector('.user-menu');
    const userMenuContent = document.querySelector('.user-menu-content');

    userMenu.addEventListener('click', (event) => {
      event.stopPropagation(); // Evitar que el evento click del documento se active
      userMenuContent.classList.toggle('show');
    });

    // Agregar evento de clic al documento para cerrar el menú cuando se hace clic fuera del menú
    document.addEventListener('click', (event) => {
      const target = event.target;
      if (!target.closest('.user-menu')) {
        userMenuContent.classList.remove('show');
      }
    });
  </script>
</body>
</html>

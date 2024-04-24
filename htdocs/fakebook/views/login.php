<?php
// Incluir el archivo de conexión
require_once 'conexion.php';

// Declarar la variable de error
$error = '';

// Obtener los datos enviados por el formulario de inicio de sesión
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Realizar la consulta para verificar las credenciales del usuario
    $sql = "SELECT * FROM usuarios WHERE email = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar si se encontró un resultado
    if ($result->num_rows == 1) {
        // Iniciar sesión y redirigir al usuario a la página principal
        session_start();
        $_SESSION["email"] = $email;
        header("Location: /fakebook/views/user.php");
        exit();
    } else {
        // Establecer el mensaje de error
        $error = "Credenciales incorrectas. Inténtalo de nuevo.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Inicio de sesión - Fakebook Library</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: 'Roboto', sans-serif;
    }

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
      background-size: cover;
      background-position: center;
    }

    .login-container {
      background-color: rgba(255, 255, 255, 0.9);
      border-radius: 20px;
      box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.1);
      display: flex;
      overflow: hidden;
      animation: fadeIn 0.5s ease forwards;
    }

    .logo-container {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
      margin-top: 10px;
      margin-bottom: 10px;
      margin-left: 10px;
      margin-right: -40px;
    }

    .logo {
      max-width: auto;
      height: auto;
    }

    .form-container {
      flex: 1;
      padding: 50px;
    }

    .title {
      font-size: 24px;
      font-weight: bold;
      margin-bottom: 20px;
      color: #000000;
      text-shadow: none;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(-50px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .subtitle {
      font-size: 14px;
      color: #000000;
      margin-bottom: 30px;
      text-shadow: none;
    }

    .input-container {
      margin-bottom: 20px;
    }

    .input {
      width: 100%;
      padding: 15px;
      border-radius: 10px;
      border: 1px solid #cccccc;
      outline: none;
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

    .link-container {
      font-size: 14px;
      margin-top: 20px;
    }

    .link-container a {
      color: #764ba2;
      text-decoration: none;
    }

    .link-container a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="login-container">
      <div class="logo-container">
        <img src="/fakebook/assets/logoF.png" class="logo" alt="Biblioteca" />
      </div>
      <div class="form-container">
        <h1 class="title">¡Bienvenido a Fakebook Library!</h1>
        <p class="subtitle">Explora nuestro mundo de libros virtuales y sumérgete en la magia de la lectura.</p>
        <form action="login.php" method="post">
          <div class="input-container">
            <input type="email" id="email" name="email" placeholder="Ingresa tu email" class="input" required />
          </div>
          <div class="input-container">
            <input type="password" id="password" name="password" placeholder="Ingresa tu contraseña" class="input" required />
          </div>
          <button type="submit" class="button">Iniciar sesión</button>
          <div class="link-container">
            ¿No tienes una cuenta?
            <a href="/fakebook/views/registro.php" class="link">
              ¡Regístrate aquí y únete a la aventura literaria!
            </a>
          </div>
          <div class="link-container">
            <a href="#" class="link">
              ¿Olvidaste tu contraseña? Tranquilo, te ayudamos a recuperarla.
            </a>
          </div>
        </form>
        <!-- Agregar la siguiente sección para mostrar el mensaje de error -->
        <?php if ($error): ?>
          <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>
      </div>
    </div>
  </div>
</body>
</html> 
<?php
// Incluir el archivo de conexión
require_once 'conexion.php';

// Verificar si el usuario ha iniciado sesión
session_start();
if (!isset($_SESSION["email"])) {
    // El usuario no ha iniciado sesión, redirigir al formulario de inicio de sesión
    header("Location: login.php");
    exit();
}

// Obtener información del usuario
$email = $_SESSION["email"];

// Realizar la consulta para obtener los datos del usuario
$sql = "SELECT nombre, apellido, email, rol FROM usuarios WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

// Verificar si se encontró un resultado
if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $nombre = htmlspecialchars($row["nombre"]);
    $apellido = htmlspecialchars($row["apellido"]);
    $correo = htmlspecialchars($row["email"]);
    $rol = $row["rol"];
} else {
    // No se encontró el usuario, redirigir al formulario de inicio de sesión
    header("Location: login.php");
    exit();
}

// Obtener la lista de libros desde la base de datos
$sql_libros = "SELECT * FROM libros";
$result_libros = $conn->query($sql_libros);
$libros = $result_libros->fetch_all(MYSQLI_ASSOC);

?>


<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Página Principal - Fakebook Library</title>
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
      margin-left: 10px; /* Agrega un margen izquierdo de 20px */
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
      color: #000000; /* Color del texto */
      text-decoration: none; /* Eliminar subrayado */
      display: block; /* Hacer los elementos de menú ocupar todo el ancho */
    }

    .user-menu-item:hover {
      background-color: #e9ecef;
    }

    .feed {
      background-color: #ffffff;
      box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
      padding: 20px;
      margin-top: 20px;
      border-radius: 8px; /* Añade bordes redondeados al feed */
    }

    .post {
      margin-bottom: 20px;
      padding-bottom: 20px;
      border-bottom: 1px solid #e0e0e0;
      display: flex;
      align-items: center;
    }

    .book-image {
      max-width: 150px;
      height: auto;
      margin-right: 20px;
      border-radius: 8px;
      box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
    }

    .post-content {
      flex-grow: 1;
    }

    .post-content a {
      color: #007bff; /* Cambia el color de los enlaces */
      text-decoration: none; /* Elimina el subrayado */
      transition: color 0.3s ease; /* Agrega una transición suave al color */
    }

    .post-content a:hover {
      color: #0056b3; /* Cambia el color al pasar el ratón */
    }

    .post-info {
      display: flex;
      align-items: center;
      font-size: 14px; /* Ajusta el tamaño del texto de la información */
      color: #888888; /* Cambia el color del texto de la información */
    }

    .post-info .author {
      font-weight: bold;
      margin-right: 10px;
    }

    .post-info .timestamp {
      font-size: 12px;
      color: #888888;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="header">
    <div class="logo-container">
    <img src="/fakebook/assets/logoF.png" class="logo" alt="Biblioteca" style="width: 50px; height: auto;">
    <div class="logo">Fakebook Library</div>
</div>

      <div class="user-info">
        <span>Bienvenido, <?php echo $nombre . ' ' . $apellido; ?></span>
        <div class="user-menu">
          <span>☰</span>
          <div class="user-menu-content">
            <a class="user-menu-item" href="conf.php">Configuracion</a>
            <?php if($rol == 1): ?>
              <a class="user-menu-item" href="book.php">Administrar libros</a>
            <?php endif; ?>
            <a class="user-menu-item" href="pswd.php">Cambiar Contraseña</a>
            <a class="user-menu-item" href="logout.php">Cerrar sesión</a>
          </div>
        </div>
      </div>
    </div>
    <div class="feed">
      <div class="post">
        <div class="post-content">
          Bienvenido a Fakebook Library. Explora nuestra colección de libros disponibles.
        </div>
        <div class="post-info">
          <span class="author">Fakebook Library</span>
          <span class="timestamp">Publicado el <?php echo date("d/m/Y"); ?></span>
        </div>
      </div>
      <?php foreach ($libros as $libro): ?>
        <div class="post">
        <a href="<?php echo htmlspecialchars($libro['enlace']); ?>" target="_blank">
            <img src="<?php echo htmlspecialchars($libro['img']); ?>" alt="<?php echo htmlspecialchars($libro['titulo']); ?>" class="book-image">
        </a>
          <div class="post-content">
          <p><a href="<?php echo htmlspecialchars($libro['enlace']); ?>" target="_blank"><?php echo htmlspecialchars($libro['titulo']); ?></a></p>
            <p class="genre">Género: <?php echo htmlspecialchars($libro['genero']); ?></p>
            <p class="author"><?php echo htmlspecialchars($libro['autor']); ?></p>
            <p class="timestamp">Publicado el <?php echo date("d/m/Y", strtotime($libro['fecha_publicacion'])); ?></p>
          </div>
        </div>
      <?php endforeach; ?>
      <?php if (empty($libros)): ?>
        <p>No hay libros disponibles en este momento. ¡Vuelve pronto!</p>
      <?php endif; ?>
    </div>
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

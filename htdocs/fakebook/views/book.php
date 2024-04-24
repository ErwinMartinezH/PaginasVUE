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
$sql = "SELECT nombre, apellido, email FROM usuarios WHERE email = ?";
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
} else {
  // No se encontró el usuario, redirigir al formulario de inicio de sesión
  header("Location: login.php");
  exit();
}

// Mensajes de éxito o error para la inserción, actualización y eliminación de libros
$insert_success = $insert_error = $update_success = $update_error = $delete_success = $delete_error = '';

// Manejar la inserción de un nuevo libro, actualización o eliminación
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST['submit_add'])) {
    // Manejar la inserción de un nuevo libro
    $titulo = isset($_POST['titulo']) ? $_POST['titulo'] : '';
    $autor = isset($_POST['autor']) ? $_POST['autor'] : '';
    $genero = isset($_POST['genero']) ? $_POST['genero'] : '';
    $enlace = isset($_POST['enlace']) ? $_POST['enlace'] : '';
    $fecha_publicacion = isset($_POST['fecha_publicacion']) ? $_POST['fecha_publicacion'] : '';
    $img = isset($_POST['img']) ? $_POST['img'] : '';

    // Validar datos
    if (!empty($titulo) && !empty($autor) && !empty($enlace) && !empty($fecha_publicacion) && !empty($img)) {
      $sql_insert = "INSERT INTO libros (titulo, autor, genero, enlace, fecha_publicacion, img) VALUES (?, ?, ?, ?, ?, ?)";
      $stmt_insert = $conn->prepare($sql_insert);
      $stmt_insert->bind_param("ssssss", $titulo, $autor, $genero, $enlace, $fecha_publicacion, $img);

      if ($stmt_insert->execute()) {
        $insert_success = "Libro añadido correctamente.";
      } else {
        $insert_error = "Error al añadir el libro: " . $stmt_insert->error;
      }
    } else {
      $insert_error = "Por favor, complete todos los campos.";
    }
  } elseif (isset($_POST['submit_delete'])) {
    // Manejar la eliminación de un libro
    $id = isset($_POST['id']) ? $_POST['id'] : '';

    if (!empty($id)) {
      $sql_delete = "DELETE FROM libros WHERE id = ?";
      $stmt_delete = $conn->prepare($sql_delete);
      $stmt_delete->bind_param("i", $id);

      if ($stmt_delete->execute()) {
        $delete_success = "Libro eliminado correctamente.";
      } else {
        $delete_error = "Error al eliminar el libro: " . $stmt_delete->error;
      }
    } else {
      $delete_error = "Por favor, seleccione un libro para eliminar.";
    }
  } elseif (isset($_POST['submit_update'])) {
    // Manejar la actualización de un libro
    $id = isset($_POST['id']) ? $_POST['id'] : '';
    $titulo = isset($_POST['titulo']) ? $_POST['titulo'] : '';
    $autor = isset($_POST['autor']) ? $_POST['autor'] : '';
    $genero = isset($_POST['genero']) ? $_POST['genero'] : '';
    $enlace = isset($_POST['enlace']) ? $_POST['enlace'] : '';
    $fecha_publicacion = isset($_POST['fecha_publicacion']) ? $_POST['fecha_publicacion'] : '';
    $img = isset($_POST['img']) ? $_POST['img'] : '';

    // Validar datos
    if (!empty($id) && !empty($titulo) && !empty($autor) && !empty($enlace) && !empty($fecha_publicacion) && !empty($img)) {
      $sql_update = "UPDATE libros SET titulo=?, autor=?, genero=?, enlace=?, fecha_publicacion=?, img=? WHERE id=?";
      $stmt_update = $conn->prepare($sql_update);
      $stmt_update->bind_param("ssssssi", $titulo, $autor, $genero, $enlace, $fecha_publicacion, $img, $id);

      if ($stmt_update->execute()) {
        $update_success = "Libro actualizado correctamente.";
      } else {
        $update_error = "Error al actualizar el libro: " . $stmt_update->error;
      }
    } else {
      $update_error = "Por favor, complete todos los campos.";
    }
  }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Añadir/Actualizar/Eliminar Libros - Fakebook Library</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
  <style>
    /* Estilos CSS */

    body {
      margin: 0;
      padding: 0;
      font-family: 'Roboto', sans-serif;
      background-color: #f8f9fa;
    }

    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding-top: 60px;
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
      margin-left: 10px;
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
      top: 100%;
      right: 0;
    }

    .user-menu:hover .user-menu-content {
      display: block;
    }

    .user-menu-item {
      padding: 10px;
      cursor: pointer;
      transition: background-color 0.3s ease;
      color: #000000;
      text-decoration: none;
      display: block;
    }

    .user-menu-item:hover {
      background-color: #0056b3;
    }

    .content {
      background-color: #ffffff;
      box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
      padding: 20px;
      margin-top: 20px;
      border-radius: 8px;
      display: flex;
      flex-direction: row;
      justify-content: space-between;
      align-items: flex-start;
      max-width: 1200px;
    }

    .form-container {
      flex-basis: 50%;
      padding: 20px;
      border-right: 1px solid #ccc;
    }

    .form-container h2 {
      margin-bottom: 20px;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-group label {
      display: block;
      font-weight: bold;
      margin-bottom: 5px;
    }

    .form-group input[type="text"],
    .form-group input[type="date"] {
      width: 100%;
      padding: 10px;
      border: 1px solid #ced4da;
      border-radius: 5px;
      box-sizing: border-box;
    }

    .form-group input[type="submit"],
    .form-group input[type="reset"] {
      width: 100%;
      padding: 10px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .form-group input[type="submit"] {
      background-color: #007bff;
      color: #ffffff;
    }

    .form-group input[type="reset"] {
      background-color: #6c757d;
      color: #ffffff;
      margin-top: 10px;
    }

    .form-group input[type="submit"]:hover,
    .form-group input[type="reset"]:hover {
      background-color: #0056b3;
    }

    .table-container {
      flex-basis: 50%;
      padding: 20px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    th,
    td {
      padding: 8px;
      text-align: left;
      border-bottom: 1px solid #dddddd;
    }

    th {
      background-color: #f2f2f2;
    }

    .selected-row {
      background-color: #f0f0f0;
    }

    #searchInput {
      width: 100%;
      padding: 10px;
      margin-bottom: 20px;
      border: 1px solid #ccc;
      border-radius: 5px;
      box-sizing: border-box;
    }

    /* Estilos para dispositivos móviles */

    @media screen and (max-width: 768px) {
      .content {
        flex-direction: column;
      }

      .form-container,
      .table-container {
        flex-basis: auto;
        width: 100%;
        border-right: none;
        border-bottom: 1px solid #ccc;
      }
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
        <a style="color: white;" class="user-menu-item" href="user.php">Inicio</a>
        <span>Bienvenido, <?php echo $nombre . ' ' . $apellido; ?></span>
        <div class="user-menu">
          <span>☰</span>
          <div class="user-menu-content">
            <a class="user-menu-item" href="conf.php">Configuracion</a>
            <a class="user-menu-item" href="pswd.php">Cambiar Contraseña</a>
            <a class="user-menu-item" href="logout.php">Cerrar sesión</a>
          </div>
        </div>
      </div>
    </div>
    <div class="content">
      <div class="form-container">
        <h2>Añadir/Actualizar/Eliminar Libro</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
          <div class="form-group">
            <input type="hidden" id="id" name="id">
          </div>
          <div class="form-group">
            <label for="titulo">Título:</label>
            <input type="text" id="titulo" name="titulo" required>
          </div>
          <div class="form-group">
            <label for="autor">Autor:</label>
            <input type="text" id="autor" name="autor" required>
          </div>
          <div class="form-group">
            <label for="genero">Género:</label>
            <input type="text" id="genero" name="genero">
          </div>
          <div class="form-group">
            <label for="enlace">Enlace:</label>
            <input type="text" id="enlace" name="enlace" required>
          </div>
          <div class="form-group">
            <label for="fecha_publicacion">Fecha de Publicación:</label>
            <input type="date" id="fecha_publicacion" name="fecha_publicacion" required>
          </div>
          <div class="form-group">
            <label for="img">URL de la Imagen:</label>
            <input type="text" id="img" name="img" required>
          </div>
          <div class="form-group" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px;">
            <input type="submit" name="submit_add" value="Añadir Libro">
            <input type="submit" name="submit_update" value="Actualizar Libro">
            <input type="submit" name="submit_delete" value="Eliminar Libro">
            <input type="reset" value="Limpiar">
          </div>
        </form>
        <div class="success-message"><?php echo $insert_success . $update_success . $delete_success; ?></div>
        <div class="error-message"><?php echo $insert_error . $update_error . $delete_error; ?></div>
      </div>
      <div class="table-container">
        <h2>Lista de Libros</h2>
        <input type="text" id="searchInput" onkeyup="searchBooks()" placeholder="Buscar libros por título...">
        <table id="booksTable">
          <thead>
            <tr>
              <th>ID</th>
              <th>Título</th>
              <th>Autor</th>
              <th>Género</th>
              <th>Enlace</th>
              <th>Fecha de Publicación</th>
              <th>Imagen</th>
            </tr>
          </thead>
          <tbody>
            <?php
            // Obtener la lista de libros desde la base de datos
            $sql_libros = "SELECT * FROM libros";
            $result_libros = $conn->query($sql_libros);
            while ($row = $result_libros->fetch_assoc()) {
              echo "<tr>";
              echo "<td>" . $row['id'] . "</td>";
              echo "<td>" . htmlspecialchars($row['titulo']) . "</td>";
              echo "<td>" . htmlspecialchars($row['autor']) . "</td>";
              echo "<td>" . htmlspecialchars($row['genero']) . "</td>";
              echo "<td><a href='" . htmlspecialchars($row['enlace']) . "' target='_blank'>Enlace</a></td>";
              echo "<td>" . date("d/m/Y", strtotime($row['fecha_publicacion'])) . "</td>";
              echo "<td><img src='" . htmlspecialchars($row['img']) . "' alt='" . htmlspecialchars($row['titulo']) . "' style='max-width: 100px;'></td>";
              echo "</tr>";
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <script>
    // Script JavaScript para manejar la selección de filas y búsqueda de libros
    document.addEventListener("DOMContentLoaded", function() {
      var rows = document.querySelectorAll("table tbody tr");
      rows.forEach(function(row) {
        row.addEventListener("click", function() {
          rows.forEach(function(row) {
            row.classList.remove("selected-row");
          });
          row.classList.add("selected-row");
          var id = row.cells[0].innerText;
          var titulo = row.cells[1].innerText;
          var autor = row.cells[2].innerText;
          var genero = row.cells[3].innerText;
          var enlace = row.cells[4].querySelector("a").getAttribute("href");
          var fecha_publicacion = row.cells[5].innerText;
          var formatted_date = fecha_publicacion.split('/').reverse().join('-');
          var img = row.cells[6].querySelector("img").getAttribute("src");
          document.getElementById("id").value = id;
          document.getElementById("titulo").value = titulo;
          document.getElementById("autor").value = autor;
          document.getElementById("genero").value = genero;
          document.getElementById("enlace").value = enlace;
          document.getElementById("fecha_publicacion").value = formatted_date;
          document.getElementById("img").value = img;
          document.getElementById("id").style.display = "block"; // Mostrar el campo de ID
        });
      });
    });

    function searchBooks() {
      var input, filter, table, tr, td, i, txtValue;
      input = document.getElementById("searchInput");
      filter = input.value.toUpperCase();
      table = document.getElementById("booksTable");
      tr = table.getElementsByTagName("tr");
      for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[1];
        if (td) {
          txtValue = td.textContent || td.innerText;
          if (txtValue.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
          } else {
            tr[i].style.display = "none";
          }
        }
      }
    }
  </script>
</body>

</html>

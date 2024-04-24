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

// Mensajes de éxito o error para la inserción, actualización y eliminación de usuarios
$insert_success = $insert_error = $update_success = $update_error = $delete_success = $delete_error = '';

// Manejar la inserción de un nuevo usuario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_add'])) {
    $nombre_usuario = $_POST['nombre_usuario'];
    $apellido_usuario = $_POST['apellido_usuario'];
    $email_usuario = $_POST['email_usuario'];
    $password_usuario = $_POST['password_usuario'];

    // Validar datos
    if (!empty($nombre_usuario) && !empty($apellido_usuario) && !empty($email_usuario) && !empty($password_usuario)) {
        $sql_insert = "INSERT INTO usuarios (nombre, apellido, email, password) VALUES (?, ?, ?, ?)";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param("ssss", $nombre_usuario, $apellido_usuario, $email_usuario, $password_usuario);

        if ($stmt_insert->execute()) {
            $insert_success = "Usuario añadido correctamente.";
        } else {
            $insert_error = "Error al añadir el usuario: " . $conn->error;
        }
    } else {
        $insert_error = "Por favor, complete todos los campos.";
    }
}

// Manejar la eliminación de un usuario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_delete'])) {
    $id = $_POST['id'];

    $sql_delete = "DELETE FROM usuarios WHERE id = ?";
    $stmt_delete = $conn->prepare($sql_delete);
    $stmt_delete->bind_param("i", $id);

    if ($stmt_delete->execute()) {
        $delete_success = "Usuario eliminado correctamente.";
    } else {
        $delete_error = "Error al eliminar el usuario: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración de Usuarios - Fakebook Library</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #343a40;
            color: #ffffff;
            padding: 10px;
            margin-bottom: 20px;
        }
        
        .logo {
            display: flex;
            align-items: center;
            font-weight: bold;
            font-size: 24px;
        }
        
        .logo img {
            height: 40px;
            margin-right: 10px;
        }
        
        .user-info {
            display: flex;
            align-items: center;
        }
        
        .user-info span {
            margin-right: 15px;
        }
        
        .content {
            display: flex;
            justify-content: space-between;
        }
        
        .form-container {
            flex-basis: 40%;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
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
        .form-group input[type="email"],
        .form-group input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            box-sizing: border-box;
        }
        
        .form-group input[type="submit"] {
            background-color: #007bff;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        
        .form-group input[type="submit"]:hover {
            background-color: #0056b3;
        }
        
        .form-group input[type="reset"] {
            background-color: #6c757d;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-left: 10px;
        }
        
        .form-group input[type="reset"]:hover {
            background-color: #5a6268;
        }
        
        .success-message,
        .error-message {
            margin-top: 20px;
            padding: 10px;
            border-radius: 5px;
        }
        
        .success-message {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .user-list-container {
            flex-basis: 55%;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        .user-list-container h2 {
            margin-bottom: 20px;
        }
        
        .user-list {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }
        
        .user-list li {
            margin-bottom: 10px;
            padding: 10px;
            background-color: #f0f0f0;
            border-radius: 5px;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        .user-list li:last-child {
            margin-bottom: 0;
        }
        
        .user-list li .user-info {
            display: flex;
            justify-content: space-between;
        }
        
        .user-list li .user-info .user-actions {
            display: flex;
        }
        
        .user-list li .user-info .user-actions button {
            margin-left: 10px;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        
        .user-list li .user-info .user-actions button.delete-button {
            background-color: #dc3545;
            color: #ffffff;
        }
        
        .user-list li .user-info .user-actions button.delete-button:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Encabezado -->
        <div class="header">
            <div class="logo">
                <img src="logo.png" alt="Fakebook Library Logo">
                <span>Fakebook Library</span>
            </div>
            <div class="user-info">
                <span><?php echo $nombre . " " . $apellido; ?></span>
                <span><?php echo $correo; ?></span>
                <a href="logout.php">Cerrar sesión</a>
            </div>
        </div>

        <!-- Contenido principal -->
        <div class="content">
            <!-- Formulario para añadir usuario -->
            <div class="form-container">
                <h2>Agregar Usuario</h2>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="form-group">
                        <label for="nombre_usuario">Nombre:</label>
                        <input type="text" id="nombre_usuario" name="nombre_usuario">
                    </div>
                    <div class="form-group">
                        <label for="apellido_usuario">Apellido:</label>
                        <input type="text" id="apellido_usuario" name="apellido_usuario">
                    </div>
                    <div class="form-group">
                        <label for="email_usuario">Correo electrónico:</label>
                        <input type="email" id="email_usuario" name="email_usuario">
                    </div>
                    <div class="form-group">
                        <label for="password_usuario">Contraseña:</label>
                        <input type="password" id="password_usuario" name="password_usuario">
                    </div>
                    <div class="form-group">
                        <input type="submit" name="submit_add" value="Agregar">
                        <input type="reset" value="Limpiar">
                    </div>
                </form>
                <?php if ($insert_success != ''): ?>
                    <div class="success-message"><?php echo $insert_success; ?></div>
                <?php endif;?>
                <?php if ($insert_error != ''): ?>
                    <div class="error-message"><?php echo $insert_error; ?></div>
                <?php endif;?>
            </div>

            <!-- Lista de usuarios existentes -->
            <div class="user-list-container">
                <h2>Usuarios Registrados</h2>
                <ul class="user-list">
                    <?php
                    // Consultar usuarios registrados
                    $sql_users = "SELECT id, nombre, apellido, email FROM usuarios";
                    $result_users = $conn->query($sql_users);

                    if ($result_users->num_rows > 0) {
                        // Mostrar usuarios en una lista
                        while ($row_users = $result_users->fetch_assoc()) {
                            echo '<li>';
                            echo '<div class="user-info">';
                            echo '<span>' . htmlspecialchars($row_users["nombre"]) . ' ' . htmlspecialchars($row_users["apellido"]) . '</span>';
                            echo '<span>' . htmlspecialchars($row_users["email"]) . '</span>';
                            echo '<div class="user-actions">';
                            echo '<form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">';
                            echo '<input type="hidden" name="id" value="' . $row_users["id"] . '">';
                            echo '<button type="submit" name="submit_delete" class="delete-button">Eliminar</button>';
                            echo '</form>';
                            echo '</div>';
                            echo '</div>';
                            echo '</li>';
                        }
                    } else {
                        echo '<li>No hay usuarios registrados.</li>';
                    }
                    ?>
                </ul>
                <?php if ($delete_success != ''): ?>
                    <div class="success-message"><?php echo $delete_success; ?></div>
                <?php endif;?>
                <?php if ($delete_error != ''): ?>
                    <div class="error-message"><?php echo $delete_error; ?></div>
                <?php endif;?>
            </div>
        </div>
    </div>
</body>
</html>

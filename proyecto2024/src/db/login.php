<?php
header('Content-Type: application/json');

$dbHost = '127.0.0.1';
$dbUser = 'root';
$dbPass = '123';
$dbName = 'proyecto2024';

$connection = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

if ($connection->connect_error) {
    die(json_encode(array('error' => 'Connection failed: ' . $connection->connect_error)));
}

$data = json_decode(file_get_contents('php://input'), true);

$noControl = $data['noControl'];
$password = $data['password'];

$sql = "SELECT * FROM alumnos WHERE noControl='$noControl' AND password='$password'";
$result = $connection->query($sql);

if ($result->num_rows > 0) {
    echo json_encode(array('message' => 'Inicio de sesión exitoso'));
} else {
    echo json_encode(array('error' => 'Credenciales inválidas'));
}

$connection->close();
?>

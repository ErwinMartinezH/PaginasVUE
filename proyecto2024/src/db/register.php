<?php
$dbHost = '127.0.0.1';
$dbUser = 'root';
$dbPass = '123';
$dbName = 'proyecto2024';

$connection = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$noControl = $_POST['noControl'];
$nombre = $_POST['nombre'];
// Otros campos necesarios

$sql = "INSERT INTO alumnos (noControl, nombre) VALUES ('$noControl', '$nombre')";
if ($connection->query($sql) === TRUE) {
    echo "Alumno registrado exitosamente";
} else {
    echo "Error: " . $sql . "<br>" . $connection->error;
}

$connection->close();
?>

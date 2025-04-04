<?php
// Configuración de la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dwp";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener datos del formulario
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$message = $_POST['message'];

// Preparar y ejecutar consulta SQL
$sql = "INSERT INTO contactos (nombre, email, telefono, mensaje, fecha) 
        VALUES ('$name', '$email', '$phone', '$message', NOW())";

if ($conn->query($sql) === TRUE) {
    echo "Mensaje enviado con éxito";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

// Redireccionar de vuelta al formulario
header("Location: index.html#contacto");
?>
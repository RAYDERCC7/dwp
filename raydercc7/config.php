<?php
$host = "localhost";
$user = "root"; // Tu usuario de MySQL
$pass = ""; // Tu contraseña de MySQL
$dbname = "dwp";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>

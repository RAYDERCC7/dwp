<?php
session_start();
require 'config.php'; // Archivo con la conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    // Buscar el usuario en la base de datos
    $stmt = $conn->prepare("SELECT id, nombre, contraseña FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // El usuario existe, obtenemos los datos
        $stmt->bind_result($id, $nombre, $hashedPassword);
        $stmt->fetch();

        // Verificar la contraseña
        if (password_verify($password, $hashedPassword)) {
            // Iniciar sesión
            $_SESSION["user_id"] = $id;
            $_SESSION["user_name"] = $nombre;

            echo json_encode(["status" => "success", "message" => "Inicio de sesión exitoso."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Contraseña incorrecta."]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "El correo no está registrado."]);
    }

    $stmt->close();
    $conn->close();
}
?>

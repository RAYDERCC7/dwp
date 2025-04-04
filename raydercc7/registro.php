<?php
session_start();
require 'config.php'; // Archivo con la conexión a la BD

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar las variables del formulario
    $nombre = trim($_POST["fullname"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $confirmPassword = trim($_POST["confirmPassword"]);
    $recaptchaResponse = $_POST['g-recaptcha-response']; // Respuesta de reCAPTCHA

    // Verificar si las contraseñas coinciden
    if ($password !== $confirmPassword) {
        echo json_encode(["status" => "error", "message" => "Las contraseñas no coinciden."]);
        exit;
    }

    // Verificar reCAPTCHA
    $secretKey = "6LfCrQkrAAAAAPXAZRY5ZGXvmnhbDu5FUo_veuG3"; // Reemplaza con tu clave secreta
    $verifyUrl = "https://www.google.com/recaptcha/api/siteverify";
    $response = file_get_contents($verifyUrl . "?secret=" . $secretKey . "&response=" . $recaptchaResponse);
    $responseKeys = json_decode($response);

    if ($responseKeys->success !== true) {
        echo json_encode(["status" => "error", "message" => "Por favor, completa el reCAPTCHA."]);
        exit;
    }

    // Hashear la contraseña
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Verificar si el email ya existe
    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo json_encode(["status" => "error", "message" => "El correo ya está registrado."]);
        exit;
    }

    // Insertar usuario
    $stmt = $conn->prepare("INSERT INTO usuarios (nombre, email, contraseña) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nombre, $email, $hashedPassword);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Registro exitoso."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error al registrar."]);
    }

    $stmt->close();
    $conn->close();
}
?>

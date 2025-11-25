<?php
session_start();

// Conexión
$conn = new mysqli("localhost", "root", "", "caja_fuerte");
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirm = $_POST['confirm'];

if ($password !== $confirm) {
    echo "<p>Las contraseñas no coinciden.</p>";
    echo "<a href='login.html'>Volver</a>";
    exit();
}

$hash = hash('sha256', $password);

// Insertar usuario nuevo
$sql = "INSERT INTO usuarios (email, password) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $email, $hash);

if ($stmt->execute()) {
    $_SESSION['usuarios'] = $email;
    header("Location: formulario.html");
    exit();
} else {
    echo "<p>Ese correo ya está registrado.</p>";
    echo "<a href='login.html'>Volver</a>";
}
?>

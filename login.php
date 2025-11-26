<?php
session_start();

// Conexión
$conn = new mysqli("localhost", "root", "", "caja_fuerte");
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$email = $_POST['email'];
$password = $_POST['password'];
$hash = hash('sha256', $password);

// Consulta para validar usuario
$sql = "SELECT * FROM usuarios WHERE email = ? AND password = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $email, $hash);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $_SESSION['usuarios'] = $email;
    header("Location: INICIO.html");
    exit();
} else {
    echo "<p>Correo o contraseña incorrectos</p>";
    echo "<a href='login.html'>Volver</a>";
}
?>

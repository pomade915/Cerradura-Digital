<?php
$conn = new mysqli("localhost", "root", "", "caja-fuerte");

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$nombre = $_POST['nombre'];
$email = $_POST['email'];
$direccion = $_POST['direccion'];
$metodo = $_POST['metodo_pago'];
$cantidad = $_POST['cantidad'];

$sql = "INSERT INTO compras (nombre, email, direccion, metodo_pago, cantidad) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssi", $nombre, $email, $direccion, $metodo, $cantidad);

if ($stmt->execute()) {
    // Redirige a la página de éxito
    header("Location: compra_exitosa.html");
    exit();
} else {
    echo "❌ Error al guardar el pedido: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>

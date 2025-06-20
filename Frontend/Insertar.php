<?php
include 'conexion.php';

$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$contraseña = $_POST['contraseña'];
$correo = $_POST['correo'];

$stmt = $conn->prepare("INSERT INTO cliente (nombre, apellido, contraseña, correo) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $nombre, $apellido, $contraseña, $correo);

if ($stmt->execute()) {
    echo "Datos guardados correctamente.";
} else {
    echo "Error al guardar: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>

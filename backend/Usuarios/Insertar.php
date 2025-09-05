<?php
include 'conexion.php';
//include("../conexion.php");

$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$contraseña = $_POST['contraseña'];
$correo = $_POST['correo'];

$stmt = $conn->prepare("INSERT INTO cliente (nombre, apellido, contraseña, correo) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $nombre, $apellido, $contraseña, $correo);

if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ' -]+$/u", $nombre) || empty($nombre)) { // Validar que el nombre solo contenga letras y espacios
    echo "Nombre inválido. Serás redirigido en 5 segundos...";
    header("Refresh: 5; URL=../Frontend/crear_cuenta.html");
    exit;
}

if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ' -]+$/u", $apellido) || empty($apellido)) { // Validar que el apellido solo contenga letras y espacios
    echo "Apellido inválido. Serás redirigido en 5 segundos...";
    header("Refresh: 5; URL=../Frontend/crear_cuenta.html");
    exit;
}

if (!filter_var($correo, FILTER_VALIDATE_EMAIL) || empty($correo)) { // Validar formato de correo electrónico
    echo "Correo inválido. Serás redirigido en 5 segundos...";
    header("Refresh: 5; URL=../Frontend/crear_cuenta.html");
    exit;
}

if (strlen($contraseña) < 8 || empty($contraseña)) { // Validar que la contraseña tenga al menos 6 caracteres
    echo "Contraseña inválida. Debe tener al menos 8 caracteres. Serás redirigido en 5 segundos...";
    header("Refresh: 5; URL=../Frontend/crear_cuenta.html");
    exit;
}

if ($stmt->execute()) {
    echo "Datos guardados correctamente.";
} else {
    echo "Error al guardar: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>

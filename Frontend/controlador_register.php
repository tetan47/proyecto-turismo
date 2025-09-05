<?php
include 'Conexion.php';
include("conexion.php");

$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$contraseña =md5($_POST['contraseña']);
$correo =$_POST['correo'];

if (!empty($_POST["nombre"]) or empty($_POST["apellido"]) or empty($_POST["correo"]) or empty($_POST["contraseña"])) {
        echo '<div class="alert ">Uno de los campos esta vacío </div>';
    }

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

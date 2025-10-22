<?php
include __DIR__ . '/../Conexion.php';

// Verificar que se recibieron datos por POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../../Frontend/register.php");
    exit;
}

$nombre = trim($_POST['nombre']);
$apellido = trim($_POST['apellido']);
$contraseña = trim($_POST['contraseña']);
$correo = trim($_POST['correo']);

// ========== VALIDACIONES ==========

if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ' -]+$/u", $nombre) || empty($nombre)) {
    echo '<div class="alert alert-danger">Nombre inválido. Serás redirigido en 5 segundos...</div>';
    header("Refresh: 5; URL=../../Frontend/register.php");
    exit;
}

if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ' -]+$/u", $apellido) || empty($apellido)) {
    echo '<div class="alert alert-danger">Apellido inválido. Serás redirigido en 5 segundos...</div>';
    header("Refresh: 5; URL=../../Frontend/register.php");
    exit;
}

if (!filter_var($correo, FILTER_VALIDATE_EMAIL) || empty($correo)) {
    echo '<div class="alert alert-danger">Correo inválido. Serás redirigido en 5 segundos...</div>';
    header("Refresh: 5; URL=../../Frontend/register.php");
    exit;
}

if (strlen($contraseña) < 8 || empty($contraseña)) {
    echo '<div class="alert alert-danger">Contraseña inválida. Debe tener al menos 8 caracteres. Serás redirigido en 5 segundos...</div>';
    header("Refresh: 5; URL=../../Frontend/register.php");
    exit;
}

// Verificar si el correo ya existe
$check = $conn->prepare("SELECT ID_Cliente FROM cliente WHERE Correo = ?");
$check->bind_param("s", $correo);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    $check->close();
    echo '<div class="alert alert-danger">Este correo ya está registrado. <a href="../../Frontend/register.php">Volver</a></div>';
    exit;
}
$check->close();

// ========== INSERTAR USUARIO ==========

// Hashear contraseña
//$hashed_password = password_hash($contraseña, PASSWORD_BCRYPT);

$stmt = $conn->prepare("INSERT INTO cliente (Nombre, Apellido, Contraseña, Correo, bloquear) VALUES (?, ?, ?, ?, 0)");
$stmt->bind_param("ssss", $nombre, $apellido, /*$hashed_password*/ $contraseña, $correo);

if ($stmt->execute()) {
    // Obtener el ID del nuevo usuario
    $nuevo_id = $conn->insert_id;
    
    // Iniciar sesión automáticamente
    session_start();
    $_SESSION['ID_Cliente'] = $nuevo_id;
    $_SESSION['correo'] = $correo;
    $_SESSION['nombre_usuario'] = $nombre;
    $_SESSION['logueado'] = true;

    $stmt->close();
    $conn->close();
    
    // Redirigir al index
    header("Location: ../../Frontend/index.php");
    exit;
} else {
    echo '<div class="alert alert-danger">Error al guardar: ' . htmlspecialchars($stmt->error) . '</div>';
}

$stmt->close();
$conn->close();
?>
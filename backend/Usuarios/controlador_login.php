<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../../Frontend/login.php');
    exit;
}

require_once __DIR__ . '/../conexion.php';

$correo = filter_input(INPUT_POST, 'correo', FILTER_VALIDATE_EMAIL);
$contraseña = $_POST['contraseña'] ?? '';

if (!$correo || !$contraseña) {
    $_SESSION['error_login'] = 'Correo o contraseña inválidos.';
    header('Location: ../../Frontend/login.php');
    exit;
}

try {
    $sql = "SELECT id, nombre, correo, contraseña, role FROM usuarios WHERE correo = :correo LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':correo' => $correo]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user || !password_verify($contraseña, $user['contraseña'])) {
        $_SESSION['error_login'] = 'Credenciales incorrectas.';
        header('Location: ../../Frontend/login.php');
        exit;
    }

    // Permitir acceso sólo si role = 'admin'
    if (!isset($user['role']) || $user['role'] !== 'admin') {
        $_SESSION['error_login'] = 'Acceso denegado: se requieren permisos de administrador.';
        header('Location: ../../Frontend/login.php');
        exit;
    }

    // Login exitoso (admin)
    $_SESSION['logueado'] = true;
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_nombre'] = $user['nombre'];
    $_SESSION['role'] = $user['role'];

    header('Location: ../../Frontend/index.php');
    exit;

} catch (Exception $e) {
    $_SESSION['error_login'] = 'Error interno. Intente más tarde.';
    header('Location: ../../Frontend/login.php');
    exit;
}
?>
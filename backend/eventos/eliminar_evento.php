<?php

if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../Conexion.php';

// comprobar permisos (administrador)
$isAdmin = false;
if (isset($_SESSION['correo'])) {
    $stmt = mysqli_prepare($conn, "SELECT ID_Administrador FROM administradores WHERE Correo = ?");
    mysqli_stmt_bind_param($stmt, 's', $_SESSION['correo']);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    $isAdmin = mysqli_stmt_num_rows($stmt) > 0;
    mysqli_stmt_close($stmt);
}
if (!$isAdmin) {
    header('Location: ../../Frontend/login.php');
    exit;
}

// Validar id
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: ../../Frontend/Panel_de_administracion.php');
    exit;
}
$id = (int) $_GET['id'];

// 1. Eliminar registros en tabla 'administra' que referencian este evento
$stmt1 = mysqli_prepare($conn, "DELETE FROM administra WHERE ID_Evento = ?");
mysqli_stmt_bind_param($stmt1, 'i', $id);
mysqli_stmt_execute($stmt1);
mysqli_stmt_close($stmt1);

// 2. Eliminar el evento
$stmt2 = mysqli_prepare($conn, "DELETE FROM eventos WHERE ID_Evento = ?");
mysqli_stmt_bind_param($stmt2, 'i', $id);
$ok = mysqli_stmt_execute($stmt2);
mysqli_stmt_close($stmt2);

mysqli_close($conn);

// redirigir de vuelta al panel
header('Location: ../../Frontend/Panel_de_administracion.php' . ($ok ? '?deleted=1' : '?deleted=0'));
exit;
?>
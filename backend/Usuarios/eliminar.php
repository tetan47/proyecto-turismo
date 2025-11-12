<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../Conexion.php';

// Verificar admin
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

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: ../../Frontend/Panel_de_administracion.php');
    exit;
}
$id = (int) $_GET['id'];

$ok = true;

// 1. Eliminar comentarios del usuario
$stmt1 = mysqli_prepare($conn, "DELETE FROM comentarios WHERE ID_Cliente = ?");
mysqli_stmt_bind_param($stmt1, 'i', $id);
if (!mysqli_stmt_execute($stmt1)) $ok = false;
mysqli_stmt_close($stmt1);

// 2. Eliminar registros en tabla administra
$stmt2 = mysqli_prepare($conn, "DELETE FROM administra WHERE ID_Cliente = ?");
mysqli_stmt_bind_param($stmt2, 'i', $id);
if (!mysqli_stmt_execute($stmt2)) $ok = false;
mysqli_stmt_close($stmt2);

// 3. Eliminar organizador si existe
$stmt3 = mysqli_prepare($conn, "DELETE FROM organizadores WHERE ID_Cliente = ?");
mysqli_stmt_bind_param($stmt3, 'i', $id);
if (!mysqli_stmt_execute($stmt3)) $ok = false;
mysqli_stmt_close($stmt3);

// 4. Finalmente, eliminar el usuario
$stmt4 = mysqli_prepare($conn, "DELETE FROM cliente WHERE ID_Cliente = ?");
mysqli_stmt_bind_param($stmt4, 'i', $id);
if (!mysqli_stmt_execute($stmt4)) $ok = false;
mysqli_stmt_close($stmt4);

mysqli_close($conn);

// Redirigir al panel
header('Location: ../../Frontend/Panel_de_administracion.php' . ($ok ? '?user_deleted=1' : '?user_deleted=0'));
exit;
?>
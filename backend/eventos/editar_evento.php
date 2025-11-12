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

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['ID_Evento'])) {
    header('Location: ../../Frontend/Panel_de_administracion.php');
    exit;
}

$id = (int) $_POST['ID_Evento'];
$titulo = trim($_POST['Titulo'] ?? '');
$descripcion = trim($_POST['Descripcion'] ?? '');
$fecha_inicio = trim($_POST['Fecha_Inicio'] ?? '');
$fecha_fin = trim($_POST['Fecha_Fin'] ?? '');
$hora = trim($_POST['Hora'] ?? '');
$ubicacion = trim($_POST['Ubicacion'] ?? '');
$capacidad = (int) ($_POST['Capacidad'] ?? 0);
$categoria = trim($_POST['categoria'] ?? '');
$imagen = trim($_POST['imagen'] ?? '');

// Actualizar evento
$sql = "UPDATE eventos SET Título = ?, Fecha_Inicio = ?, Fecha_Fin = ?, Ubicacion = ?, Descripción = ? WHERE ID_Evento = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'sssssi', $titulo, $fecha_inicio, $fecha_fin, $ubicacion, $descripcion, $id);
$ok = mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

mysqli_close($conn);
header('Location: ../../Frontend/Panel_de_administracion.php' . ($ok ? '?event_updated=1' : '?event_updated=0'));
exit;
?>
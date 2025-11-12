<?php
include('../conexion.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die('Método no permitido');
}

// Validar que el usuario esté logueado
if (!isset($_SESSION['ID_Cliente'])) {
    die('No autorizado');
}

$sitio_id = intval($_POST['sitio_id']);
$titulo = trim($_POST['titulo']);
$descripcion = trim($_POST['descripcion']);
$categoria = trim($_POST['categoria']);
$ubicacion = trim($_POST['ubicacion']);
$estado = trim($_POST['estado']);
$telefono = trim($_POST['telefono']);
$hora_inicio = $_POST['hora_inicio'];
$hora_fin = $_POST['hora_fin'];

// Validaciones básicas
if (empty($titulo) || empty($categoria) || empty($estado)) {
    die('Todos los campos obligatorios deben ser completados');
}

// Procesar imagen si se subió una nueva
$imagen_path = null;
if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
    $file = $_FILES['imagen'];
    
    // Validar tipo de archivo
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    if (!in_array($file['type'], $allowed_types)) {
        die('Tipo de archivo no permitido');
    }
    
    // Validar tamaño (5MB máximo)
    if ($file['size'] > 5000000) {
        die('La imagen es demasiado grande (máx. 5MB)');
    }
    
    // Crear directorio si no existe
    $upload_dir = '../portadas-sitios/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }
    
    // Generar nombre único
    $file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = 'sitio_' . time() . '_' . uniqid() . '.' . $file_extension;
    $imagen_path = $upload_dir . $filename;
    
    // Mover archivo
    if (!move_uploaded_file($file['tmp_name'], $imagen_path)) {
        die('Error al subir la imagen');
    }
    
    // Preparar path para la base de datos (relativo)
    $imagen_path = '/portadas-sitios/' . $filename;
}

// Construir consulta UPDATE
if ($imagen_path) {
    $sql = "UPDATE sitioturistico SET 
            Titulo = ?, 
            Descripcion = ?, 
            Categoria = ?, 
            Ubicacion = ?, 
            Estado = ?, 
            telefono = ?, 
            Hora_Inicio = ?, 
            Hora_Fin = ?, 
            Imagen = ? 
            WHERE ID_Sitio = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssssi", $titulo, $descripcion, $categoria, $ubicacion, $estado, $telefono, $hora_inicio, $hora_fin, $imagen_path, $sitio_id);
} else {
    $sql = "UPDATE sitioturistico SET 
            Titulo = ?, 
            Descripcion = ?, 
            Categoria = ?, 
            Ubicacion = ?, 
            Estado = ?, 
            telefono = ?, 
            Hora_Inicio = ?, 
            Hora_Fin = ? 
            WHERE ID_Sitio = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssi", $titulo, $descripcion, $categoria, $ubicacion, $estado, $telefono, $hora_inicio, $hora_fin, $sitio_id);
}

if ($stmt->execute()) {
    echo "<script>alert('Sitio turístico actualizado correctamente'); window.location.href = '../../Frontend/gestion-sitios.php';</script>";
} else {
    echo "<script>alert('Error al actualizar el sitio: " . $conn->error . "'); window.history.back();</script>";
}

$stmt->close();
$conn->close();
?>
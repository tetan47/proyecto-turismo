<?php
session_start();
include('../Conexion.php');

// Validar sesión
if (!isset($_SESSION['ID_Cliente'])) {
    header('Location: ../../Frontend/login.php');
    exit();
}

// Función esAdmin
function esAdmin($conn) {
    if (!isset($_SESSION['ID_Cliente']) || !isset($_SESSION['correo'])) {
        return false;
    }
    
    $stmt = $conn->prepare("SELECT ID_Administrador FROM administradores WHERE Correo = ?");
    $stmt->bind_param('s', $_SESSION['correo']);
    $stmt->execute();
    $result = $stmt->get_result()->num_rows > 0;
    $stmt->close();
    return $result;
}

// Obtener datos del formulario
$evento_id = intval($_POST['evento_id']);
$titulo = trim($_POST['titulo']);
$descripcion = trim($_POST['descripcion']);
$categoria = trim($_POST['categoria']);
$ubicacion = trim($_POST['ubicacion']);
$fecha_inicio = $_POST['fecha_inicio'];
$fecha_fin = $_POST['fecha_fin'];
$hora = $_POST['hora_evento'];
$capacidad = intval($_POST['capacidad']);

// Validar campos obligatorios
if (empty($titulo) || empty($categoria)) {
    header('Location: ../../Frontend/EditarEvento.php?id=' . $evento_id . '&error=campos_vacios');
    exit();
}

// Procesar imagen (si la hay)
$imagen_sql = '';
if (!empty($_FILES['imagen']['name'])) {
    $archivo_tmp = $_FILES['imagen']['tmp_name'];
    $nombre_unico = uniqid() . '_' . $_FILES['imagen']['name'];
    $ruta = '../../Frontend/Images/' . $nombre_unico;

    if (move_uploaded_file($archivo_tmp, $ruta)) {
        $imagen_sql = "Images/$nombre_unico";
    }
}

// Actualizar evento
if (!empty($imagen_sql)) {
    $sql = "UPDATE eventos SET Título=?, Descripción=?, categoria=?, Ubicacion=?, Fecha_Inicio=?, Fecha_Fin=?, Hora=?, Capacidad=?, imagen=? WHERE ID_Evento=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sssssssssi', $titulo, $descripcion, $categoria, $ubicacion, $fecha_inicio, $fecha_fin, $hora, $capacidad, $imagen_sql, $evento_id);
} else {
    $sql = "UPDATE eventos SET Título=?, Descripción=?, categoria=?, Ubicacion=?, Fecha_Inicio=?, Fecha_Fin=?, Hora=?, Capacidad=? WHERE ID_Evento=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssssssssi', $titulo, $descripcion, $categoria, $ubicacion, $fecha_inicio, $fecha_fin, $hora, $capacidad, $evento_id);
}

if ($stmt && $stmt->execute()) {
    $stmt->close();
    
    // Verificar si es admin
    $esAdminUser = esAdmin($conn);
    
    if ($esAdminUser) {
        header('Location: ../../Frontend/Catálogo.php');
    } else {
        header('Location: ../../Frontend/mis-eventos.php');
    }
    
    $conn->close();
    exit();
} else {
    if ($stmt) {
        $stmt->close();
    }
    $conn->close();
    header('Location: ../../Frontend/EditarEvento.php?id=' . $evento_id . '&error=fallo');
    exit();
}
?>
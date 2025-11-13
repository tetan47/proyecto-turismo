<?php
include('../Conexion.php');
session_start();

header('Content-Type: application/json');
$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $texto = trim($_POST['texto']);
    $usuario = $_SESSION['ID_Cliente'] ?? 0;

    if ($usuario) {
        $sql = "UPDATE respondercomentario SET respuesta=? WHERE comentario_responder=? AND ID_Cliente=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sii", $texto, $id, $usuario);
        
        if ($stmt->execute()) {
            $response['success'] = true;
            $response['message'] = 'Respuesta actualizada correctamente';
            $response['nuevoTexto'] = htmlspecialchars($texto);
        } else {
            $response['message'] = 'Error al actualizar la respuesta';
        }
        $stmt->close();
    } else {
        $response['message'] = 'Usuario no autenticado';
    }
} else {
    $response['message'] = 'Método no permitido';
}

echo json_encode($response);
exit;
?><?php
include('../Conexion.php');
session_start();

header('Content-Type: application/json');
$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $texto = trim($_POST['texto']);
    $usuario = $_SESSION['ID_Cliente'] ?? 0;

    if (!$usuario) {
        $response['message'] = 'Usuario no autenticado';
        echo json_encode($response);
        exit;
    }

    // Verificar si el usuario es administrador
    $esAdmin = false;
    $sql_admin = "SELECT ID_Administrador FROM administradores WHERE Correo = (SELECT Correo FROM cliente WHERE ID_Cliente = ?)";
    $stmt_admin = $conn->prepare($sql_admin);
    $stmt_admin->bind_param("i", $usuario);
    $stmt_admin->execute();
    $result_admin = $stmt_admin->get_result();
    $esAdmin = ($result_admin->num_rows > 0);
    $stmt_admin->close();

    if ($esAdmin) {
        // El administrador puede editar cualquier respuesta
        $sql = "UPDATE respondercomentario SET respuesta=? WHERE comentario_responder=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $texto, $id);
    } else {
        // Usuario normal solo puede editar sus propias respuestas
        $sql = "UPDATE respondercomentario SET respuesta=? WHERE comentario_responder=? AND ID_Cliente=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sii", $texto, $id, $usuario);
    }
    
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            $response['success'] = true;
            $response['message'] = 'Respuesta actualizada correctamente';
            $response['nuevoTexto'] = htmlspecialchars($texto);
        } else {
            $response['message'] = 'No tienes permisos para editar esta respuesta o no existe';
        }
    } else {
        $response['message'] = 'Error al actualizar la respuesta';
    }
    $stmt->close();
} else {
    $response['message'] = 'Método no permitido';
}

echo json_encode($response);
exit;
?>
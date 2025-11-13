<?php
include('../Conexion.php');
session_start();

header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
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
        // El administrador puede eliminar cualquier comentario
        $sql = "DELETE FROM comentarios WHERE ID_Comentario = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
    } else {
        // Usuario normal solo puede eliminar sus propios comentarios
        $sql = "DELETE FROM comentarios WHERE ID_Comentario = ? AND ID_Cliente = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $id, $usuario);
    }

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            $response['success'] = true;
            $response['message'] = 'Comentario eliminado correctamente (respuestas también eliminadas)';
        } else {
            $response['message'] = 'No tienes permisos para eliminar este comentario o no existe';
        }
    } else {
        $response['message'] = 'Error al eliminar el comentario';
    }

    $stmt->close();
} else {
    $response['message'] = 'Método no permitido';
}

echo json_encode($response);
exit;
?>
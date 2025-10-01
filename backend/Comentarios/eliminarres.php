<?php
include('../Conexion.php');
session_start();

header('Content-Type: application/json');
$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $usuario = $_SESSION['ID_Cliente'] ?? 0;

    if ($usuario) {
        $sql = "DELETE FROM respondercomentario WHERE comentario_responder=? AND ID_Cliente=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $id, $usuario);
        
        if ($stmt->execute()) {
            $response['success'] = true;
            $response['message'] = 'Respuesta eliminada correctamente';
        } else {
            $response['message'] = 'Error al eliminar la respuesta';
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
?>
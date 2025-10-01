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
        $sql = "UPDATE comentarios SET Texto=? WHERE ID_Comentario=? AND ID_Cliente=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sii", $texto, $id, $usuario);
        
        if ($stmt->execute()) {
            $response['success'] = true;
            $response['message'] = 'Comentario actualizado correctamente';
            $response['nuevoTexto'] = htmlspecialchars($texto);
        } else {
            $response['message'] = 'Error al actualizar el comentario';
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
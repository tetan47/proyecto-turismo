<?php
include('../Conexion.php');
session_start();

header('Content-Type: application/json');
$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_comentario = intval($_POST['id_comentario']);
    $texto = trim($_POST['texto']);
    $usuario = $_SESSION['ID_Cliente'] ?? 0;

    if (!$usuario) {
        $response['message'] = 'Usuario no autenticado';
        echo json_encode($response);
        exit;
    }

    if (empty($texto)) {
        $response['message'] = 'La respuesta no puede estar vacía';
        echo json_encode($response);
        exit;
    }

    $sql = "INSERT INTO respondercomentario (ID_Comentario, ID_Cliente, respuesta) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iis", $id_comentario, $usuario, $texto);
    
    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = 'Respuesta enviada correctamente';
    } else {
        $response['message'] = 'Error al enviar la respuesta';
    }
    $stmt->close();
} else {
    $response['message'] = 'Método no permitido';
}

echo json_encode($response);
exit;
?>
<?php
session_start();
include('../backend/Conexion.php'); // Asegúrate de usar la misma conexión

header('Content-Type: application/json'); // Mejor usar JSON para respuestas

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['ID_Cliente'])) {
        echo json_encode(['error' => 'Debes iniciar sesión para responder.']);
        exit;
    }

    $idComentario = isset($_POST['id_comentario']) ? intval($_POST['id_comentario']) : 0;
    $texto = trim($_POST['texto'] ?? '');

    if (empty($texto)) {
        echo json_encode(['error' => 'Por favor escribe una respuesta.']);
        exit;
    }

    if ($idComentario <= 0) {
        echo json_encode(['error' => 'Comentario no válido.']);
        exit;
    }

    $idUsuario = $_SESSION['ID_Cliente'];

    // Insertar respuesta usando consultas preparadas
    $sql = "INSERT INTO respondercomentarios (ID_Comentario, ID_Cliente, Texto) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('iis', $idComentario, $idUsuario, $texto);

    if ($stmt->execute()) {
        echo json_encode(['success' => 'Respuesta enviada correctamente.']);
    } else {
        echo json_encode(['error' => 'Error al guardar la respuesta.']);
    }
    
    $stmt->close();
} else {
    echo json_encode(['error' => 'Método no permitido.']);
}

$conn->close();
?>
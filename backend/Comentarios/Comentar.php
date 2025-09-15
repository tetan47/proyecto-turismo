<?php
session_start();
include('../backend/Conexion.php'); // Asegúrate de usar la misma conexión

header('Content-Type: application/json'); // Mejor usar JSON para respuestas

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['ID_Cliente'])) {
        echo json_encode(['error' => 'Debes iniciar sesión para comentar.']);
        exit;
    }

    $idUsuario = $_SESSION['ID_Cliente'];
    $id_evento = isset($_GET['id_evento']) ? intval($_GET['id_evento']) : 0;
    $texto = trim($_POST['Texto'] ?? '');

    if (empty($texto)) {
        echo json_encode(['error' => 'Por favor escribe un comentario.']);
        exit;
    }

    if ($id_evento <= 0) {
        echo json_encode(['error' => 'Evento no válido.']);
        exit;
    }

    // Insertar comentario usando consultas preparadas
    $sql = "INSERT INTO Comentarios (Texto, ID_Cliente, ID_Evento) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sii', $texto, $idUsuario, $id_evento);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => 'Comentario enviado correctamente.']);
    } else {
        echo json_encode(['error' => 'Error al guardar el comentario.']);
    }
    
    $stmt->close();
} else {
    echo json_encode(['error' => 'Método no permitido.']);
}

$conn->close();
?>
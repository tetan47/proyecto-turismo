<?php
session_start();
include('../Conexion.php');

header('Content-Type: application/json'); 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['ID_Cliente'])) {
        echo json_encode(['error' => 'Debes iniciar sesión para comentar.']);
        exit;
    }

    $idUsuario = $_SESSION['ID_Cliente'];
    $sitio_id = isset($_GET['sitio_id']) ? intval($_GET['sitio_id']) : 0;
    $texto = trim($_POST['Texto'] ?? '');

    if (empty($texto)) {
        echo json_encode(['error' => 'Por favor escribe un comentario.']);
        exit;
    }

    if ($sitio_id <= 0) {
        echo json_encode(['error' => 'Sitio inexistente.']);
        exit;
    }

    
    $sql = "INSERT INTO Comentarios (Texto, ID_Cliente, ID_Sitio) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sii', $texto, $idUsuario, $sitio_id);
    
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
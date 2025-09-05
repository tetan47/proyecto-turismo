<?php
session_start();
include('../backend/Conexion.php');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') exit;

// Solo verificamos sesión para el like, no para ver comentarios
$idComentario = intval($_POST['idComentario']);
$idUsuario = $_SESSION['ID_Cliente'] ?? 0;

if (!$idUsuario) {
    echo json_encode(['error' => 'Debes iniciar sesión para dar like.']);
    exit;
}

// Obtener usuarios_like y LIKES
$sql = "SELECT usuarios_like, LIKES FROM comentarios WHERE ID_Comentario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idComentario);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['error' => 'Comentario no encontrado']);
    exit;
}

$row = $result->fetch_assoc();
$usuarios_like = $row['usuarios_like'] ? explode(',', $row['usuarios_like']) : [];
$likes = (int)$row['LIKES'];

if (in_array($idUsuario, $usuarios_like)) {
    $usuarios_like = array_diff($usuarios_like, [$idUsuario]);
    $likes = max(0, $likes - 1);
    $liked = false;
} else {
    $usuarios_like[] = $idUsuario;
    $likes += 1;
    $liked = true;
}

$usuarios_like_str = implode(',', $usuarios_like);

// Actualizar tabla
$sqlUpdate = "UPDATE comentarios SET LIKES = ?, usuarios_like = ? WHERE ID_Comentario = ?";
$stmt2 = $conn->prepare($sqlUpdate);
$stmt2->bind_param("isi", $likes, $usuarios_like_str, $idComentario);
$stmt2->execute();

echo json_encode(['likes' => $likes, 'liked' => $liked]);
exit;
?>

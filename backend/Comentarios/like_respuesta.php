<?php 
session_start();
include('../Conexion.php');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') exit;

$idRespuesta = intval($_POST['idRespuesta']);
$idUsuario   = $_SESSION['ID_Cliente'] ?? 0;

if (!$idUsuario) {
    echo json_encode(['error'=>'Debes iniciar sesión para dar like.']);
    exit;
}

$sql = "SELECT LIKESRES, usuarios_like_res FROM respondercomentario WHERE comentario_responder = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idRespuesta);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();

$usuarios = $row['usuarios_like_res'] ? explode(',', $row['usuarios_like_res']) : [];
$likes    = (int)$row['LIKESRES'];

if (in_array($idUsuario, $usuarios)) {
    // quitar like
    $usuarios = array_diff($usuarios, [$idUsuario]);
    $likes    = max(0, $likes - 1);
    $liked    = false;
} else {
    $usuarios[] = $idUsuario;
    $likes++;
    $liked = true;
}

$usuarios_str = implode(',', $usuarios);

$up = $conn->prepare("UPDATE respondercomentario
                      SET LIKESRES=?, usuarios_like_res=?
                      WHERE comentario_responder=?");
$up->bind_param("isi", $likes, $usuarios_str, $idRespuesta);
$up->execute();

echo json_encode(['likes'=>$likes, 'liked'=>$liked]);
?>
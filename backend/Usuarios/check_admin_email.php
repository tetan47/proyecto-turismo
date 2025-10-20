<?php
header('Content-Type: application/json; charset=utf-8');

$input = json_decode(file_get_contents('php://input'), true);
$correo = isset($input['correo']) ? filter_var($input['correo'], FILTER_VALIDATE_EMAIL) : null;

if (!$correo) {
    echo json_encode(['error' => 'Correo inválido', 'is_admin' => false]);
    exit;
}

require_once __DIR__ . '/../conexion.php';

try {
    $sql = "SELECT role FROM usuarios WHERE correo = :correo LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':correo' => $correo]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    $isAdmin = ($user && isset($user['role']) && $user['role'] === 'admin');
    echo json_encode(['is_admin' => $isAdmin]);
    exit;
} catch (Exception $e) {
    echo json_encode(['error' => 'Error interno', 'is_admin' => false]);
    exit;
}
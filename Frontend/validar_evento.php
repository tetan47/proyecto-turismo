
<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    // Aquí procesas la validación o el descarte
    // Ejemplo: guardar en base de datos, enviar correo, etc.
    // $data['id'], $data['accion'], $data['razon']

    // Respuesta de ejemplo
    echo json_encode([
        'success' => true,
        'mensaje' => 'Evento procesado correctamente'
    ]);
    exit;
}

echo json_encode(['success' => false, 'mensaje' => 'Método no permitido']);
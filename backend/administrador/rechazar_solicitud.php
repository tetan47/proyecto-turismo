<?php
include('../Conexion.php');
header('Content-Type: application/json');


$cedula = $_POST['cedula'];

//la verificacion de que la solicitud no esté aprobada

$sqlCheck = "SELECT Aprobado FROM organizadores WHERE Cedula = ?";
$stmtCheck = $conn->prepare($sqlCheck);
$stmtCheck->bind_param('s', $cedula);
$stmtCheck->execute();
$resultCheck = $stmtCheck->get_result();

if ($resultCheck->num_rows === 0) {
    echo json_encode([
        'success' => false,
        'message' => 'Solicitud no encontrada'
    ]);
    $stmtCheck->close();
    $conn->close();
    exit();
}

$row = $resultCheck->fetch_assoc();
if ($row['Aprobado'] == 1) {
    echo json_encode([
        'success' => false,
        'message' => 'No se puede rechazar una solicitud ya aprobada'
    ]);
    $stmtCheck->close();
    $conn->close();
    exit();
}

$stmtCheck->close();


$sql = "DELETE FROM organizadores WHERE Cedula = ? AND Aprobado = 0";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo json_encode([
        'success' => false,
        'message' => 'Error al preparar la consulta: ' . $conn->error
    ]);
    $conn->close();
    exit();
}

$stmt->bind_param('s', $cedula);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode([
            'success' => true,
            'message' => 'Solicitud rechazada y eliminada correctamente'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'No se pudo rechazar la solicitud'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Error al ejecutar la consulta: ' . $stmt->error
    ]);
}

$stmt->close();
$conn->close();
?>
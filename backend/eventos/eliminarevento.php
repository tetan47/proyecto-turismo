<?php
include("../conexion.php");
session_start();

$ID_Evento = $_POST['id'];

mysqli_begin_transaction($conn);

try {
    $sql_comentarios = "DELETE FROM comentarios WHERE ID_Evento = ?";
    $stmt = $conn->prepare($sql_comentarios);
    $stmt->bind_param('i', $ID_Evento);
    $stmt->execute();
    $stmt->close();
    
    $sql_evento = "DELETE FROM eventos WHERE ID_Evento = ?";
    $stmt = $conn->prepare($sql_evento);
    $stmt->bind_param('i', $ID_Evento);
    
    if ($stmt->execute()) {
        mysqli_commit($conn);
        $stmt->close();
        header('Location: ../../Frontend/mis-eventos.php?success=eliminado');
        exit();
    } else {
        throw new Exception("Error al eliminar el evento: " . mysqli_error($conn));
    }
    
} catch (Exception $e) {
    mysqli_rollback($conn);
    echo "Error: " . $e->getMessage();
    echo '<script>setTimeout(() => window.history.back(), 3000);</script>';
}
?>
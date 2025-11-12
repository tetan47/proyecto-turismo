<?php
include("../conexion.php");

$ID_Evento = $_POST['id'];

// Iniciar transacción para asegurar consistencia
mysqli_begin_transaction($conn);

try {
    // 1. Primero eliminar los comentarios relacionados
    $sql_comentarios = "DELETE FROM comentarios WHERE ID_Evento = '$ID_Evento'";
    mysqli_query($conn, $sql_comentarios);
    
    // 2. La tabla 'administra' se elimina automáticamente por el CASCADE
    // 3. Finalmente eliminar el evento
    $sql_evento = "DELETE FROM eventos WHERE ID_Evento = '$ID_Evento'";
    
    if (mysqli_query($conn, $sql_evento)) {
        mysqli_commit($conn);
        echo "Evento eliminado correctamente.";
        echo '<script>window.history.back();</script>';
        exit();
    } else {
        throw new Exception("Error al eliminar el evento: " . mysqli_error($conn));
    }
    
} catch (Exception $e) {
    mysqli_rollback($conn);
    echo "Error: " . $e->getMessage();
}
?>
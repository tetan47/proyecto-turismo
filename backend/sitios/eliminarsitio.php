<?php
include("../conexion.php");

$ID_Sitio = $_POST['id'];

// Iniciar transacción para asegurar consistencia
mysqli_begin_transaction($conn);

try {
    // 1. Primero eliminar los comentarios relacionados
    $sql_comentarios = "DELETE FROM comentarios WHERE ID_Sitio = '$ID_Sitio'";
    mysqli_query($conn, $sql_comentarios);
    
    // 2. Finalmente eliminar el sitio
    $sql_sitio = "DELETE FROM sitioturistico WHERE ID_Sitio = '$ID_Sitio'";
    
    if (mysqli_query($conn, $sql_sitio)) {
        mysqli_commit($conn);
        echo "Sitio turístico eliminado correctamente.";
        echo '<script>window.history.back();</script>';
        exit();
    } else {
        throw new Exception("Error al eliminar el sitio: " . mysqli_error($conn));
    }
    
} catch (Exception $e) {
    mysqli_rollback($conn);
    echo "Error: " . $e->getMessage();
}
?>
<?php
include("../conexion.php");

$ID_Cliente = $_POST['id'];

// Eliminar relaciones primero
$sql_comentarios = "DELETE FROM comentarios WHERE ID_Cliente = '$ID_Cliente'";
mysqli_query($conn, $sql_comentarios);

$sql_respuestas = "DELETE FROM respondercomentario WHERE ID_Cliente = '$ID_Cliente'";
mysqli_query($conn, $sql_respuestas);

$sql_organizador = "DELETE FROM organizadores WHERE ID_Cliente = '$ID_Cliente'";
mysqli_query($conn, $sql_organizador);

// Eliminar usuario
$sql = "DELETE FROM cliente WHERE ID_Cliente = '$ID_Cliente'";
if (mysqli_query($conn, $sql)) {
    echo "Usuario eliminado correctamente.";
    echo '<script>window.history.back();</script>';
} else {
    echo "Error al eliminar el usuario: " . mysqli_error($conn);
    echo '<script>setTimeout(() => window.history.back(), 3000);</script>';
}
?>
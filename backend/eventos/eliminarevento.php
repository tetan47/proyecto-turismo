<?php
 
include("../conexion.php");

$ID_Evento = $_GET['ID_Evento'];
$sql = "DELETE FROM eventos WHERE ID_Evento = '$ID_Evento'";
if (mysqli_query($conn, $sql)) {
    echo "Evento eliminado correctamente.";
} else {
    echo "Error al eliminar el evento: " . mysqli_error($conn);
}
?>
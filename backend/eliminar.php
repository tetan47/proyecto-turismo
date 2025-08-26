<?php
include("../conexion.php");

$ID_Cliente = $_GET['ID_Cliente'];

$sql = "DELETE FROM clientes WHERE ID_Cliente = '$ID_Cliente'";
if (mysqli_query($conn, $sql)) {
    echo "Cliente eliminado correctamente.";
} else {
    echo "Error al eliminar el cliente: " . mysqli_error($conn);
}

?>

<a href="listar.php">Volver</a>
<?php
include("../conexion.php");

$ID_Administrador = $_GET['ID_Administrador'];

$sql = "DELETE FROM clientes WHERE ID_Administrador = '$ID_Administrador'";
if (mysqli_query($conn, $sql)) {
    echo "Administrador eliminado correctamente.";
} else {
    echo "Error al eliminar el administrador: " . mysqli_error($conn);
}

?>

<a href="listarADM.php">Volver</a>
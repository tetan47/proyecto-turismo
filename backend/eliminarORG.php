<?php
include("../conexion.php");

$Cedula = $_GET['Cédula'];

$sql = "DELETE FROM organizadores WHERE Cédula = '$cedula'";
if (mysqli_query($conn, $sql)) {
    echo "Organizador eliminado correctamente.";
} else {
    echo "Error al eliminar el Organizador: " . mysqli_error($conn);
}

?>

<a href="listarORG.php">Volver</a>
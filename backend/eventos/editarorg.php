<?php

$ID_Evento = $_GET['ID_Evento'];
$result = mysqli_query($conn, "SELECT * FROM eventos WHERE ID_Evento = '$ID_Evento'");
$evento = mysqli_fetch_assoc($result);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $Nombre_Evento = mysqli_real_escape_string($conn, $_POST['Nombre_Evento']);
    $Fecha_Evento = mysqli_real_escape_string($conn, $_POST['Fecha_Evento']);
    $Ubicacion = mysqli_real_escape_string($conn, $_POST['Ubicacion']);
    $Descripcion = mysqli_real_escape_string($conn, $_POST['Descripcion']);

    $sql = "UPDATE eventos SET Nombre_Evento='$Nombre_Evento', Fecha_Evento='$Fecha_Evento', Ubicacion='$Ubicacion', Descripcion='$Descripcion' WHERE ID_Evento='$ID_Evento'";
    
    if (mysqli_query($conn, $sql)) {
        echo "Evento actualizado correctamente.";
    } else {
        echo "Error al actualizar el evento: " . mysqli_error($conn);
    }
}


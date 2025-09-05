<?php
include("../conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $titulo = mysqli_real_escape_string($conn, $_POST['Título']);
    $descripcion = mysqli_real_escape_string($conn, $_POST['Descripción']);
    $fecha_inicio = mysqli_real_escape_string($conn, $_POST['Fecha-Inicio']);
    $fecha_fin = mysqli_real_escape_string($conn, $_POST['Fecha_Fin']);
    $ubicacion = mysqli_real_escape_string($conn, $_POST['Ubicacion']);
    $categoria = mysqli_real_escape_string($conn, $_POST['categoria']);
    $hora = mysqli_real_escape_string($conn, $_POST['Hora']);
    $imagen = mysqli_real_escape_string($conn, $_POST['imagen']);
    $cedula = mysqli_real_escape_string($conn, $_POST['Cédula']);


    if(!empty($titulo) && !empty($descripcion) && !empty($fecha_inicio) && !empty($fecha_fin) && !empty($ubicacion) && !empty($categoria) && !empty($hora) && !empty($imagen)) {
        //$sql = "INSERT INTO cliente (Título, Descripción, Fecha-Inicio, Fecha_Fin, Ubicacion, categoria, Hora, imagen) VALUES ('$titulo', '$descripcion', '$fecha_inicio', '$fecha_fin', '$ubicacion', '$categoria', '$hora', '$imagen')";
        
        if (mysqli_query($conn, $sql)) {
            echo "Evento creado con éxito, aguarde a ser verificado.";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "Por favor completa todos los campos.";
    }

}
?>

<form method="POST" action="">
    Nombre: <input type="text" name="Nombre" placeholder="Nombre" required><br>
    Apellido: <input type="text" name="Apellido" placeholder="Apellido" required><br>
    Contraseña: <input type="password" name="Contraseña" placeholder="Contraseña" required><br>
    Correo: <input type="email" name="Correo" placeholder="Correo" required><br>
    <input type="submit" placeholder="Registrarse">
</form>
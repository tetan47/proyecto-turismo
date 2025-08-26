<?php
include("../conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre = mysqli_real_escape_string($conn, $_POST['Nombre']);
    $apellido = mysqli_real_escape_string($conn, $_POST['Apellido']);
    $contraseña = mysqli_real_escape_string($conn, $_POST['Contraseña']);
    $correo = mysqli_real_escape_string($conn, $_POST['Correo']);

    if(!empty($nombre) && !empty($apellido) && !empty($contraseña) && !empty($correo)) {
        $sql = "INSERT INTO cliente (nombre, apellido, contraseña, correo) VALUES ('$nombre', '$apellido', '$contraseña', '$correo')";
        
        if (mysqli_query($conn, $sql)) {
            echo "Registrado con éxito";
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
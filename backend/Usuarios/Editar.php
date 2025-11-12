<?php

include ('../conexion.php');

$ID_Cliente = $_GET['ID_Cliente'];
$result = mysqli_query($conn, "SELECT * FROM clientes WHERE ID_Cliente = '$ID_Cliente'");
$usuario = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $Nombre = mysqli_real_escape_string($conn, $_POST['Nombre']);
    $Apellido = mysqli_real_escape_string($conn, $_POST['Apellido']);
    $Contraseña = mysqli_real_escape_string($conn, $_POST['Contraseña']);
    $Correo = mysqli_real_escape_string($conn, $_POST['Correo']);

    $sql = "UPDATE clientes SET Nombre='$Nombre', Apellido='$Apellido', Contraseña='$Contraseña', Correo='$Correo', WHERE ID_Cliente='$ID_Cliente'";
    
    if (mysqli_query($conn, $sql)) {
        echo "Cliente actualizado correctamente.";
    } else {
        echo "Error al actualizar el cliente: " . mysqli_error($conn);
    }
}

?>

<form method="POST">
    Nombre: <input type="text" name="Nombre" value="<?php echo $usuario['Nombre']; ?>"><br>
    Apellido: <input type="text" name="Apellido" value="<?php echo $usuario['Apellido']; ?>"><br>
    Contraseña: <input type="password" name="Contraseña" value="<?php echo $usuario['Contraseña']; ?>"><br>
    Correo: <input type="email" name="Correo" value="<?php echo $usuario['Correo']; ?>"><br>
    <button type="submit">Actualizar</button>
</form>
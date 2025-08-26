<?php

include ('../conexion.php');

$Cedula = $_GET['Cédula'];
$result = mysqli_query($conn, "SELECT * FROM organizadores WHERE Cédula = '$Cedula'");
$usuario = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $Nombre = myslqi_real_escape_string($conn, $_POST['Nombre']);
    $Apellido = mysqli_real_escape_string($conn, $_POST['Apellido']);
    $Contraseña = mysqli_real_escape_string($conn, $_POST['Contraseña']);
    $Correo = mysqli_real_escape_string($conn, $_POST['Correo']);
    $RUT = mysqli_real_escape_string($conn, $_POST['RUT']);
    $Telefono = mysqli_real_escape_string($conn, $_POST['Telefono']);
    $ID_Cliente = mysqli_real_escape_string($conn, $_POST['ID_Cliente']);


    $sql = "UPDATE organizadores SET Nombre='$Nombre', Apellido='$Apellido', Contraseña='$Contraseña', Correo='$Correo', Telefono='$Telefono', RUT='$RUT', ID_Cliente='$ID_Cliente' WHERE ID_Cliente='$ID_Cliente'";
    
    if (mysqli_query($conn, $sql)) {
        echo "Organizador actualizado correctamente.";
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
    RUT: <input type="text" name="RUT" value="<?php echo $usuario['RUT']; ?>"><br>
    Telefono: <input type="text" name="Telefono" value="<?php echo $usuario['Telefono']; ?>"><br>
    ID_Cliente: <input type="text" name="ID_Cliente" value="<?php echo $usuario['ID_Cliente']; ?>"><br>
    <button type="submit">Actualizar</button>
</form>
<?php
include 'conexion.php';

$sql = "SELECT * FROM productos";
$resultado = $conn->query($sql);

if ($resultado->num_rows > 0) {
    while($fila = $resultado->fetch_assoc()) {
        echo "ID: " . $fila["id"] . "
";
        echo "Nombre: " . $fila["nombre"] . "
";
        echo "Apellido: " . $fila["apellido"] . "
";
        echo "Contraseña: " . $fila["contraseña"] . "
";
        echo "Correo: " . $fila["correo"] . "
";
    }
} else {
    echo "No hay registros.";
}

$conn->close();
?>
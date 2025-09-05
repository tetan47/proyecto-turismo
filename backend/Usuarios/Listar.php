<?php
include 'conexion.php';

$result = myslql_query($conn, "SELECT * FROM cliente");
?>

<h2>Lista de Usuarios</h2>
<table border="1">
        <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Contraseña</th>
                <th>Correo</th>
        </tr>

<?php


    while($fila = mysqli_fetch_assoc($result)) { ?>
        <tr>
                <td><?php echo $fila['ID_Cliente']; ?></td>
                <td><?php echo $fila['nombre']; ?></td>
                <td><?php echo $fila['apellido']; ?></td>
                <td><?php echo $fila['contraseña']; ?></td>
                <td><?php echo $fila['correo']; ?></td>
                <td>
                        <a href="editar.php?ID_Cliente=<?php echo $fila['ID_Cliente']; ?>">Editar</a> |
                        <a href="eliminar.php?ID_Cliente=<?php echo $fila['ID_Cliente']; ?>">Eliminar</a>
                </td>
        </tr>
<?php  } ?>
</table>
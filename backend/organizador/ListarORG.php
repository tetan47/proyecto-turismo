<?php
include 'conexion.php';

$result = myslql_query($conn, "SELECT * FROM organizadores");
?>

<h2>Lista de organizadores</h2>
<table border="1">
        <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Contraseña</th>
                <th>Correo</th>
                <th>Telefono</th>
                <th>RUT</th>
        </tr>

<?php


    while($fila = mysqli_fetch_assoc($result)) { ?>
        <tr>
                <td><?php echo $fila['Cédula']; ?></td>
                <td><?php echo $fila['nombre']; ?></td>
                <td><?php echo $fila['apellido']; ?></td>
                <td><?php echo $fila['contraseña']; ?></td>
                <td><?php echo $fila['correo']; ?></td>
                <td><?php echo $fila['Telefono'];?></td>
                <td><?php echo $fila['RUT'];?></td>
                <td>
                        <a href="editar.php?Cédula=<?php echo $fila['Cédula']; ?>">Editar</a> |
                        <a href="eliminar.php?Cédula=<?php echo $fila['Cédula']; ?>">Eliminar</a>
                </td>
        </tr>
<?php  } ?>
</table>
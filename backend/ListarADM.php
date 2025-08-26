<?php
include 'conexion.php';

$result = myslql_query($conn, "SELECT * FROM Administradores");
?>

<h2>Lista de Administradores</h2>
<table border="1">
        <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Contraseña</th>
                <th>Correo</th>
                <th>Telefono</th>
                <th>Activo</th>
        </tr>

<?php


    while($fila = mysqli_fetch_assoc($result)) { ?>
        <tr>
                <td><?php echo $fila['ID_Administrador']; ?></td>
                <td><?php echo $fila['nombre']; ?></td>
                <td><?php echo $fila['apellido']; ?></td>
                <td><?php echo $fila['contraseña']; ?></td>
                <td><?php echo $fila['correo']; ?></td>
                <td><?php echo $fila['Telefono'];?></td>
                <td><?php echo $fila['Activo'];?></td>
                <td>
                        <a href="editar.php?ID_Administrador=<?php echo $fila['ID_Administrador']; ?>">Editar</a> |
                        <a href="eliminar.php?ID_Administrador=<?php echo $fila['ID_Administrador']; ?>">Eliminar</a>
                </td>
        </tr>
<?php  } ?>
</table>
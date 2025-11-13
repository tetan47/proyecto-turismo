<?php
include('../Conexion.php');
session_start();

$sql = "SELECT ID_Cliente, Nombre, Apellido, Correo, Registro, bloquear, imag_perfil 
        FROM cliente 
        ORDER BY Registro DESC";

$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo '<p style="padding:2em;text-align:center;color:#888;">No se encontraron usuarios.</p>';
} else {
    while ($row = $result->fetch_assoc()) {
        $nombre = htmlspecialchars($row['Nombre']);
        $apellido = htmlspecialchars($row['Apellido']);
        $correo = htmlspecialchars($row['Correo']);
        $fecha_registro = date('d/m/Y', strtotime($row['Registro']));
        $bloqueado = $row['bloquear'] ? 'Sí' : 'No';
        $imagen = !empty($row['imag_perfil']) ? htmlspecialchars($row['imag_perfil']) : 'https://cdn-icons-png.flaticon.com/512/6378/6378141.png';

        // Verificar si es organizador
        $es_organizador = false;
        $sql_organizador = "SELECT Cedula FROM organizadores WHERE ID_Cliente = ?";
        $stmt_org = $conn->prepare($sql_organizador);
        $stmt_org->bind_param("i", $row['ID_Cliente']);
        $stmt_org->execute();
        $result_org = $stmt_org->get_result();
        if ($result_org->num_rows > 0) {
            $es_organizador = true;
        }
        $stmt_org->close();

        echo '<div class="evento">';
        echo '  <div class="img-evento">';
        echo '      <img src="' . $imagen . '" alt="' . $nombre . ' ' . $apellido . '" onerror="this.src=\'https://cdn-icons-png.flaticon.com/512/6378/6378141.png\'">';
        echo '  </div>';
        echo '  <div class="info-evento">';
        echo '      <h3>' . $nombre . ' ' . $apellido . '</h3>';
        echo '      <p><strong>Correo:</strong> ' . $correo . '</p>';
        echo '      <p><strong>Fecha de registro:</strong> ' . $fecha_registro . '</p>';
        echo '      <p><strong>Bloqueado:</strong> ' . $bloqueado . '</p>';
        echo '      <p><strong>Organizador:</strong> ' . ($es_organizador ? 'Sí' : 'No') . '</p>';
        
        // Botones de acción
        echo '      <div style="margin-top: 15px;">';
        echo '      <form action="../backend/usuarios/eliminar.php" method="POST" style="display:inline;">';
        echo '          <input type="hidden" name="id" value="' . $row['ID_Cliente'] . '">';
        echo '          <button type="submit" class="boton-eliminar" onclick="return confirm(\'¿Está seguro de eliminar este usuario?\')">Eliminar</button>';
        echo '      </form>';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }
}

$stmt->close();
$conn->close();
?>

<script>
function bloquearUsuario(id) {
    if (confirm('¿Está seguro de bloquear este usuario?')) {
        fetch('../backend/usuarios/bloquearusuario.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'id=' + encodeURIComponent(id) + '&accion=bloquear'
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert('Usuario bloqueado exitosamente');
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al procesar la solicitud');
        });
    }
}

function desbloquearUsuario(id) {
    if (confirm('¿Está seguro de desbloquear este usuario?')) {
        fetch('../backend/usuarios/bloquearusuario.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'id=' + encodeURIComponent(id) + '&accion=desbloquear'
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert('Usuario desbloqueado exitosamente');
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al procesar la solicitud');
        });
    }
}
</script>
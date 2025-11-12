<?php 
include('../Conexion.php'); 

// Consulta para obtener todas las solicitudes pendientes de aprobación
$sql = "SELECT o.Cedula, o.Teléfono, c.Nombre, c.ID_Cliente
        FROM organizadores o
        LEFT JOIN cliente c ON o.ID_Cliente = c.ID_Cliente
        WHERE o.Aprobado = 0
        ORDER BY o.Cedula DESC";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo '<p style="grid-column: 1 / -1; padding:2em;text-align:center;color:red;">Error en la consulta: ' . htmlspecialchars($conn->error) . '</p>';
    exit();
}

$stmt->execute();
$result = $stmt->get_result();

// Verificar si hay resultados
if ($result->num_rows === 0) {
    echo '<div style="grid-column: 1 / -1; text-align: center; padding: 3em;">';
    echo '<h3>No hay solicitudes pendientes</h3>';
    echo '<p>Todas las solicitudes han sido procesadas.</p>';
    echo '</div>';
} else {
    echo '<h2 style="grid-column: 1 / -1; text-align: center; padding: 1em;">Solicitudes Pendientes de Aprobación</h2>';
    
    // Iterar sobre los resultados
    while ($row = $result->fetch_assoc()) {
        $cedula = htmlspecialchars($row['Cedula']);
        $telefono = htmlspecialchars($row['Teléfono']);
        $nombre = htmlspecialchars($row['Nombre']);
        $idCliente = htmlspecialchars($row['ID_Cliente']);
        
        echo '<div class="evento">';
        echo '  <div class="info-evento">';
        echo '      <h3>' . $nombre . '</h3>';
        echo '      <p><strong>Cédula:</strong> ' . $cedula . '</p>';
        echo '      <p><strong>Teléfono:</strong> ' . $telefono . '</p>';
        echo '      <p><strong>ID Cliente:</strong> ' . $idCliente . '</p>';
        echo '      <div style="display: flex; justify-content: center; gap: 10px; margin-top: auto;">';
        echo '          <button style="flex: 1; background-color: #00e927ff;" onclick="aprobarSolicitud(\'' . $cedula . '\')"> Aprobar</button>';
        echo '          <button style="flex: 1; background-color: #ff1100ff;" onclick="rechazarSolicitud(\'' . $cedula . '\')"> Rechazar</button>';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }
}

$stmt->close();
$conn->close();
?>
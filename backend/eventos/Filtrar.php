<?php 

include('../Conexion.php');

session_start();

$busqueda = isset($_POST['Busqueda']) ? trim($_POST['Busqueda']) : '';
$fecha = isset($_POST['Fecha_Inicio']) ? $_POST['Fecha_Inicio'] : '';
$hora = isset($_POST['hora']) ? $_POST['hora'] : '';
$categoria = isset($_POST['categoria']) ? $_POST['categoria'] : '';

// Consultar 
$condiciones = [];
$params = [];

if (strlen($busqueda) >= 3) {
    $condiciones[] = "(Título LIKE ?)";
    $params[] = "%$busqueda%";
}
if (!empty($fecha)) {
    $condiciones[] = 'Fecha_Inicio = ?';
    $params[] = $fecha;
}
if (!empty($hora)) {
    $condiciones[] = "Hora = ?";
    $params[] = $hora;
}
if (!empty($categoria)) {
    $condiciones[] = "categoria = ?";
    $params[] = $categoria;
}

// Construir la consulta final
$sql = "SELECT ID_Evento, Título, Fecha_Inicio, Hora, categoria, imagen FROM eventos";
if (count($condiciones) > 0) {
    $sql .= " WHERE " . implode(" AND ", $condiciones);
}

// Preparar y ejecutar la consulta
$stmt = $conn->prepare($sql);
if ($params) {
    $types = str_repeat('s', count($params));
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo '<p style="padding:2em;text-align:center;color:#888;">No se encontraron eventos.</p>';
} else {
    while ($row = $result->fetch_assoc()) {
        echo '<div class="evento">';
        echo '<div class="img-evento">';
        echo '<img src="' . htmlspecialchars($row['imagen']) . '" alt="Imagen Evento" />';
        echo '</div>';
        echo '<div class="info-evento">';
        echo '<h3>' . htmlspecialchars($row['Título']) . '</h3>';
        echo '<p>' . htmlspecialchars($row['Fecha_Inicio']) . ' - ' . htmlspecialchars($row['Hora']) . '</p>';
        echo '<p>' . htmlspecialchars($row['categoria']) . '</p>';
        echo '<a href="evento.php?id=' . $row['ID_Evento'] . '" class="boton-ver-detalles">Ver Detalles</a>';
        echo '</div>';
        echo '</div>';
    }
}

$stmt->close();
$conn->close();
?>
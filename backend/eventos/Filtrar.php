<?php  
include('../Conexion.php');
session_start();

$busqueda = isset($_POST['Busqueda']) ? trim($_POST['Busqueda']) : '';
$fechaInicio = isset($_POST['fecha-inicio']) ? $_POST['fecha-inicio'] : '';
$fechaFin = isset($_POST['fecha-fin']) ? $_POST['fecha-fin'] : '';
$horaInicio = isset($_POST['hora-inicio']) ? $_POST['hora-inicio'] : '';
$horaFin = isset($_POST['hora-fin']) ? $_POST['hora-fin'] : '';
$categoria = isset($_POST['categoria']) ? $_POST['categoria'] : '';

// Validaciones de fecha y hora
if (!empty($fechaInicio) && !empty($fechaFin) && $fechaInicio > $fechaFin) {
    echo '<p style="text-align:center;color:#f88;margin-top:2em;">⚠️ La fecha de inicio debe ser anterior o igual a la de fin.</p>';
    $conn->close();
    exit;
}
if (!empty($horaInicio) && !empty($horaFin) && $horaInicio >= $horaFin) {
    echo '<p style="text-align:center;color:#f88;margin-top:2em;">⚠️ La hora de inicio debe ser menor a la de fin.</p>';
    $conn->close();
    exit;
}

// Filtros dinámicos
$condiciones = [];
$params = [];

if (strlen($busqueda) >= 3) {
    $condiciones[] = "(Título LIKE ?)";
    $params[] = "%$busqueda%";
}

if (!empty($fechaInicio) && !empty($fechaFin)) {
    $condiciones[] = "Fecha_Inicio BETWEEN ? AND ?";
    $params[] = $fechaInicio;
    $params[] = $fechaFin;
} elseif (!empty($fechaInicio)) {
    $condiciones[] = "Fecha_Inicio >= ?";
    $params[] = $fechaInicio;
} elseif (!empty($fechaFin)) {
    $condiciones[] = "Fecha_Inicio <= ?";
    $params[] = $fechaFin;
}

if (!empty($horaInicio) && !empty($horaFin)) {
    $condiciones[] = "Hora BETWEEN ? AND ?";
    $params[] = $horaInicio;
    $params[] = $horaFin;
} elseif (!empty($horaInicio)) {
    $condiciones[] = "Hora >= ?";
    $params[] = $horaInicio;
} elseif (!empty($horaFin)) {
    $condiciones[] = "Hora <= ?";
    $params[] = $horaFin;
}

if (!empty($categoria)) {
    $condiciones[] = "categoria = ?";
    $params[] = $categoria;
}

$sql = "SELECT ID_Evento, Título, Fecha_Inicio, Fecha_Fin, Hora, categoria, imagen, Ubicacion
        FROM eventos";
if (count($condiciones) > 0) {
    $sql .= " WHERE " . implode(" AND ", $condiciones);
}
$sql .= " ORDER BY Fecha_Inicio ASC, Hora ASC";

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
        $titulo = htmlspecialchars($row['Título']);
        $categoria = htmlspecialchars($row['categoria']);
        $fecha = htmlspecialchars($row['Fecha_Inicio']) . ' - ' . htmlspecialchars($row['Fecha_Fin']);
        $hora = htmlspecialchars($row['Hora']);
        $imagen = !empty($row['imagen']) ? htmlspecialchars($row['imagen']) : 'https://upload.wikimedia.org/wikipedia/commons/0/0e/DefaultImage.png';

        // Verificar si Ubicacion contiene un iframe
        if (isset($row['Ubicacion']) && strpos($row['Ubicacion'], '<iframe') !== false) {
            // Mostrar el iframe directamente (sin escapar)
            $ubicacionHTML = '<button class="ver-mapa" onclick="toggleMapa(this)">Ver mapa</button>'
                . '<div class="mapa" style="display:none;">' . $row['Ubicacion'] . '</div>';
        } else {
            // Escapar texto común, pero no los iframes
            $ubicacionHTML = '<p>' . htmlspecialchars($row['Ubicacion']) . '</p>';
        }
        
        echo '<div class="evento">';
        echo '  <div class="img-evento">';
        echo '      <img src="' . $imagen . '" alt="' . $titulo . '" onerror="this.src=\'https://upload.wikimedia.org/wikipedia/commons/0/0e/DefaultImage.png\'">';
        echo '  </div>';
        echo '  <div class="info-evento">';
        echo '      <h3>' . $titulo . '</h3>';
        echo '      <p>' . $fecha . ' - ' . $hora . '</p>';
        echo '      <p>Categoría: ' . $categoria . '</p>';
        echo $ubicacionHTML;
        echo '      <a href="evento.php?id=' . $row['ID_Evento'] . '" class="boton-ver-detalles">Ver Detalles</a>';
        echo '  </div>';
        echo '</div>';
    }
}

$stmt->close();
$conn->close();
?>

<script>
    function toggleMapa(btn) {
        const mapa = btn.nextElementSibling;
        if (mapa.style.display === "none") {
            mapa.style.display = "block";
            btn.textContent = "Ocultar mapa";
        } else {
            mapa.style.display = "none";
            btn.textContent = "Ver mapa";
        }
    }
</script>

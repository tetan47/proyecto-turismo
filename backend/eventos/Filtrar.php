<?php 

include('../Conexion.php');

session_start();

$busqueda = isset($_POST['Busqueda']) ? trim($_POST['Busqueda']) : '';
$fechaInicio = isset($_POST['fecha-inicio']) ? $_POST['fecha-inicio'] : '';
$fechaFin = isset($_POST['fecha-fin']) ? $_POST['fecha-fin'] : '';
$horaInicio = isset($_POST['hora-inicio']) ? $_POST['hora-inicio'] : '';
$horaFin = isset($_POST['hora-fin']) ? $_POST['hora-fin'] : '';
$categoria = isset($_POST['categoria']) ? $_POST['categoria'] : '';

// Validar rango de fechas
if (!empty($fechaInicio) && !empty($fechaFin) && $fechaInicio > $fechaFin) {
    echo '<div style="position: fixed;
      top: 60%;
      left: 50%;
      transform: translate(-50%, -50%);
      background-color: #f8d7da;
      padding: 20px 30px;
      border: 1px solid #f5c6cb;
      border-radius: 8px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.2);
      z-index: 9999;
      font-family: sans-serif;">';
    echo '<h2 style="color: #721c24;">Fecha no válida</h2>';
    echo '<p style="color: #721c24;">La fecha de inicio debe ser anterior o igual a la fecha de fin.</p>';
    echo '</div>';    
    $conn->close();
    exit;
}

// Validar rango de horas
if (!empty($horaInicio) && !empty($horaFin) && $horaInicio >= $horaFin) {
    echo '<div style="position: fixed;
      top: 60%;
      left: 50%;
      transform: translate(-50%, -50%);
      background-color: #f8d7da;
      padding: 20px 30px;
      border: 1px solid #f5c6cb;
      border-radius: 8px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.2);
      z-index: 9999;
      font-family: sans-serif;">';
    echo '<h2 style="color: #721c24;">Hora no válida</h2>';
    echo '<p style="color: #721c24;">La hora de inicio debe ser anterior a la hora de fin.</p>';
    echo '</div>';    
    $conn->close();
    exit;
} elseif (!empty($fechaInicio) && !empty($fechaFin) && $fechaInicio > $fechaFin) { 
// Validar rango de fechas
    echo '<div style="position: fixed;
      top: 60%;
      left: 50%;
      transform: translate(-50%, -50%);
      background-color: #f8d7da;
      padding: 20px 30px;
      border: 1px solid #f5c6cb;
      border-radius: 8px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.2);
      z-index: 9999;
      font-family: sans-serif;">';
    echo '<h2 style="color: #721c24;">Fecha no válida</h2>';
    echo '<p style="color: #721c24;">La fecha de inicio debe ser anterior a la fecha de final.</p>';
    echo '</div>';    
    $conn->close();
    exit;
}

// Construir consulta
$condiciones = [];
$params = [];

if (strlen($busqueda) >= 3) {
    $condiciones[] = "(Título LIKE ?)";
    $params[] = "%$busqueda%";
}

// FILTRO POR RANGO DE FECHAS
if (!empty($fechaInicio) && !empty($fechaFin)) {
    // Ambas fechas definidas: buscar eventos entre ese rango
    $condiciones[] = "Fecha_Inicio BETWEEN ? AND ?";
    $params[] = $fechaInicio;
    $params[] = $fechaFin;
} elseif (!empty($fechaInicio)) {
    // Solo fecha inicio: buscar eventos desde esa fecha en adelante
    $condiciones[] = "Fecha_Inicio >= ?";
    $params[] = $fechaInicio;
} elseif (!empty($fechaFin)) {
    // Solo fecha fin: buscar eventos hasta esa fecha
    $condiciones[] = "Fecha_Inicio <= ?";
    $params[] = $fechaFin;
}

// FILTRO POR RANGO DE HORAS
if (!empty($horaInicio) && !empty($horaFin)) {
    // Ambas horas están definidas: buscar eventos entre ese rango
    $condiciones[] = "Hora BETWEEN ? AND ?";
    $params[] = $horaInicio;
    $params[] = $horaFin;
} elseif (!empty($horaInicio)) {
    // Solo hora inicio: buscar eventos desde esa hora en adelante
    $condiciones[] = "Hora >= ?";
    $params[] = $horaInicio;
} elseif (!empty($horaFin)) {
    // Solo hora fin: buscar eventos hasta esa hora
    $condiciones[] = "Hora <= ?";
    $params[] = $horaFin;
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
$sql .= " ORDER BY Fecha_Inicio ASC, Hora ASC";

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
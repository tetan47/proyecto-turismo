<?php 

include('../Conexion.php');

session_start();
$busqueda = isset($_POST['Busqueda']) ? trim($_POST['Busqueda']) : '';
$fechaInicio = isset($_POST['fecha-inicio']) ? $_POST['fecha-inicio'] : '';
$fechaFin = isset($_POST['fecha-fin']) ? $_POST['fecha-fin'] : '';
$categoria = isset($_POST['categoria']) ? $_POST['categoria'] : '';
$cedula = $_SESSION['user']['cedula'];
$esOrganizador = $_SESSION['user']['esOrganizador'];
$nombreUsuario = $_SESSION['user']['nombre'];
// Construir la consulta SQL base
$sql = "SELECT * FROM eventos WHERE 1=1";
$condiciones = [];
$params = [];
// FILTRO POR BÚSQUEDA
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
} elseif (!empty($categoria)) {
    $condiciones[] = "categoria = ?";
    $params[] = $categoria;
}
// Construir la consulta final
if (count($condiciones) > 0) {
    $sql .= " AND " . implode(" AND ", $condiciones);
}
$sql .= " ORDER BY Fecha_Inicio ASC, Hora ASC";
// Preparar y ejecutar la consulta
$stmt = $conn->prepare($sql);
if ($params) {
    $tipos = str_repeat('s', count($params));
    $stmt->bind_param($tipos, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
// Mostrar los resultados
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $idEvento = $row['ID_Evento'];
        $titulo = htmlspecialchars($row['Título']);
        $fechaInicio = date('d/m/Y', strtotime($row['Fecha_Inicio']));
        $hora = date('H:i', strtotime($row['Hora']));
        $categoria = htmlspecialchars($row['categoria']);
        $imagen = !empty($row['imagen']) ? 'data:image/jpeg;base64,' . base64_encode($row['imagen']) : 'https://via.placeholder.com/150';
        echo "<div class='evento'>
                <img src='$imagen' alt='Imagen del evento' class='imagen-evento'>
                <h3>$titulo</h3>
                <p><strong>Fecha:</strong> $fechaInicio</p>
                <p><strong>Hora:</strong> $hora</p>
                <p><strong>Categoría:</strong> $categoria</p>
                <a href='detalle_evento.php?id=$idEvento' class='btn-detalle'>Ver Detalles</a>
              </div>";
    }
} else {
    echo "<p>No se encontraron eventos que coincidan con los criterios de búsqueda.</p>";
}
$conn->close();
?>
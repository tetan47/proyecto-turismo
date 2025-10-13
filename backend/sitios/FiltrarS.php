<?php 

include('../Conexion.php');

session_start();

$busqueda = isset($_POST['Busqueda']) ? trim($_POST['Busqueda']) : '';
$categoria = isset($_POST['categoria']) ? $_POST['categoria'] : '';

// Consultar 
$condiciones = [];
$params = [];

if (strlen($busqueda) >= 3) {
    $condiciones[] = "(Titulo LIKE ?)";
    $params[] = "%$busqueda%";
}

if (!empty($categoria)) {
    $condiciones[] = "categoria = ?";
    $params[] = $categoria;
}


$sql = "SELECT ID_Sitio, Titulo, Estado, Ubicacion, Categoria, Imagen FROM sitioturistico";
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
    echo '<p style="padding:2em;text-align:center;color:#888;">No se encontraron sitios.</p>';
} else {
    while ($row = $result->fetch_assoc()) {
          // Si es un iframe de Google Maps, mostrar solo el enlace "Ver en el mapa"
    if (strpos($row['Ubicacion'], '<iframe') !== false) {
        $ubicacion = 'Ver en el mapa';
    } else {
        $ubicacion = htmlspecialchars($row['Ubicacion']);
    }
        echo '<div class="evento">';
        echo '<div class="img-evento">';
        echo '<img src="' . htmlspecialchars($row['Imagen']) . '" alt="Imagen sitio" />';
        echo '</div>';
        echo '<div class="info-evento">';
        echo '<h3>' . htmlspecialchars($row['Titulo']) . '</h3>';
        echo '<p>' . htmlspecialchars($row['Estado']) . ' - ' . $ubicacion . '</p>';
        echo '<p>' . 'Categoría: ' . htmlspecialchars($row['Categoria']) . '</p>';
        echo '<a href="sitio.php?id=' . $row['ID_Sitio'] . '" class="boton-ver-detalles">Ver Detalles</a>';
        echo '</div>';
        echo '</div>';
    }
}

$stmt->close();
$conn->close();
?>
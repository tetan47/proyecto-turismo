<?php
include('../Conexion.php');
session_start();

$busqueda = isset($_POST['Busqueda']) ? trim($_POST['Busqueda']) : '';
$categoria = isset($_POST['categoria']) ? $_POST['categoria'] : '';

$condiciones = [];
$params = [];

if (strlen($busqueda) >= 3) {
    $condiciones[] = "(Titulo LIKE ?)";
    $params[] = "%$busqueda%";
}

if (!empty($categoria)) {
    $condiciones[] = "Categoria = ?";
    $params[] = $categoria;
}

$sql = "SELECT ID_Sitio, Titulo, Estado, Ubicacion, Categoria, Imagen, Hora_Inicio, Hora_Fin 
        FROM sitioturistico";
if (count($condiciones) > 0) {
    $sql .= " WHERE " . implode(" AND ", $condiciones);
}

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
        $titulo = htmlspecialchars($row['Titulo']);
        $categoria = htmlspecialchars($row['Categoria']);
        $estado = htmlspecialchars($row['Estado']);
        $imagen = !empty($row['Imagen']) ? htmlspecialchars($row['Imagen']) : 'https://upload.wikimedia.org/wikipedia/commons/0/0e/DefaultImage.png';
        $horaInicio = $row['Hora_Inicio'] ? date('H:i', strtotime($row['Hora_Inicio'])) : '';
        $horaFin = $row['Hora_Fin'] ? date('H:i', strtotime($row['Hora_Fin'])) : '';

        // Ubicación: mostrar botón si es un iframe
        /*     if (strpos($row['Ubicacion'], '<iframe') !== false) {
                 $ubicacionHTML = '
                     <button class="ver-mapa" onclick="toggleMapa(this)">Ver mapa</button>
                     <div class="mapa" style="display:none;">' . $row['Ubicacion'] . '</div>';
             } else {
                 $ubicacionHTML = '<p>' . htmlspecialchars($row['Ubicacion']) . '</p>';
             }*/

        if (strpos($row['Ubicacion'], '<iframe') !== false) {
            // Mostrar el iframe directamente (sin escapar)
            $ubicacionHTML = '
        <button class="ver-mapa" onclick="toggleMapa(this)">Ver mapa</button>
        <div class="mapa" style="display:none;">' . $row['Ubicacion'] . '</div>';
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
        echo '      <p>Estado: ' . $estado . '</p>';
        if ($horaInicio && $horaFin) {
            echo '  <p>Horario: ' . $horaInicio . ' - ' . $horaFin . '</p>';
        }
        echo '      <p>Categoría: ' . $categoria . '</p>';
        echo $ubicacionHTML;
        echo '      <a href="sitio.php?id=' . $row['ID_Sitio'] . '" class="boton-ver-detalles">Ver Detalles</a>';
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
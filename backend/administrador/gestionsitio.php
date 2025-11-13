<?php
include('../Conexion.php');
session_start();

$sql = "SELECT ID_Sitio, Titulo, Estado, Imagen 
        FROM sitioturistico 
        ORDER BY Titulo ASC";

$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo '<p style="padding:2em;text-align:center;color:#888;">No se encontraron sitios turísticos.</p>';
} else {
    while ($row = $result->fetch_assoc()) {
        $titulo = htmlspecialchars($row['Titulo']);
        $estado = htmlspecialchars($row['Estado']);
        $imagen = !empty($row['Imagen']) ? htmlspecialchars($row['Imagen']) : 'https://upload.wikimedia.org/wikipedia/commons/0/0e/DefaultImage.png';


        echo '<div class="evento">';
        echo '  <div class="img-evento">';
        echo '      <img src="' . $imagen . '" alt="' . $titulo . '" onerror="this.src=\'https://upload.wikimedia.org/wikipedia/commons/0/0e/DefaultImage.png\'">';
        echo '  </div>';
        echo '  <div class="info-evento">';
        echo '      <h3>' . $titulo . '</h3>';
        echo '      <a href="EditarSitio.php?id=' . $row['ID_Sitio'] . '" class="boton-ver-detalles">Editar</a>';
        echo '
                <form action="../backend/sitios/eliminarsitio.php" method="POST" style="display:inline;">
                  <input type="hidden" name="id" value="' . $row['ID_Sitio'] . '">
                    <button type="submit" class="boton-eliminar">Eliminar</button>
                </form>';
        echo '  </div>';
        echo '</div>';
    }
}

$stmt->close();
$conn->close();
?>
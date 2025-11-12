<?php
include('../Conexion.php');
session_start();


$sql = "SELECT ID_Evento, Título, Fecha_Inicio, Fecha_Fin, Hora, categoria, imagen, Ubicacion
        FROM eventos";
$sql .= " ORDER BY Fecha_Inicio ASC, Hora ASC";

$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo '<p style="padding:2em;text-align:center;color:#888;">No se encontraron eventos.</p>';
} else {
    while ($row = $result->fetch_assoc()) {
        $titulo = htmlspecialchars($row['Título']);
        $imagen = !empty($row['imagen']) ? htmlspecialchars($row['imagen']) : 'https://upload.wikimedia.org/wikipedia/commons/0/0e/DefaultImage.png';

        echo '<div class="evento">';
        echo '  <div class="img-evento">';
        echo '      <img src="' . $imagen . '" alt="' . $titulo . '" onerror="this.src=\'https://upload.wikimedia.org/wikipedia/commons/0/0e/DefaultImage.png\'">';
        echo '  </div>';
        echo '  <div class="info-evento">';
        echo '      <h3>' . $titulo . '</h3>';
        echo '      <a href="EditarEvento.php?id=' . $row['ID_Evento'] . '" class="boton-ver-detalles">Editar</a>';
        echo '
                <form action="../backend/eventos/eliminarevento.php" method="POST">
                  <input type="hidden" name="id" value="' . $row['ID_Evento'] . '">
                    <button type="submit" >Eliminar</button>
                </form>';
        echo '  </div>';
        echo '</div>';
    }
}

$stmt->close();
$conn->close();

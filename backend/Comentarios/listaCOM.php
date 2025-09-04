<?php
session_start();
include('../Conexion.php');

$id_evento = isset($_GET['id_evento']) ? intval($_GET['id_evento']) : 0;
$idUsuario = $_SESSION['ID_Cliente'] ?? 0;
$usuario_logueado = ($idUsuario > 0);

$sql = "SELECT c.ID_Comentario, c.texto, c.LIKES, c.Creación_Comentario, 
               cl.Nombre, cl.imag_perfil, c.usuarios_like
        FROM comentarios c 
        JOIN cliente cl ON c.ID_Cliente = cl.ID_Cliente 
        WHERE c.ID_Evento = ?
        ORDER BY c.Creación_Comentario DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_evento); 
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo '<p style="padding:2em;text-align:center;color:#888;">No se encontraron comentarios.</p>';
} else {
    while ($row = $result->fetch_assoc()) {
        $usuarios_like = $row['usuarios_like'] ? explode(',', $row['usuarios_like']) : [];
        $liked = ($idUsuario && in_array($idUsuario, $usuarios_like)) ? true : false;

        echo '<div class="comentarios">';
            echo '<div class="foto-perfil">';
                echo '<img src="' . htmlspecialchars($row['imag_perfil']) . '" alt="Foto de Perfil" />';
            echo '</div>';
            echo '<div class="info-comentarios">';
                echo '<div class="header">';
                    echo '<h3>' . htmlspecialchars($row['Nombre']) . '</h3>';
                    echo '<h4>' . htmlspecialchars($row['Creación_Comentario']) . '</h4>';
                echo '</div>';
                echo '<p>' . htmlspecialchars($row['texto']) . '</p>';
                echo '<div class="footer-comentarios">';
                    echo '<button type="button" class="responder" onclick="responder()">Responder</button>';
                    
                    // Botón de like con verificación de sesión
                    if ($usuario_logueado) {
                        echo '<label class="cora '.($liked ? "liked" : "").'" data-id="' . $row['ID_Comentario'] . '">';
                            echo '&#10084;';
                            echo '<div class="likes">' . htmlspecialchars($row['LIKES']) . '</div>';
                        echo '</label>';
                    } else {
                        // Mostrar like pero deshabilitado con mensaje tooltip
                        echo '<label class="cora disabled" title="Inicia sesión para dar like">';
                            echo '&#10084;';
                            echo '<div class="likes">' . htmlspecialchars($row['LIKES']) . '</div>';
                        echo '</label>';
                    }
                echo '</div>';
            echo '</div>';
        echo '</div>';
    }
}

$stmt->close();
$conn->close();
?>
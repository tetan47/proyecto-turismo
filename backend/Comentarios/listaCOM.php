<?php

include('../Conexion.php');
session_start();

$evento_id = isset($_GET['id_evento']) ? intval($_GET['id_evento']) : 0;
$idUsuario = $_SESSION['ID_Cliente'] ?? 0;
$usuario_logueado = ($idUsuario > 0);

if ($evento_id > 0) {
    $sql = "SELECT c.ID_Comentario, c.Texto, c.LIKES, c.Creación_Comentario, 
                   cl.Nombre, cl.imag_perfil, c.usuarios_like
            FROM comentarios c 
            JOIN cliente cl ON c.ID_Cliente = cl.ID_Cliente 
            WHERE c.ID_Evento = ?
            ORDER BY c.Creación_Comentario DESC";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $evento_id); 
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $usuarios_like = $row['usuarios_like'] ? explode(',', $row['usuarios_like']) : [];
            $liked = ($idUsuario && in_array($idUsuario, $usuarios_like)) ? true : false;
?>
            <!-- Comentarios -->
            <div class="comentarios">
                <div class="foto-perfil">
                    <img src="<?php echo htmlspecialchars($row['imag_perfil']); ?>" alt="Foto de Perfil" />
                </div>
                <div class="info-comentarios">
                    <div class="header">
                        <h3><?php echo htmlspecialchars($row['Nombre']); ?></h3>
                        <h4><?php echo htmlspecialchars($row['Creación_Comentario']); ?></h4>
                    </div>
                    <p><?php echo htmlspecialchars($row['Texto']); ?></p>
                    <div class="footer-comentarios">
                        <!-- BOTÓN RESPONDER VISIBLE PARA TODOS -->
                        <button type="button" class="responder" onclick="mostrarFormularioRespuesta(<?php echo $row['ID_Comentario']; ?>)">Responder</button>

                        <label class="cora <?php echo ($liked ? "liked" : ""); echo (!$usuario_logueado ? " disabled" : ""); ?>" 
                               data-id="<?php echo $row['ID_Comentario']; ?>">
                            &#10084;
                            <div class="likes"><?php echo htmlspecialchars($row['LIKES']); ?></div>
                        </label>
                    </div>

    <!-- Respuestas a...-->
        <div id="respuestas_<?php echo $row['ID_Comentario']; ?>" class="respuestas">
         <?php
             $sql_respuestas = "SELECT r.comentario_responder, r.respuesta, r.Creación_Respuesta, 
                                     r.LIKESRES, r.usuarios_like_res, cl.Nombre, cl.imag_perfil
                                FROM respondercomentario r
                                JOIN cliente cl ON r.ID_Cliente = cl.ID_Cliente
                                WHERE r.ID_Comentario = ?
                                ORDER BY r.Creación_Respuesta ASC";

                        $stmt_respuestas = $conn->prepare($sql_respuestas);
                        $stmt_respuestas->bind_param("i", $row['ID_Comentario']);
                        $stmt_respuestas->execute();
                        $respuestas_result = $stmt_respuestas->get_result();

                        while ($respuesta = $respuestas_result->fetch_assoc()) {
                            $usuarios_like_res = $respuesta['usuarios_like_res'] ? explode(',', $respuesta['usuarios_like_res']) : []; 
                            
                            $liked_respuesta = ($idUsuario && in_array($idUsuario, $usuarios_like_res));

                        ?>
                        
                            <div class="comentarios">
                                <div class="foto-perfil">
                                    <img src="<?php echo htmlspecialchars($respuesta['imag_perfil']); ?>" alt="Foto de Perfil" />
                                </div>
                                <div class="info-comentarios">
                                    <div class="header">
                                        <h4><?php echo htmlspecialchars($respuesta['Nombre']); ?></h4>
                                        <h5><?php echo htmlspecialchars($respuesta['Creación_Respuesta']); ?></h5>
                                    </div>
                                    <p><?php echo htmlspecialchars($respuesta['respuesta']); ?></p>
                                    
                                    <!-- LIKES PARA RESPUESTAS -->
                                    <div class="footer-comentarios">
                                        <label class="cora-respuesta
                                                <?php echo $liked_respuesta ? 'liked' : ''; ?>
                                                <?php echo !$usuario_logueado ? ' disabled' : ''; ?>"
                                            data-id="<?php echo $respuesta['comentario_responder']; ?>">
                                                    &#10084;
                                            <div class="likes"><?php echo htmlspecialchars($respuesta['LIKESRES']); ?></div>
                                        </label>

                                    </div>
                                </div>
                            </div>
                        <?php } 
                        $stmt_respuestas->close();
                        ?>
                    </div>

                    <?php if ($usuario_logueado): ?>
                    <div class="formulario-respuesta" id="form_respuesta_<?php echo $row['ID_Comentario']; ?>" style="display:none;">
                        <textarea id="texto_respuesta_<?php echo $row['ID_Comentario']; ?>" placeholder="Escribe tu respuesta..." style="width: 100%;"></textarea>
                        <button onclick="enviarRespuesta(<?php echo $row['ID_Comentario']; ?>)">Enviar Respuesta</button>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php } ?>
    <?php } else { ?>
        <p>No hay comentarios para este evento.</p>
    <?php } 
    $stmt->close();
} else { ?>
    <p>ID de evento no válido.</p>
<?php } 

$conn->close();
?>
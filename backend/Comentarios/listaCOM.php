<?php
include('../Conexion.php');
session_start();

$evento_id = isset($_GET['id_evento']) ? intval($_GET['id_evento']) : 0;
$idUsuario = $_SESSION['ID_Cliente'] ?? 0;
$usuario_logueado = ($idUsuario > 0);

if ($evento_id > 0) {
    $sql = "SELECT c.ID_Comentario, c.Texto, c.LIKES, c.Creación_Comentario, 
                   cl.Nombre, cl.imag_perfil, c.usuarios_like, c.ID_Cliente
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
            $esPropietario = ($idUsuario == $row['ID_Cliente']);
?>
            <!-- Comentarios -->
            <div class="comentarios" id="comentario_<?php echo $row['ID_Comentario']; ?>">
                <div class="foto-perfil">
                    <img src="<?php echo htmlspecialchars($row['imag_perfil']); ?>" alt="Foto de Perfil" />
                </div>
                <div class="info-comentarios">
                    <div class="header">
                        <div class="header-content">
                            <h3><?php echo htmlspecialchars($row['Nombre']); ?></h3>
                            <h4><?php echo htmlspecialchars($row['Creación_Comentario']); ?></h4>
                        </div>
                        <?php if ($esPropietario): ?>
                        <div class="menu-coment">
                            <button class="menu-btn" onclick="toggleMenu(<?php echo $row['ID_Comentario']; ?>)">⋮</button>
                            <div class="menu-contenido" id="opciones_<?php echo $row['ID_Comentario']; ?>" style="display:none;">
                                <button onclick="mostrarEditor(<?php echo $row['ID_Comentario']; ?>, `<?php echo addslashes($row['Texto']); ?>`)">Editar</button>
                                <hr>
                                <button onclick="eliminarComentario(<?php echo $row['ID_Comentario']; ?>)">Eliminar</button>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Contenedor del texto y editor -->
                    <div id="texto_comentario_<?php echo $row['ID_Comentario']; ?>">
                        <p><?php echo htmlspecialchars($row['Texto']); ?></p>
                    </div>
                    
                    <!-- Editor oculto -->
                    <div id="editor_comentario_<?php echo $row['ID_Comentario']; ?>" style="display:none;">
                        <textarea id="texto_edicion_<?php echo $row['ID_Comentario']; ?>" style="width:100%;"><?php echo htmlspecialchars($row['Texto']); ?></textarea>
                        <div style="margin-top:10px;">
                            <button onclick="guardarEdicionComentario(<?php echo $row['ID_Comentario']; ?>)">Guardar</button>
                            <button onclick="cancelarEdicionComentario(<?php echo $row['ID_Comentario']; ?>)">Cancelar</button>
                        </div>
                    </div>
                    
                    <div class="footer-comentarios">
                        <!-- BOTÓN RESPONDER VISIBLE PARA TODOS -->
                        <button type="button" class="responder" onclick="mostrarFormularioRespuesta(<?php echo $row['ID_Comentario']; ?>)">Responder</button>

                        <label class="cora <?php echo ($liked ? "liked" : ""); echo (!$usuario_logueado ? " disabled" : ""); ?>" 
                               data-id="<?php echo $row['ID_Comentario']; ?>">
                            &#10084;
                            <div class="likes"><?php echo htmlspecialchars($row['LIKES']); ?></div>
                        </label>
                    </div>

                    <!-- Respuestas -->
                    <div id="respuestas_<?php echo $row['ID_Comentario']; ?>" class="respuestas">
                        <?php
                        $sql_respuestas = "SELECT r.comentario_responder, r.respuesta, r.Creación_Respuesta, 
                                                 r.LIKESRES, r.usuarios_like_res, cl.Nombre, cl.imag_perfil, cl.ID_Cliente
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
                            $esPropietarioRespuesta = ($idUsuario == $respuesta['ID_Cliente']);
                        ?>
                        
                        <div class="comentarios respuesta" id="respuesta_<?php echo $respuesta['comentario_responder']; ?>">
                            <div class="foto-perfil">
                                <img src="<?php echo htmlspecialchars($respuesta['imag_perfil']); ?>" alt="Foto de Perfil" />
                            </div>
                            <div class="info-comentarios">
                                <div class="header">
                                    <div class="header-content">
                                        <h4><?php echo htmlspecialchars($respuesta['Nombre']); ?></h4>
                                        <h5><?php echo htmlspecialchars($respuesta['Creación_Respuesta']); ?></h5>
                                    </div>
                                    <?php if ($esPropietarioRespuesta): ?>
                                    <div class="menu-coment">
                                        <button class="menu-btn" onclick="toggleMenuRes(<?php echo $respuesta['comentario_responder']; ?>)">⋮</button>
                                        <div class="menu-contenido" id="opciones_res_<?php echo $respuesta['comentario_responder']; ?>" style="display:none;">
                                            <button onclick="mostrarEditorRes(<?php echo $respuesta['comentario_responder']; ?>, `<?php echo addslashes($respuesta['respuesta']); ?>`)">Editar</button>
                                            <hr>
                                            <button onclick="eliminarRespuesta(<?php echo $respuesta['comentario_responder']; ?>)">Eliminar</button>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                
                                <!-- Contenedor del texto y editor para respuestas -->
                                <div id="texto_respuesta_<?php echo $respuesta['comentario_responder']; ?>">
                                    <p><?php echo htmlspecialchars($respuesta['respuesta']); ?></p>
                                </div>
                                
                                <!-- Editor oculto para respuestas -->
                                <div id="editor_respuesta_<?php echo $respuesta['comentario_responder']; ?>" style="display:none;">
                                    <textarea id="texto_edicion_res_<?php echo $respuesta['comentario_responder']; ?>" style="width:100%;"><?php echo htmlspecialchars($respuesta['respuesta']); ?></textarea>
                                    <div style="margin-top:10px;">
                                        <button onclick="guardarEdicionRespuesta(<?php echo $respuesta['comentario_responder']; ?>)">Guardar</button>
                                        <button onclick="cancelarEdicionRespuesta(<?php echo $respuesta['comentario_responder']; ?>)">Cancelar</button>
                                    </div>
                                </div>
                                
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
        <div style="padding:1em;text-align:center;color:#555;">
        <p>No hay comentarios para este evento.</p>
        </div>
    <?php } 
    $stmt->close();
} else { ?>
    <p>ID de evento no válido.</p>
<?php } 

$conn->close();
?>
<?php
include('../backend/Conexion.php');
session_start();

// Obtener datos del usuario si está logueado
if (isset($_SESSION['ID_Cliente'])) {
    $usuario_id = $_SESSION['ID_Cliente'];
    $sql_usuario = "SELECT Nombre, imag_perfil FROM cliente WHERE ID_Cliente = ?";
    $stmt_usuario = $conn->prepare($sql_usuario);
    $stmt_usuario->bind_param('i', $usuario_id);
    $stmt_usuario->execute();
    $result_usuario = $stmt_usuario->get_result();
    $datosUsuario = $result_usuario->fetch_assoc();
    $stmt_usuario->close();
}

// Obtener el ID del evento desde la URL
$evento_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$usuario_logueado = isset($_SESSION['ID_Cliente']);

if ($evento_id > 0) {
    $sql = "SELECT e.*, c.Nombre
        FROM eventos e
        LEFT JOIN organizadores o ON e.Cédula = o.Cedula
        LEFT JOIN cliente c ON o.ID_Cliente = c.ID_Cliente
        WHERE e.ID_Evento = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $evento_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $evento = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title><?php echo htmlspecialchars($evento['Título']); ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="css/estructura_fundamental.css">
    <link rel="stylesheet" href="css/evento.css">
    <link rel="stylesheet" href="css/comentarios.css">
    <link rel="stylesheet" href="css/catalogo.css">
</head>
<body>
    <?php include("header.php") ?>

    <!---Botón volver al catálogo--->
    <div style="padding: 0 20px;">
        <a href="Catálogo.php" class="boton-volver">← Volver al Catálogo</a>
    <?php
    // Verificar si el usuario puede editar el evento
    $puedeEditar = false;

    if ($usuario_logueado) {
        $usuario_actual = intval($_SESSION['ID_Cliente']);

        // Obtener la cédula del usuario actual si es organizador
        $usuarioCedula = null;
        $stmt_ced = $conn->prepare("SELECT Cedula FROM organizadores WHERE ID_Cliente = ? LIMIT 1");
        if ($stmt_ced) {
            $stmt_ced->bind_param('i', $usuario_actual);
            $stmt_ced->execute();
            $res_ced = $stmt_ced->get_result();
            if ($row_ced = $res_ced->fetch_assoc()) {
                $usuarioCedula = $row_ced['Cedula'];
            }
            $stmt_ced->close();
        }

        // Usar función del header para verificar admin
        $esAdminActual = esAdmin($conn);

        // Permitir editar si:
        // - la cédula del organizador logueado coincide con la cédula asociada al evento
        // - o si el usuario es administrador
        if ((!empty($evento['Cédula']) && $usuarioCedula !== null && $usuarioCedula === $evento['Cédula']) || $esAdminActual) {
            $puedeEditar = true;
        }
    }

    if ($puedeEditar) {
        echo '<a href="EditarEvento.php?id=' . intval($evento_id) . '" class="boton-editar">✎ Editar evento</a>';
    }
    ?>
    </div>

    <!---INFO DEL EVENTO--->
    <section class="evento-detalles">
        <div class="imag-evento">
            <img class="imagen" src="<?php echo htmlspecialchars($evento['imagen']); ?>" alt="<?php echo htmlspecialchars($evento['Título']); ?>">
        </div>
        <div class="detalles-evento">
            <h2><?php echo htmlspecialchars($evento['Título']); ?></h2>
            <p><strong>Fecha Inicio:</strong> <?php echo htmlspecialchars($evento['Fecha_Inicio']); ?></p>
            <p><strong>Fecha Final:</strong> <?php echo htmlspecialchars($evento['Fecha_Fin'] ?? $evento['Fecha_Inicio']); ?></p>
            <p><strong>Hora:</strong> <?php echo htmlspecialchars($evento['Hora']); ?></p>
            
            <?php
            // Mostrar ubicación (puede ser iframe o texto)
            if (isset($evento['Ubicacion']) && strpos($evento['Ubicacion'], '<iframe') !== false) {
                echo '<div><strong>Ubicación:</strong></div>';
                echo '<button class="ver-mapa" onclick="toggleMapaDetalle(this)">Ver mapa</button>';
                echo '<div class="mapa" style="display:none;">' . $evento['Ubicacion'] . '</div>';
            } else {
                echo '<p><strong>Lugar:</strong> ' . htmlspecialchars($evento['Ubicacion'] ?? 'Ubicación no especificada') . '</p>';
            }
            ?>
            
            <p><strong>Categoría:</strong> <?php echo htmlspecialchars($evento['categoria']); ?></p>
            <p><strong>Creador:</strong> <?php echo htmlspecialchars($evento['Nombre'] ?? 'Administrador'); ?></p>
            <p><strong>Descripción:</strong> <?php echo htmlspecialchars($evento['Descripción'] ?? '-.'); ?></p>
        </div>
    </section>

    <!---COMENTARIOS--->
    <main>
        <h1>Comentarios</h1>
        <hr class="linea">
        <div id="lista-comentarios" class="container-comentarios"></div>
    </main>

    <!---COMENTAR--->
    <div class="container-data">
        <?php if ($usuario_logueado && isset($datosUsuario)): ?>
            <div class="foto-input">
                <div class="perfil-foto"> 
                    <img src="<?php echo !empty($datosUsuario['imag_perfil']) ? htmlspecialchars($datosUsuario['imag_perfil']) : 'https://cdn-icons-png.flaticon.com/512/6378/6378141.png'; ?>" alt="Foto de perfil">
                </div>
                <span id="nombre-usuario"><?php echo htmlspecialchars($datosUsuario['Nombre']); ?></span>
            </div>

            <textarea id="texto-comentario" style="width:100%; border:1px solid #ccc; min-height:60px; padding:10px; margin-top:10px;"></textarea>
            <button id="btn-comentar" data-evento="<?php echo $evento_id; ?>">Enviar</button>

        <?php else: ?>
            <div style="text-align:center; padding: 20px;">
                <a href="login.php" style="text-decoration: none; color: black;">Inicia Sesión para poder comentar</a>
            </div>
        <?php endif; ?>
    </div>

    <?php include("footer.html") ?>

<script>
    function toggleMapaDetalle(btn) {
        const mapa = btn.nextElementSibling;
        if (mapa.style.display === "none" || mapa.style.display === "") {
            mapa.style.display = "block";
            btn.textContent = "Ocultar mapa";
        } else {
            mapa.style.display = "none";
            btn.textContent = "Ver mapa";
        }
    }

    function engancharLikes() {
        document.querySelectorAll('.cora').forEach(cora => {
            if (cora.classList.contains('disabled')) {
                cora.addEventListener('click', (e) => {
                    e.preventDefault();
                    alert('Debes iniciar sesión para dar like');
                });
                return;
            }

            cora.addEventListener('click', () => {
                const idComentario = cora.getAttribute('data-id');

                fetch('../backend/Comentarios/like.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: new URLSearchParams({ idComentario: idComentario })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.error) {
                        alert(data.error);
                        return;
                    }
                    cora.querySelector('.likes').textContent = data.likes;
                    cora.classList.toggle('liked', data.liked);
                })
                .catch(err => console.error(err));
            });
        });
    }

    function engancharLikesRespuestas() {
        document.querySelectorAll('.cora-respuesta').forEach(cora => {
            if (cora.classList.contains('disabled')) {
                cora.addEventListener('click', e => {
                    e.preventDefault();
                    alert('Debes iniciar sesión para dar like');
                });
                return;
            }
            cora.addEventListener('click', () => {
                const idRespuesta = cora.dataset.id;
                const liked = cora.classList.contains('liked');
                const action = liked ? 'dislike' : 'like';

                fetch('../backend/Comentarios/like_respuesta.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: new URLSearchParams({ idRespuesta, action })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.error) {
                        alert(data.error);
                        return;
                    }
                    cora.querySelector('.likes').textContent = data.likes;
                    cora.classList.toggle('liked', data.liked);
                })
                .catch(console.error);
            });
        });
    }

    function cargarComentarios() {
        fetch('../backend/Comentarios/listaCOM.php?id_evento=<?php echo $evento_id; ?>')
            .then(res => res.text())
            .then(html => {
                document.querySelector('#lista-comentarios').innerHTML = html;
                engancharLikes(); 
                engancharLikesRespuestas();  
            });
    }

    document.addEventListener('DOMContentLoaded', () => {
        cargarComentarios();

const btnComentar = document.getElementById("btn-comentar");
const textarea = document.getElementById("texto-comentario");
const errorDiv = document.createElement('div');
errorDiv.id = 'error-moderacion';
errorDiv.style.cssText = 'color: #d32f2f; font-size: 14px; margin-top: 8px; display: none; font-weight: 500;';
textarea.parentNode.insertBefore(errorDiv, textarea.nextSibling);

if (btnComentar) {
    btnComentar.addEventListener("click", async () => {
        const texto = textarea.value.trim();
        const id_evento = btnComentar.dataset.evento;
        if (texto === "") {
            alert("Por favor escribe un comentario.");
            return;
        }
        try {
            const response = await fetch('http://localhost:5000/moderacion', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({ texto: texto })
            });
            const data = await response.json();
            if (!data.aprobado) {
                textarea.style.border = '2px solid #d32f2f';
                textarea.style.boxShadow = '0 0 8px rgba(211, 47, 47, 0.3)';
                errorDiv.textContent = data.mensaje;
                errorDiv.style.display = 'block';
                setTimeout(() => {
                    textarea.style.border = '';
                    textarea.style.boxShadow = '';
                    errorDiv.style.display = 'none';
                }, 6000);
                return;
            }
            const phpResponse = await fetch(`../backend/Comentarios/Comentar.php?id_evento=${id_evento}`, {
                method: "POST",
                body: new URLSearchParams({ Texto: texto }),
                headers: { "Content-Type": "application/x-www-form-urlencoded" }
            });
            const phpData = await phpResponse.text();
            alert(phpData);
            textarea.value = "";
            cargarComentarios();
        } catch (err) {
            console.error("Error con IA:", err);
            alert("Error al conectar con la moderacion. Intenta más tarde.");
        }
    });
}
    });

    function mostrarFormularioRespuesta(idComentario) {
        <?php if ($usuario_logueado): ?>
            const formulario = document.getElementById(`form_respuesta_${idComentario}`);
            if(formulario.style.display === "block") {
                formulario.style.display = "none";
            } else {
                formulario.style.display = "block";
            }
        <?php else: ?>
            alert('Debes iniciar sesión para responder');
            window.location.href = 'login.php';
        <?php endif; ?>
    }

    function ocultarFormularioRespuesta(idComentario) {
        const formulario = document.getElementById(`form_respuesta_${idComentario}`);
        if (formulario) {
            formulario.style.display = 'none';
        }
    }

    function enviarRespuesta(idComentario) {
        const texto = document.getElementById(`texto_respuesta_${idComentario}`).value.trim();

        if (texto === "") {
            alert("Por favor escribe una respuesta.");
            return;
        }

        fetch('../backend/Comentarios/responder.php', {
            method: "POST",
            body: new URLSearchParams({
                id_comentario: idComentario,
                texto: texto
            }),
            headers: { "Content-Type": "application/x-www-form-urlencoded" }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                cargarComentarios();
                document.getElementById(`form_respuesta_${idComentario}`).style.display = 'none';
                document.getElementById(`texto_respuesta_${idComentario}`).value = '';
            } else {
                alert(data.message);
            }
        })
        .catch(err => console.error("Error:", err));
    }

    function toggleMenu(idComentario) {
        const menu = document.getElementById(`opciones_${idComentario}`);
        menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
    }

    function toggleMenuRes(idRespuesta) {
        const menu = document.getElementById(`opciones_res_${idRespuesta}`);
        menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
    }

    function mostrarEditor(idComentario, textoOriginal) {
        document.getElementById(`texto_comentario_${idComentario}`).style.display = 'none';
        document.getElementById(`editor_comentario_${idComentario}`).style.display = 'block';
        document.getElementById(`texto_edicion_${idComentario}`).value = textoOriginal;
        document.getElementById(`opciones_${idComentario}`).style.display = 'none';
    }

    function cancelarEdicionComentario(idComentario) {
        document.getElementById(`texto_comentario_${idComentario}`).style.display = 'block';
        document.getElementById(`editor_comentario_${idComentario}`).style.display = 'none';
    }

    function guardarEdicionComentario(idComentario) {
        const nuevoTexto = document.getElementById(`texto_edicion_${idComentario}`).value.trim();
        
        if (nuevoTexto === "") {
            alert("El comentario no puede estar vacío.");
            return;
        }
        
        fetch('../backend/Comentarios/editarcom.php', {
            method: "POST",
            body: new URLSearchParams({
                id: idComentario,
                texto: nuevoTexto
            }),
            headers: { "Content-Type": "application/x-www-form-urlencoded" }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById(`texto_comentario_${idComentario}`).querySelector('p').textContent = data.nuevoTexto;
                cancelarEdicionComentario(idComentario);
            } else {
                alert(data.message);
            }
        })
        .catch(err => console.error("Error:", err));
    }

    function eliminarComentario(idComentario) {
        if (!confirm("¿Estás seguro de que quieres eliminar este comentario?")) {
            return;
        }
        
        fetch('../backend/Comentarios/eliminarcom.php', {
            method: "POST",
            body: new URLSearchParams({
                id: idComentario
            }),
            headers: { "Content-Type": "application/x-www-form-urlencoded" }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById(`comentario_${idComentario}`).remove();
            } else {
                alert(data.message);
            }
        })
        .catch(err => console.error("Error:", err));
    }

    function mostrarEditorRes(idRespuesta, textoOriginal) {
        document.getElementById(`texto_respuesta_${idRespuesta}`).style.display = 'none';
        document.getElementById(`editor_respuesta_${idRespuesta}`).style.display = 'block';
        document.getElementById(`texto_edicion_res_${idRespuesta}`).value = textoOriginal;
        document.getElementById(`opciones_res_${idRespuesta}`).style.display = 'none';
    }

    function cancelarEdicionRespuesta(idRespuesta) {
        document.getElementById(`texto_respuesta_${idRespuesta}`).style.display = 'block';
        document.getElementById(`editor_respuesta_${idRespuesta}`).style.display = 'none';
    }

    function guardarEdicionRespuesta(idRespuesta) {
        const nuevoTexto = document.getElementById(`texto_edicion_res_${idRespuesta}`).value.trim();
        
        if (nuevoTexto === "") {
            alert("La respuesta no puede estar vacía.");
            return;
        }
        
        fetch('../backend/Comentarios/editarres.php', {
            method: "POST",
            body: new URLSearchParams({
                id: idRespuesta,
                texto: nuevoTexto
            }),
            headers: { "Content-Type": "application/x-www-form-urlencoded" }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById(`texto_respuesta_${idRespuesta}`).querySelector('p').textContent = data.nuevoTexto;
                cancelarEdicionRespuesta(idRespuesta);
            } else {
                alert(data.message);
            }
        })
        .catch(err => console.error("Error:", err));
    }

    function eliminarRespuesta(idRespuesta) {
        if (!confirm("¿Estás seguro de que quieres eliminar esta respuesta?")) {
            return;
        }
        
        fetch('../backend/Comentarios/eliminarres.php', {
            method: "POST",
            body: new URLSearchParams({
                id: idRespuesta
            }),
            headers: { "Content-Type": "application/x-www-form-urlencoded" }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById(`respuesta_${idRespuesta}`).remove();
            } else {
                alert(data.message);
            }
        })
        .catch(err => console.error("Error:", err));
    }
</script>

</body>
</html>

<?php
    } else {
        echo "Evento no encontrado.";
        $conn->close();
    }
    $stmt->close();    
} else {
    echo "ID de evento no válido.";
    $conn->close();
}
?>
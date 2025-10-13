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

// Obtener el ID del sitio desde la URL
$sitio_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$usuario_logueado = isset($_SESSION['ID_Cliente']);

if ($sitio_id > 0) {
    // Consultar el sitio específico
    $sql = "SELECT * FROM sitioturistico WHERE ID_Sitio = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $sitio_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $sitio = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title><?php echo htmlspecialchars($sitio['Titulo']); ?></title>
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
        <a href="../Frontend/sitios_turisticos.php" class="boton-volver">← Volver al Catálogo</a>
    </div>

    <!---INFO DEL SITIO TURÍSTICO--->
    <section class="evento-detalles">
        <div class="imag-evento">
            <img class="imagen" src="<?php echo htmlspecialchars($sitio['Imagen']); ?>" alt="<?php echo htmlspecialchars($sitio['Titulo']); ?>">
        </div>
        <div class="detalles-evento">
            <h2><?php echo htmlspecialchars($sitio['Titulo']); ?></h2>
            <p><strong>Estado:</strong> <?php echo htmlspecialchars($sitio['Estado']); ?></p>
            <p><strong>Horario:</strong> 
                <?php 
                if ($sitio['Hora_Inicio'] && $sitio['Hora_Fin']) {
                    echo htmlspecialchars($sitio['Hora_Inicio']) . ' - ' . htmlspecialchars($sitio['Hora_Fin']);
                } else {
                    echo 'Consultar horarios';
                }
                ?>
            </p>
            <p><strong>Ubicación:</strong> <?php echo ($sitio['Ubicacion'] ?? 'Ubicación no especificada'); ?></p>
            <p><strong>Categoría:</strong> <?php echo htmlspecialchars($sitio['Categoria']); ?></p>
            <p><strong>Teléfono:</strong> <?php echo htmlspecialchars($sitio['telefono'] ?? 'No disponible'); ?></p>
            <p><strong>Descripción:</strong> <?php echo nl2br(htmlspecialchars($sitio['Descripcion'] ?? 'Sin descripción disponible.')); ?></p>
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

            <textarea id="texto-comentario" style="width:100%; border:1px solid #ccc; min-height:60px; padding:10px; margin-top:10px;" placeholder="Escribe tu comentario sobre este sitio..."></textarea>
            <button id="btn-comentar" data-sitio="<?php echo $sitio_id; ?>">Enviar</button>

        <?php else: ?>
            <div style="text-align:center; padding: 20px;">
                <a href="login.php" style="text-decoration: none; color: black;">Inicia Sesión para poder comentar</a>
            </div>
        <?php endif; ?>
    </div>

    <?php include("footer.html") ?>

<script>
    // Enganchar likes a comentarios
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

    // Enganchar likes a respuestas
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

    // Cargar comentarios dinámicamente
    function cargarComentarios() {
        fetch('../backend/sitios/listaCOMSitio.php?sitio_id=<?php echo $sitio_id; ?>')
            .then(res => res.text())
            .then(html => {
                document.querySelector('#lista-comentarios').innerHTML = html;
                engancharLikes(); 
                engancharLikesRespuestas();  
            });
    }

    document.addEventListener('DOMContentLoaded', () => {
        cargarComentarios();

        // Enviar comentario
        const btnComentar = document.getElementById("btn-comentar");
        if (btnComentar) {
            btnComentar.addEventListener("click", () => {
                const texto = document.getElementById("texto-comentario").value.trim();
                const sitio_id = btnComentar.dataset.sitio;

                if (texto === "") {
                    alert('Por favor escribe un comentario');
                    return;
                }

                fetch(`../backend/sitios/comentarSitio.php?sitio_id=${sitio_id}`, {
                    method: "POST",
                    body: new URLSearchParams({ Texto: texto }),
                    headers: { "Content-Type": "application/x-www-form-urlencoded" }
                })
                .then(response => response.text())
                .then(data => {
                    alert(data);
                    document.getElementById("texto-comentario").value = "";
                    cargarComentarios();
                })
                .catch(err => console.error("Error:", err));
            });
        }
    });

    // Mostrar formulario de respuesta
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

    // Ocultar formulario de respuesta
    function ocultarFormularioRespuesta(idComentario) {
        const formulario = document.getElementById(`form_respuesta_${idComentario}`);
        if (formulario) {
            formulario.style.display = 'none';
        }
    }

    // Enviar respuesta
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

    // Alternar menú de comentarios
    function toggleMenu(idComentario) {
        const menu = document.getElementById(`opciones_${idComentario}`);
        menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
    }

    // Alternar menú de respuestas
    function toggleMenuRes(idRespuesta) {
        const menu = document.getElementById(`opciones_res_${idRespuesta}`);
        menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
    }

    // Mostrar editor de comentario
    function mostrarEditor(idComentario, textoOriginal) {
        document.getElementById(`texto_comentario_${idComentario}`).style.display = 'none';
        document.getElementById(`editor_comentario_${idComentario}`).style.display = 'block';
        document.getElementById(`texto_edicion_${idComentario}`).value = textoOriginal;
        document.getElementById(`opciones_${idComentario}`).style.display = 'none';
    }

    // Cancelar edición de comentario
    function cancelarEdicionComentario(idComentario) {
        document.getElementById(`texto_comentario_${idComentario}`).style.display = 'block';
        document.getElementById(`editor_comentario_${idComentario}`).style.display = 'none';
    }

    // Guardar edición de comentario
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

    // Eliminar comentario
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

    // Mostrar editor de respuesta
    function mostrarEditorRes(idRespuesta, textoOriginal) {
        document.getElementById(`texto_respuesta_${idRespuesta}`).style.display = 'none';
        document.getElementById(`editor_respuesta_${idRespuesta}`).style.display = 'block';
        document.getElementById(`texto_edicion_res_${idRespuesta}`).value = textoOriginal;
        document.getElementById(`opciones_res_${idRespuesta}`).style.display = 'none';
    }

    // Cancelar edición de respuesta
    function cancelarEdicionRespuesta(idRespuesta) {
        document.getElementById(`texto_respuesta_${idRespuesta}`).style.display = 'block';
        document.getElementById(`editor_respuesta_${idRespuesta}`).style.display = 'none';
    }

    // Guardar edición de respuesta
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

    // Eliminar respuesta
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
        echo "Sitio no encontrado.";
        $conn->close();
    }
    $stmt->close();    
} else {
    echo "ID de sitio no válido.";
    $conn->close();
}
?>  
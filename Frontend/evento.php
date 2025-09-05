<?php
include('../backend/Conexion.php');

session_start();

// Obtener el ID del evento desde la URL
$evento_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$usuario_logueado = isset($_SESSION['ID_Cliente']);

if ($evento_id > 0) {
    // Consultar el evento específico
    $sql = "SELECT * FROM eventos WHERE ID_Evento = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $evento_id);
    $stmt->execute();
    $result = $stmt->get_result(); // Si se encuentra el evento, mostrar los detalles

    if ($result->num_rows > 0) { // Asegurarse de que el evento existe
        $evento = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title><?php echo htmlspecialchars($evento['Título']); ?></title>
    <link rel="stylesheet" href="evento.css">
    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="comentarios.css">
    <link rel="stylesheet" href="catalogo.css">

</head>
<body>
        <?php include("header.php") ?>

    <!---Botonazo pal catalaogo--->
    <div style="padding: 0 20px;">
        <a href="../Frontend/Catálogo.php" class="boton-volver">← Volver al Catálogo</a>
    </div>

    <!---INFO--->
    <section class="evento-detalles">
        <div class="imag-evento">
                <img class="imagen" src="<?php echo htmlspecialchars($evento['imagen']); ?>" alt="<?php echo htmlspecialchars($evento['Título']); ?>">
        </div>
        <div class="detalles-evento">
            <h2><?php echo htmlspecialchars($evento['Título']); ?></h2>
            <p><strong>Fecha Inicio:</strong> <?php echo htmlspecialchars($evento['Fecha_Inicio']); ?></p>
            <p><strong>Fecha Final:</strong> <?php echo htmlspecialchars($evento['Fecha_Final'] ?? $evento['Fecha_Inicio']); ?></p>
            <p><strong>Hora:</strong> <?php echo htmlspecialchars($evento['Hora']); ?></p>
            <p><strong>Lugar:</strong> <?php echo htmlspecialchars($evento['Lugar'] ?? 'Ubicación no especificada'); ?></p>
            <p><strong>Categoría:</strong> <?php echo htmlspecialchars($evento['categoria']); ?></p>
            <p><strong>Creador:</strong> <?php echo htmlspecialchars($evento['creador'] ?? 'Administrador'); ?></p>
            <p><strong>Descripción:</strong> <?php echo htmlspecialchars($evento['Descripción'] ?? '-.'); ?></p>
        </div>
    </section>





    <!---COMENTARIOS (boceto)--->
    <main>
        <h1>Comentarios</h1>
        <hr class="linea">
        
        <!-- Aquí irían los comentarios dinámicos (x cada evento) -->
        <div class="container-comentarios">
            
        </div>
    </main>

    <!--COMENTAR-->
    <div class="container-data">        
    <?php if ($usuarioLogueado && $datosUsuario): ?>
        <div class="foto-input">
            <div class="perfil-foto">
                <img id="img-perfil-usuario" src="https://cdn-icons-png.flaticon.com/512/6378/6378141.png" alt="Perfil">
            </div>
            <span id="nombre-usuario">Usuario</span>
        </div>

        <div class="formato-toolbar">
            <button type="button" class="formato-btn" data-comando="bold"><b>B</b></button>
            <button type="button" class="formato-btn" data-comando="italic"><i>I</i></button>
            <button type="button" class="formato-btn" data-comando="underline"><u>U</u></button>
        </div>

        <div class="mensaje" contenteditable="true" style="border:1px solid #ccc; min-height:60px; padding:10px; margin-top:10px;"></div>
        <button class="btn-comentar">Enviar</button>
        </div>
    <?php else: ?>
        <div style="text-align : center; padding: 20px;">
        <a href="Inicio_sesion.html" style="text-decoration: none; color: black;">Inicia Sesión para poder comentar</a>
        </div>
    <?php endif; ?>
    </div>
    



    <?php include("footer.html") ?>

  <script>
// Variable global para estado de login
const usuarioLogueado = <?php echo $usuario_logueado ? 'true' : 'false'; ?>;

function engancharLikes() {
    document.querySelectorAll('.cora').forEach(cora => {
        // Si no está logueado, prevenir acción de like
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

function cargarComentarios() {
    fetch('../backend/Comentarios/listaCOM.php?id_evento=<?php echo $evento_id; ?>')
        .then(res => res.text())
        .then(html => {
            document.querySelector('.container-comentarios').innerHTML = html;
            engancharLikes();
        });
}

document.addEventListener('DOMContentLoaded', cargarComentarios);

// Formato de texto
document.querySelectorAll('.formato-btn').forEach(boton => {
    boton.addEventListener('click', () => {
        const comando = boton.getAttribute('data-comando');
        document.execCommand(comando, false, null);
    });
});

    
       /* //LIKES antiguo (localStorage)
        document.querySelectorAll('.cora').forEach((btnCorazon, indice) => {
            const idComentario = 'comentario_' + indice;
            const claveLikes = 'likes_' + idComentario;
            const claveLikeado = 'likeado_' + idComentario;
            const divLikes = btnCorazon.querySelector('.likes');
            let cantidadLikes = parseInt(localStorage.getItem(claveLikes)) || 0;
            let likeado = localStorage.getItem(claveLikeado) === '1';

            divLikes.textContent = cantidadLikes;
            if (likeado) btnCorazon.classList.add('liked');

            btnCorazon.onclick = () => {
                likeado = !likeado;
                btnCorazon.classList.toggle('liked', likeado);
                cantidadLikes += likeado ? 1 : -1;
                divLikes.textContent = cantidadLikes;
                localStorage.setItem(claveLikes, cantidadLikes);
                localStorage.setItem(claveLikeado, likeado ? '1' : '');
            };
        });*/


        //opciones de formato italicas, negritas, subrayado
        document.querySelectorAll('.formato-btn').forEach(boton => {
            boton.addEventListener('click', () => {
                const comando = boton.getAttribute('data-comando');
                document.execCommand(comando, false, null);
            });
        });

        document.querySelectorAll('.btn-comentar').forEach(boton => {
        boton.addEventListener('click', () => {
                fetch('../backend/Comentarios/Comentar.php?id_evento=<?php echo $evento_id; ?>')
            })
        })


        
    </script>
   
</body>
</html>
<?php

// Si no se encuentra el evento mostrar...
    } else {
        echo "Evento no encontrado.";
    }
    $stmt->close();    
} else {
    try {
        // Aquí va tu lógica de código que podría lanzar una excepción
        echo "ID de evento no válido.";
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    } finally {
        // Asegurándote de cerrar la conexión, sin importar si hubo un error o no
        $conn->close();
    }
}
?>
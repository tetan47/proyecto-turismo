<?php
include('../backend/Conexion.php');

// Obtener el ID del evento desde la URL
$evento_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

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
            <div class="comentarios">
                <div class="foto-perfil">
                    <img src="https://cdn-icons-png.flaticon.com/512/6378/6378141.png">
                </div>
                <div class="info-comentarios">
                    <div class="header">
                        <h3>José Torres</h3>
                        <h4>18/08/25</h4>
                    </div>
                    <p><strong>Creador:</strong> <?php echo htmlspecialchars($comentario['texto']); ?></p>
                    <div class="footer-comentarios">
                        <h4 class="responder">Responder</h4>
                        <label class="cora">
                            &#10084;
                            <div class="likes" value="0">0</div>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!--COMENTAR-->
    <div class="container-data">
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

    <?php include("footer.html") ?>

    <script>    
        //LIKES
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
        });
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
    echo "ID de evento no válido.";
    
    $conn->close();
}
?>
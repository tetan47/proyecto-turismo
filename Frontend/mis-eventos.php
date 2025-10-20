<?php
// Iniciar sesión
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include('../backend/Conexion.php');

// Verificar si está logueado
if (!isset($_SESSION['ID_Cliente']) || $_SESSION['logueado'] !== true) {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION['ID_Cliente'];

// ========== OBTENER LA CÉDULA DEL ORGANIZADOR ==========
$sql_cedula = "SELECT Cedula FROM organizadores WHERE ID_Cliente = ?";
$stmt_cedula = $conn->prepare($sql_cedula);
$stmt_cedula->bind_param('i', $usuario_id);
$stmt_cedula->execute();
$resultado_cedula = $stmt_cedula->get_result();

if ($resultado_cedula->num_rows === 0) {
    echo "<p>No eres un organizador registrado.</p>";
    $stmt_cedula->close();
    exit();
}

$cedula = $resultado_cedula->fetch_assoc()['Cedula'];
$stmt_cedula->close();

// ========== OBTENER LOS EVENTOS DEL ORGANIZADOR ==========
$sql_eventos = "SELECT * FROM eventos WHERE Cédula = ? ORDER BY Creacion_Evento DESC";
$stmt_eventos = $conn->prepare($sql_eventos);
$stmt_eventos->bind_param('s', $cedula);
$stmt_eventos->execute();
$resultado_eventos = $stmt_eventos->get_result();

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Eventos</title>
    <link rel="stylesheet" href="css/estructura_fundamental.css">
    <link rel="stylesheet" href="css/catalogo.css">
</head>

<body>
    <?php include("header.php"); ?>

    <section class="contenedormiseventos">
        <h1>Mis Eventos</h1>
    <?php
    if ($resultado_eventos->num_rows > 0) {
        echo "<p><strong>Total de eventos: {$resultado_eventos->num_rows}</strong></p>";

        while ($evento = $resultado_eventos->fetch_assoc()) {
            echo '<div class="evento">';
            echo '<div class="img-evento">';
            echo '<img src="' . htmlspecialchars($evento['imagen']) . '" alt="Imagen Evento" />';
            echo '</div>';
            echo '<div class="info-evento">';
            echo '<h3>' . htmlspecialchars($evento['Título']) . '</h3>';
            echo '<p>' . htmlspecialchars($evento['Fecha_Inicio']) . ' - ' . htmlspecialchars($evento['Hora']) . '</p>';
            echo '<p>' . htmlspecialchars($evento['categoria']) . '</p>';
            echo '<a href="evento.php?id=' . urlencode($evento['ID_Evento']) . '" class="boton-ver-detalles">Ver Detalles</a>';
            echo '</div>';
            echo '</div>';
        }

    }else {
        echo "<p style='text-align: center; color: #999;'>No tienes eventos publicados aún.</p>";
        echo "<a href='crear_eventos.php' style='display: inline-block; margin-top: 20px; padding: 10px 20px; background: #007bff; color: white; text-decoration: none; border-radius: 4px;'>Crear primer evento</a>";
    }

        $stmt_eventos->close();
    ?>
    </section>
        <?php
        include("footer.html");
        ?>
    
</body>

</html>
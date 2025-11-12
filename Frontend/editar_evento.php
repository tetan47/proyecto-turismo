<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../backend/Conexion.php';

// Verificar admin
$isAdmin = false;
if (isset($_SESSION['correo'])) {
    $stmt = mysqli_prepare($conn, "SELECT ID_Administrador FROM administradores WHERE Correo = ?");
    mysqli_stmt_bind_param($stmt, 's', $_SESSION['correo']);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    $isAdmin = mysqli_stmt_num_rows($stmt) > 0;
    mysqli_stmt_close($stmt);
}
if (!$isAdmin) {
    header('Location: login.php');
    exit;
}

// Obtener id
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: Panel_de_administracion.php');
    exit;
}
$id = (int) $_GET['id'];

// Obtener evento
$stmt = mysqli_prepare($conn, "SELECT ID_Evento, `Título`, Descripción, Fecha_Inicio, Fecha_Fin, Ubicacion, Capacidad, Hora, imagen, categoria FROM eventos WHERE ID_Evento = ?");
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $ID_Evento, $Titulo, $Descripcion, $Fecha_Inicio, $Fecha_Fin, $Ubicacion, $Capacidad, $Hora, $imagen, $categoria);
$found = mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

if (!$found) {
    header('Location: Panel_de_administracion.php?error=no_encontrado');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Editar evento</title>
    <link rel="stylesheet" href="css/estructura_fundamental.css">
    <style>
        .form-container { max-width: 800px; margin: 20px auto; padding: 20px; background: #fff; border-radius: 6px; }
        label { display: block; margin: 10px 0 5px; font-weight: bold; }
        input, textarea, select { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; margin-bottom: 10px; }
        .btn { padding: 10px 15px; border-radius: 4px; cursor: pointer; border: none; margin-right: 10px; }
        .btn-save { background: #28a745; color: #fff; }
        .btn-cancel { background: #6c757d; color: #fff; text-decoration: none; }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>

    <main class="form-container">
        <h1>Editar evento #<?php echo htmlspecialchars($ID_Evento ?? ''); ?></h1>

        <form method="post" action="../backend/eventos/editar_evento.php">
            <input type="hidden" name="ID_Evento" value="<?php echo (int)$ID_Evento; ?>">

            <label>Título</label>
            <input type="text" name="Titulo" value="<?php echo htmlspecialchars($Titulo ?? ''); ?>" required>

            <label>Descripción</label>
            <textarea name="Descripcion" rows="5" required><?php echo htmlspecialchars($Descripcion ?? ''); ?></textarea>

            <label>Fecha inicio</label>
            <input type="date" name="Fecha_Inicio" value="<?php echo htmlspecialchars($Fecha_Inicio ?? ''); ?>" required>

            <label>Fecha fin</label>
            <input type="date" name="Fecha_Fin" value="<?php echo htmlspecialchars($Fecha_Fin ?? ''); ?>">

            <label>Hora</label>
            <input type="time" name="Hora" value="<?php echo htmlspecialchars($Hora ?? ''); ?>">

            <label>Ubicación</label>
            <input type="text" name="Ubicacion" value="<?php echo htmlspecialchars($Ubicacion ?? ''); ?>">

            <label>Capacidad</label>
            <input type="number" name="Capacidad" value="<?php echo htmlspecialchars($Capacidad ?? '0'); ?>">

            <label>Categoría</label>
            <input type="text" name="categoria" value="<?php echo htmlspecialchars($categoria ?? ''); ?>">

            <label>Imagen (URL)</label>
            <input type="text" name="imagen" value="<?php echo htmlspecialchars($imagen ?? ''); ?>">

            <div>
                <button class="btn btn-save" type="submit">Guardar cambios</button>
                <a class="btn btn-cancel" href="Panel_de_administracion.php">Cancelar</a>
            </div>
        </form>
    </main>

    <?php include 'footer.html'; ?>
</body>
</html>
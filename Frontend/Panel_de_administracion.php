<?php
// Iniciar sesión
if (session_status() === PHP_SESSION_NONE) session_start();

// Conexión
require_once __DIR__ . '/../backend/Conexion.php';

// Incluir header PRIMERO (define esAdmin())
include 'header.php';

// Verificar permisos usando la función del header
if (!esAdmin($conn)) {
    header('Location: login.php');
    exit;
}

// ========== OBTENER EVENTOS ==========
$eventos = [];
$sqlEv = "SELECT ID_Evento, `Título`, Fecha_Inicio, Ubicacion FROM eventos ORDER BY Fecha_Inicio DESC";
$resEv = mysqli_query($conn, $sqlEv);
if ($resEv) {
    while ($r = mysqli_fetch_assoc($resEv)) $eventos[] = $r;
    mysqli_free_result($resEv);
}

// ========== OBTENER USUARIOS ==========
$usuarios = [];
$sqlUs = "SELECT ID_Cliente, Nombre, Apellido, Correo FROM cliente ORDER BY Nombre ASC";
$resUs = mysqli_query($conn, $sqlUs);
if ($resUs) {
    while ($r = mysqli_fetch_assoc($resUs)) $usuarios[] = $r;
    mysqli_free_result($resUs);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Panel de Administración</title>
    <link rel="stylesheet" href="css/estructura_fundamental.css">
    <link rel="stylesheet" href="css/header.css">
    <style>
        .admin-container{max-width:1100px;margin:20px auto;padding:10px}
        table{width:100%;border-collapse:collapse;margin-bottom:18px}
        th,td{padding:8px;border:1px solid #ddd;text-align:left}
        th{background:#007bff;color:#fff}
        .btn{padding:6px 10px;border-radius:4px;text-decoration:none;color:#fff;font-size:13px}
        .btn-edit{background:#f0ad4e}
        .btn-delete{background:#d9534f}
        .btn-create{background:#28a745;padding:8px 12px;display:inline-block;margin-bottom:10px}
    </style>
</head>
<body>
    <main class="admin-container">
        <h1>Panel de Administración</h1>

        <section>
            <h2>Eventos</h2>
            <a class="btn-create" href="Crear_eventos.php">Crear evento</a>
            <table>
                <thead>
                    <tr><th>ID</th><th>Título</th><th>Fecha inicio</th><th>Ubicación</th><th>Acciones</th></tr>
                </thead>
                <tbody>
                    <?php if (empty($eventos)): ?>
                        <tr><td colspan="5">No hay eventos.</td></tr>
                    <?php else: foreach ($eventos as $ev): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($ev['ID_Evento']); ?></td>
                            <td><?php echo htmlspecialchars($ev['Título'] ?? $ev['Titulo'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($ev['Fecha_Inicio'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($ev['Ubicacion'] ?? ''); ?></td>
                            <td>
                                <a class="btn btn-edit" href="editar_evento.php?id=<?php echo urlencode($ev['ID_Evento']); ?>">Editar</a>
                                <a class="btn btn-delete" href="javascript:void(0)" onclick="confirmarEliminar('evento', <?php echo (int)$ev['ID_Evento']; ?>)">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; endif; ?>
                </tbody>
            </table>
        </section>

        <section>
            <h2>Usuarios</h2>
            <table>
                <thead>
                    <tr><th>ID</th><th>Nombre</th><th>Apellido</th><th>Correo</th><th>Acciones</th></tr>
                </thead>
                <tbody>
                    <?php if (empty($usuarios)): ?>
                        <tr><td colspan="5">No hay usuarios.</td></tr>
                    <?php else: foreach ($usuarios as $u): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($u['ID_Cliente']); ?></td>
                            <td><?php echo htmlspecialchars($u['Nombre']); ?></td>
                            <td><?php echo htmlspecialchars($u['Apellido']); ?></td>
                            <td><?php echo htmlspecialchars($u['Correo']); ?></td>
                            <td>
                                <a class="btn btn-edit" href="../backend/Usuarios/Editar.php?id=<?php echo urlencode($u['ID_Cliente']); ?>">Editar</a>
                                <a class="btn btn-delete" href="javascript:void(0)" onclick="confirmarEliminar('usuario', <?php echo (int)$u['ID_Cliente']; ?>)">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; endif; ?>
                </tbody>
            </table>
        </section>
    </main>

    <?php include 'footer.html'; ?>

    <script>
        function confirmarEliminar(tipo, id){
            if (!confirm('¿Eliminar ' + tipo + '?')) return;
            if (tipo === 'evento') {
                window.location.href = '../backend/eventos/eliminar_evento.php?id=' + encodeURIComponent(id);
            } else if (tipo === 'usuario') {
                window.location.href = '../backend/Usuarios/eliminar.php?id=' + encodeURIComponent(id);
            }
        }
    </script>
</body>
</html>
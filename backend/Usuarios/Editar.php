<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../Conexion.php';

// obtener id
$id = null;
if (isset($_GET['id'])) $id = $_GET['id'];
elseif (isset($_GET['ID_Cliente'])) $id = $_GET['ID_Cliente'];
elseif (isset($_POST['ID_Cliente'])) $id = $_POST['ID_Cliente'];

if (!$id || !is_numeric($id)) {
    header('Location: ../../Frontend/Panel_de_administracion.php');
    exit;
}
$id = (int) $id;

// Si es POST => actualizar usuario (solo nombre y apellido)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['Nombre'] ?? '');
    $apellido = trim($_POST['Apellido'] ?? '');

    if ($nombre === '' || $apellido === '') {
        $error = 'Faltan campos requeridos.';
    } else {
        // Solo actualizar Nombre y Apellido (NO correo ni contraseña)
        $stmt = mysqli_prepare($conn, "UPDATE cliente SET Nombre = ?, Apellido = ? WHERE ID_Cliente = ?");
        mysqli_stmt_bind_param($stmt, 'ssi', $nombre, $apellido, $id);
        $ok = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        mysqli_close($conn);

        header('Location: ../../Frontend/Panel_de_administracion.php' . ($ok ? '?user_updated=1' : '?user_updated=0'));
        exit;
    }
}

// Si es GET => cargar datos
$stmt = mysqli_prepare($conn, "SELECT ID_Cliente, Nombre, Apellido, Correo, Contraseña FROM cliente WHERE ID_Cliente = ? LIMIT 1");
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $ID_Cliente, $Nombre, $Apellido, $Correo, $Contraseña);
$found = mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

if (!$found) {
    mysqli_close($conn);
    header('Location: ../../Frontend/Panel_de_administracion.php?user_not_found=1');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Editar usuario</title>
    <link rel="stylesheet" href="../../Frontend/css/estructura_fundamental.css">
    <style>
        .edit-container { max-width: 600px; margin: 30px auto; padding: 20px; background: #f9f9f9; border-radius: 8px; }
        h1 { color: #333; margin-bottom: 20px; }
        label { display: block; margin: 12px 0 4px; font-weight: bold; }
        input { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; margin-bottom: 12px; }
        input:disabled { background: #e9ecef; cursor: not-allowed; }
        .actions { margin-top: 20px; }
        button { padding: 10px 15px; background: #28a745; color: #fff; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; }
        button:hover { background: #218838; }
        a { margin-left: 10px; padding: 10px 15px; background: #6c757d; color: #fff; text-decoration: none; border-radius: 4px; display: inline-block; }
        a:hover { background: #5a6268; }
        .error { color: #d9534f; margin-bottom: 15px; font-weight: bold; }
        .info { background:#d1ecf1;border:1px solid #bee5eb;padding:10px;border-radius:4px;margin-bottom:15px;color:#0c5460; }
    </style>
</head>
<body>
    <main class="edit-container">
        <h1>Editar usuario #<?php echo htmlspecialchars($ID_Cliente ?? 'N/A'); ?></h1>

        <?php if (!empty($error)): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <div class="info">
            <strong>ℹ️ Nota:</strong> Solo se pueden editar nombre y apellido. Correo y contraseña son datos sensibles que no pueden ser modificados por administradores.
        </div>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . '?id=' . (int)($ID_Cliente ?? 0); ?>">
            <input type="hidden" name="ID_Cliente" value="<?php echo (int)($ID_Cliente ?? 0); ?>">
            
            <label>Nombre</label>
            <input type="text" name="Nombre" value="<?php echo htmlspecialchars($Nombre ?? ''); ?>" required>
            
            <label>Apellido</label>
            <input type="text" name="Apellido" value="<?php echo htmlspecialchars($Apellido ?? ''); ?>" required>
            
            <label>Correo (Solo lectura)</label>
            <input type="email" name="Correo" value="<?php echo htmlspecialchars($Correo ?? ''); ?>" disabled>
            
            <label>Contraseña (Solo lectura)</label>
            <input type="password" name="Contraseña" value="<?php echo htmlspecialchars($Contraseña ?? ''); ?>" disabled>

            <div class="actions">
                <button type="submit">Guardar cambios</button>
                <a href="../../Frontend/Panel_de_administracion.php">Volver al panel</a>
            </div>
        </form>
    </main>
</body>
</html>
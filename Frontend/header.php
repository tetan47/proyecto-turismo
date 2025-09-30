<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


require_once '../backend/Conexion.php';


$usuarioLogueado = false;
$rol = null; 
$nombre = '';
$imagenPerfil = 'https://cdn-icons-png.flaticon.com/512/6378/6378141.png';
$datosCargados = false;

// Verificar si hay sesión activa
if (!empty($_SESSION['usuario_id']) && !empty($_SESSION['rol'])) {
    $usuarioLogueado = true;
    $rol = $_SESSION['rol'];
    $nombre = $_SESSION['nombre'] ?? 'Usuario';

    
    if ($rol === 'cliente' || $rol === 'organizador') {
        $stmt = $conn->prepare("SELECT imag_perfil FROM cliente WHERE ID_Cliente = ?");
        $stmt->bind_param('i', $_SESSION['usuario_id']);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($fila = $result->fetch_assoc()) {
            if (!empty($fila['imag_perfil'])) {
                $imagenPerfil = $fila['imag_perfil'];
            }
        }
        // Por ahora, usamos la imagen por defecto o la guardada en sesión
        if (!empty($_SESSION['foto'])) {
            $imagenPerfil = $_SESSION['foto'];
        }
    } elseif ($rol === 'admin') {
        // Admin: no tiene imagen en cliente, usar ícono por defecto
        $imagenPerfil = 'https://cdn-icons-png.flaticon.com/512/6378/6378141.png';
    }

    $datosCargados = true;
}
?>

<link rel="stylesheet" href="css/header.css">

<header>
    <div class="logo">
        <a href="Index.php">
            <img id="logo123" src="../Images/Logo-que-viaje.png" alt="Inicio">
        </a>
    </div>

    <div class="selector-idioma">
                <form method="GET" style="display:inline;">
                    <select name="lang" onchange="this.form.submit()" style="font-size:14px;">
                        <option value="es" <?php echo (!isset($_GET['lang']) || $_GET['lang'] === 'es') ? 'selected' : ''; ?>>ES</option>
                        <option value="en" <?php echo (isset($_GET['lang']) && $_GET['lang'] === 'en') ? 'selected' : ''; ?>>EN</option>
                        <option value="pt" <?php echo (isset($_GET['lang']) && $_GET['lang'] === 'pt') ? 'selected' : ''; ?>>PT</option>
                    </select>
                </form>
            </div> 
    
    <div class="perfil">
        <?php if ($usuarioLogueado && $datosCargados): ?>
            <div class="espacioimg">
                <img src="<?php echo htmlspecialchars($imagenPerfil); ?>" 
                     alt="Perfil de <?php echo htmlspecialchars($nombre); ?>">
            </div>
            <p><?php echo htmlspecialchars($nombre); ?></p>

            
            <div class="container-menu">
                <button class="menu-btn">&#9776;</button>
                <div class="menu">
                    <?php if ($rol === 'organizador'): ?>   
                        <a href="Crear_eventos.php">Mis Eventos</a>
                        <a href="Crear_eventos.php">Crear Evento</a>
                    <?php elseif ($rol === 'admin'): ?>
                        <a href="Administradores.php">Panel de Administración</a>
                        <a href="gestionar-usuarios.php">Gestionar Usuarios</a>
                        <a href="gestionar-eventos.php">Gestionar Eventos</a>
                    <?php else: // cliente ?>
                        <a href="convertirse-organizador.php">Convertirse en Organizador</a>
                    <?php endif; ?>
                    
                    <a href="perfil.php">👤 Mi Perfil</a>
                    <a href="configuracion.php">Configuración</a>
                    <button type="button" class="btn-cerrar" onclick="cerrarSesion()">Cerrar Sesión</button>
                </div>    
            </div>
        <?php else: ?>
            <div class="container-menu">
                <a class="btn-inicio-sesion" href="login.php">Iniciar Sesión</a>
                <a class="btn-registrarse" href="register.php">Registrarse</a>
            </div>
        <?php endif; ?>
    </div>
</header>

<script>
    document.querySelector('.menu-btn').addEventListener('click', function() {
        const menu = document.querySelector(".menu"); 
        menu.style.display = menu.style.display === "block" ? "none" : "block";
    });

    function cerrarSesion() {
        if (confirm("¿Estás seguro de que deseas cerrar sesión?")) {
            window.location.href = '../backend/Usuarios/cerrar_sesion.php';
        }
    } 
</script>
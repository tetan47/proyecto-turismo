<?php
// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include('../backend/Conexion.php');

// ========== FUNCIONES DE VERIFICACIÓN ==========

function esUsuario() {
    return isset($_SESSION['ID_Cliente']) && isset($_SESSION['logueado']) && $_SESSION['logueado'] === true;
}

function esOrganizador($conn) {
    if (!esUsuario()) return false;
    
    $stmt = $conn->prepare("SELECT Cedula FROM organizadores WHERE ID_Cliente = ? AND Aprobado = 1");
    $stmt->bind_param('i', $_SESSION['ID_Cliente']);
    $stmt->execute();
    $result = $stmt->get_result()->num_rows > 0;
    $stmt->close();
    return $result;
}

function esAdmin($conn) {
    if (!esUsuario()) return false;
    
    // Buscar si el correo del usuario está en la tabla administradores
    $stmt = $conn->prepare("SELECT ID_Administrador FROM administradores WHERE Correo = ?");
    $stmt->bind_param('s', $_SESSION['correo']);
    $stmt->execute();
    $result = $stmt->get_result()->num_rows > 0;
    $stmt->close();
    return $result;
}

function obtenerDatosUsuario($conn) {
    if (!esUsuario()) return null;
    
    $stmt = $conn->prepare("SELECT Nombre, Apellido, imag_perfil FROM cliente WHERE ID_Cliente = ?");
    $stmt->bind_param('i', $_SESSION['ID_Cliente']);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    return $result;
}

// ========== OBTENER DATOS ==========
$usuarioLogueado = esUsuario();
$datosUsuario = $usuarioLogueado ? obtenerDatosUsuario($conn) : null;
$esOrganizador = $usuarioLogueado ? esOrganizador($conn) : false;
$esAdmin = $usuarioLogueado ? esAdmin($conn) : false;

// NO cerrar conexión aquí porque otras páginas la necesitan
?>

<link rel="stylesheet" href="css/estructura_fundamental.css">
<link rel="stylesheet" href="css/header.css">
<header>
    <link rel="icon" href="../Images/logo-queviaje.png">
    <div class="logo-queviaje">
        <a href="Index.php">
        <h1>¡QUE <span>VIAJE!</span></h1>
        <p>LO QUE PASA EN <span>SALTO</span>, PASA ACÁ.</p>
        </a>
    </div>
    
    <div class="perfil">
        <?php if ($usuarioLogueado && $datosUsuario): ?>
            <!-- Usuario logueado -->
            <div class="espacioimg">
                <img src="<?php echo !empty($datosUsuario['imag_perfil']) ? htmlspecialchars($datosUsuario['imag_perfil']) : 'https://cdn-icons-png.flaticon.com/512/6378/6378141.png'; ?>" 
                     alt="Perfil de <?php echo htmlspecialchars($datosUsuario['Nombre']); ?>"> 
            </div>
            <p><?php echo htmlspecialchars($datosUsuario['Nombre']); ?></p>
            
            <div class="container-menu">
                <button class="menu-btn" aria-label="Abrir menú">&#9776;</button>
                <div class="menu" style="display: none;">
                    
                    <?php if ($esAdmin): ?>
                        <!-- Opciones de ADMINISTRADOR -->
                        <a href="panel-administracion.php">🛡️ Panel de Administración</a>
                        <a href="gestionar-usuarios.php">👥 Gestionar Usuarios</a>
                        <a href="gestionar-eventos.php">📅 Gestionar Eventos</a>
                        
                    <?php elseif ($esOrganizador): ?>
                        <!-- Opciones de ORGANIZADOR -->
                        <a href="mis-eventos.php">📅 Mis Eventos</a>
                        <a href="crear_eventos.php">➕ Crear Evento</a>
                        
                    <?php else: ?>
                        <!-- Opciones de USUARIO COMÚN -->
                        <a href="convertirse_organizador.php">⭐ Convertirse en Organizador</a>
                    <?php endif; ?>
                    
                    <!-- Opciones comunes para todos los usuarios logueados -->
                    <hr style="margin: 10px 0; border: none; border-top: 1px solid #ccc;">
                    <a href="configuracion.php?tab=perfil">👤 Mi Perfil</a>
                    <a href="configuracion.php?tab=cuenta">⚙️ Configuración</a>
                    <button type="button" class="btn-cerrar" onclick="cerrarSesion()">🚪 Cerrar Sesión</button>
                </div>    
            </div>
            
        <?php else: ?>
            <!-- Usuario ANÓNIMO (no logueado) -->
            <div class="container-menu">
                <a class="btn-inicio-sesion" href="login.php">Iniciar Sesión</a>
                <a class="btn-registrarse" href="register.php">Registrarse</a>
            </div>
        <?php endif; ?>
    </div>
</header>

<script>
    // Menú desplegable
    const menuBtn = document.querySelector('.menu-btn');
    if (menuBtn) {
        menuBtn.addEventListener('click', function() {
            const menu = document.querySelector(".menu"); 
            if(menu.style.display === "block") {
                menu.style.display = "none";
            } else {
                menu.style.display = "block";
            }
        });
    }

    // Cerrar menú al hacer clic fuera
    document.addEventListener('click', function(event) {
        const menuBtn = document.querySelector('.menu-btn');
        const menu = document.querySelector('.menu');
        
        if (menu && menuBtn && !menuBtn.contains(event.target) && !menu.contains(event.target)) {
            menu.style.display = 'none';
        }
    });

    // Función para cerrar sesión
    function cerrarSesion() {
        if (confirm("¿Estás seguro de que deseas cerrar sesión?")) {
            window.location.href = '../backend/Usuarios/cerrar_sesion.php';
        }
    } 
</script>
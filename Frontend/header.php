<?php
include('../backend/Conexion.php');

/*if (!isset($_SESSION['ID_Cliente'])) {
    $_SESSION['ID_Cliente'] = 1; // Reemplaza con un ID real ej: Lucia 
}*/

function esUsuario() {
    return isset($_SESSION['ID_Cliente']);
}

function esOrganizador($conn) {
    if (!esUsuario()) return false;
    
    $stmt = $conn->prepare("SELECT Cedula FROM organizadores WHERE ID_Cliente = ?");
    $stmt->bind_param('i', $_SESSION['ID_Cliente']);
    $stmt->execute();
    return $stmt->get_result()->num_rows > 0;
}

function esAdmin($conn) {
    if (!esUsuario()) return false;
    
    $stmt = $conn->prepare("SELECT ID_Administrador FROM administradores WHERE ID_Administrador = ?");
    $stmt->bind_param('i', $_SESSION['ID_Administrador']);
    $stmt->execute();
    return $stmt->get_result()->num_rows > 0;
}


// Obtener datos del usuario de forma más sencilla en vez de muchos IFs en el HTML
function obtenerDatosUsuario($conn) {
    if (!esUsuario()) return null;
    
    $stmt = $conn->prepare("SELECT Nombre, imag_perfil FROM cliente WHERE ID_Cliente = ?");
    $stmt->bind_param('i', $_SESSION['ID_Cliente']);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}



// Obtener todos los datos necesarios
$usuarioLogueado = esUsuario(); // Inició sesión? S/N
$datosUsuario = $usuarioLogueado ? obtenerDatosUsuario($conn) : null; // Datos del usuario (Nombre, imag_perfil)
$esOrganizador = $usuarioLogueado ? esOrganizador($conn) : false; // Es organizador? S/N
$esAdmin = $usuarioLogueado ? esAdmin($conn) : false; // Es admin? S/N

// Cerrar conexión después de usarla
$conn->close();
?>

<link rel="stylesheet" href="css/header.css">

<header>
    <div class="logo">
        <a href="index.php">
            <img id="logo123" src="../Images/Logo-que-viaje.png" alt="Inicio">
        </a>
    </div>
    
    <div class="perfil">

        <?php if ($usuarioLogueado && $datosUsuario): ?>

            <!-- Si está logeado -->
             <div class="espacioimg">
            <img src="<?php echo !empty($datosUsuario['imag_perfil']) ? $datosUsuario['imag_perfil'] : 'https://cdn-icons-png.flaticon.com/512/6378/6378141.png'; ?>" 
                 alt="Perfil de <?php echo htmlspecialchars($datosUsuario['Nombre']); ?>"> 
            </div>
            <p><?php echo htmlspecialchars($datosUsuario['Nombre']); ?></p>
            
            <div class="container-menu">
                <button class="menu-btn">&#9776;</button>
                <div class="menu">

                    <?php if ($esOrganizador): ?>

                        <!-- Si es organiazador -->
                        <a href="mis-eventos.php"> Mis Eventos</a>
                        <a href="crear-evento.php"> Crear Evento</a> <!-- está en proceso -->

                    <?php elseif ($esAdmin): ?>

                        <!-- Si es admin -->
                        <a href="admin-panel.php"> Panel de Administración</a>
                        <a href="gestionar-usuarios.php"> Gestionar Usuarios</a>
                        <a href="gestionar-eventos.php"> Gestionar Eventos</a> <!-- Mitad hecha, solo existe la validacion -->

                     <?php else: ?>
                        <!-- Usuario común -->
                        <a href="convertirse-organizador.php"> Convertirse en Organizador</a>

                    <?php endif; ?>
                    
                    <!-- Los 3 en común -->
                    <a href="perfil.php">👤 Mi Perfil</a>
                    <a href="configuracion.php"> Configuración</a>
                    <button type="button" class="btn-cerrar" 
                        onclick="cerrarSesion()"> Cerrar Sesión</button>
                    <!-- Antiguo cerrar sesión <a href="crear_cuenta.html"> Cerrar Sesión</a> SI -->
                </div>    
            </div>

            
        <?php else: ?>
            <!-- Anónimo (NO logueado) -->
            <div class="container-menu">
                    <a class="btn-inicio-sesion" href="login.php"> Iniciar Sesión</a>
                    <a class="btn-registrarse" href="register.php">Registrarse</a>
            </div>
        <?php endif; ?>
    </div>
</header>

<script>
    document.querySelector('.menu-btn').addEventListener('click', function() {
            const menu = document.querySelector(".menu"); 
            if(menu.style.display === "block") {
                menu.style.display = "none";
            } else {
                menu.style.display = "block";
            }

        })

    function cerrarSesion() {
        if (confirm("¿Estás seguro de que deseas cerrar sesión?")) {
            window.location.href = '../backend/Usuarios/cerrar_sesion.php';
        }
    } 
</script>   
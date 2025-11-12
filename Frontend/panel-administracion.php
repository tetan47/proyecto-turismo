<?php 
// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include('../backend/Conexion.php'); 

// Verificar que el usuario esté logueado
if (!isset($_SESSION['logueado']) || $_SESSION['logueado'] !== true) {
    header('Location: ../Frontend/login.php');
    exit();
}

// Verificación de administrador
$esAdmin = false;

// 1. Verificar si ya tiene ID_Administrador en sesión
if (isset($_SESSION['ID_Administrador'])) {
    $esAdmin = true;
} else {
    // 2. Si no, verificar por correo (usar minúscula como se guarda en el login)
    $correo = $_SESSION['correo'] ?? null;
    
    if ($correo) {
        $stmt = $conn->prepare("SELECT ID_Administrador FROM administradores WHERE Correo = ?");
        $stmt->bind_param('s', $correo);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            // Es administrador, guardar en sesión
            $admin_data = $result->fetch_assoc();
            $_SESSION['ID_Administrador'] = $admin_data['ID_Administrador'];
            $esAdmin = true;
        }
        $stmt->close();
    }
}

// Si no es administrador, redirigir
if (!$esAdmin) {
    header('Location: ../Frontend/index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Administrativo - Solicitudes de Organizadores</title>
    <link rel="stylesheet" href="css/estructura_fundamental.css">
    <link rel="stylesheet" href="css/catalogo.css">
</head>
<body>
<?php include("header.php") ?>

<section class="catalogo" id="catalogo-eventos">
    <h2 style="text-align:center; padding:1em;">Cargando solicitudes...</h2>
</section>

<?php include("footer.html") ?>

<script>
document.addEventListener('DOMContentLoaded', function () {
    cargarSolicitudes();
});

function cargarSolicitudes() {
    const catalogo = document.getElementById('catalogo-eventos');
    
    fetch("../backend/administrador/filtrarsolicitudes.php", {
        method: 'GET'
    })
    .then(res => {
        if (!res.ok) {
            throw new Error('Error en la respuesta del servidor');
        }
        return res.text();
    })
    .then(html => {
        catalogo.innerHTML = html;
    })
    .catch(error => {
        console.error('Error al cargar solicitudes:', error);
        catalogo.innerHTML = '<p style="padding:2em;text-align:center;color:red;">Error al cargar las solicitudes. Verifica la conexión.</p>';
    });
}

function aprobarSolicitud(cedula) {
    if (confirm('¿Está seguro de aprobar esta solicitud?')) {
        fetch('../backend/administrador/aprobar_solicitud.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'cedula=' + encodeURIComponent(cedula)
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert('Solicitud aprobada exitosamente');
                cargarSolicitudes();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al procesar la solicitud');
        });
    }
}

function rechazarSolicitud(cedula) {
    if (confirm('¿Está seguro de rechazar esta solicitud? Esta acción eliminará la solicitud permanentemente.')) {
        fetch('../backend/administrador/rechazar_solicitud.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'cedula=' + encodeURIComponent(cedula)
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert('Solicitud rechazada exitosamente');
                cargarSolicitudes();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al procesar la solicitud');
        });
    }
}
</script>
    
</body>
</html>
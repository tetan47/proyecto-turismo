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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Eventos</title>
    <link rel="stylesheet" href="css/estructura_fundamental.css">
    <link rel="stylesheet" href="css/catalogo.css">
</head>
<body>
    
<?php include("header.php") ?>


<section class="catalogo" id="catalogo-eventos">
    <h2 style="text-align:center; padding:1em;">Cargando eventos...</h2>
</section>



<script>
document.addEventListener('DOMContentLoaded', function () {
    cargarSolicitudes();
});

function cargarSolicitudes() {
    const catalogo = document.getElementById('catalogo-eventos');
    
    fetch("../backend/administrador/gestionevento.php", {
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
</script>
</body>
</html>
<?php
session_start();

// Destruir todas las variables de sesión
$_SESSION = array();

// Eliminar la cookie de sesión si existe
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 42000, '/');
}

// Destruir la sesión en el servidor
session_destroy();

// Redirigir al usuario a la página de login
header('Location: ../../Frontend/login.php');
exit();
?>
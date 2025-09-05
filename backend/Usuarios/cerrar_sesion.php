<?php
session_start();

// Destruir todas las variables de sesión
$_SESSION = [];

// Destruir la sesión en el servidor
session_destroy();

// Redirigir al usuario a la página de inicio de sesión u otra página
header('Location: ../FrontEnd/inicio_sesion.html');
exit();



?>
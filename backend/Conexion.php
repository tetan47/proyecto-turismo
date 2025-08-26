<?php
$host = 'localhost';
$db = 'turismo'; // cambialo por el nombre correcto
$user = 'root';
$pass = ''; // contraseña vacía por defecto en XAMPP

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Conexión fallida: " . mysqli_connect_error());
}

?>
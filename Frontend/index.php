<?php
$host = 'localhost';
$db = 'turismo'; // cambialo por el nombre correcto
$user = 'root';
$pass = ''; // contraseña vacía por defecto en XAMPP

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>  
<?php
include 'conexion.php';
//include("../conexion.php");

$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$contraseña = $_POST['contraseña'];
$correo = $_POST['correo'];

$stmt = $conn->prepare("INSERT INTO cliente (nombre, apellido, contraseña, correo) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $nombre, $apellido, $contraseña, $correo);

if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ' -]+$/u", $nombre) || empty($nombre)) { // Validar que el nombre solo contenga letras y espacios
    echo "Nombre inválido. Serás redirigido en 5 segundos...";
    header("Refresh: 5; URL=../Frontend/crear_cuenta.php");
    exit;
}

if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ' -]+$/u", $apellido) || empty($apellido)) { // Validar que el apellido solo contenga letras y espacios
    echo "Apellido inválido. Serás redirigido en 5 segundos...";
    header("Refresh: 5; URL=../Frontend/crear_cuenta.php");
    exit;
}

if (!filter_var($correo, FILTER_VALIDATE_EMAIL) || empty($correo)) { // Validar formato de correo electrónico
    echo '<div class="alert alert-danger">"Correo inválido. Serás redirigido en 5 segundos..." </div>';
    header("Refresh: 5; URL=../Frontend/crear_cuenta.php");
    exit;
}

if (strlen($contraseña) < 8 || empty($contraseña)) { // Validar que la contraseña tenga al menos 8 caracteres
    echo "Contraseña inválida. Debe tener al menos 8 caracteres. Serás redirigido en 5 segundos...";
    header("Refresh: 5; URL=../Frontend/crear_cuenta.php");
    exit;
}

if ($stmt->execute()) {
     // Iniciar sesión automáticamente
        session_start();
        $_SESSION['usuario'] = $correo;

        header("Location: ../Frontend/index.php");
        echo "Datos guardados correctamente.";
        exit;
} else {
    echo "Error al guardar: " . $stmt->error;
}

 $hashed_password = password_hash($contraseña, PASSWORD_BCRYPT);


 // Verificar si el correo ya existe
    $check = $conn->prepare("SELECT id_cliente FROM cliente WHERE correo = ?");
    $check->bind_param("s", $correo);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $check->close();
        die("Este correo ya está registrado. <a href='../Frontend/crear_cuenta.php'>Volver</a>");
    }
    $check->close();


$stmt->close();
$conn->close();
?>

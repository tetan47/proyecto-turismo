<?php
session_start();
require "conexion.php"; // tu conexión

if (!empty($_POST["iniciar_sesion"])) {
    if (empty($_POST["correo"]) || empty($_POST["contraseña"])) {
        echo '<div class="alert alert-danger">Los campos están vacíos, por favor ingrese sus datos</div>';
    } else {
        $email = trim($_POST["correo"]);
        $passw = trim($_POST["contraseña"]);

        // Usa una consulta preparada para prevenir SQL Injection en el login 
        $stmt = $conn->prepare("SELECT id, Correo, Contraseña FROM usuario WHERE Correo = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            // Verificar contraseña (usando password_hash cuando se registra en la página)
            if (password_verify($passw, $row['Contraseña'])) {

                // Crear sesión segura
                session_regenerate_id(true);
                $_SESSION['usuario_id'] = $row['id'];
                $_SESSION['correo'] = $row['Correo'];

                $usuario_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
                

                header("Location: index.php");
                exit;
            } else {
                echo '<div class="alert alert-danger">Correo o contraseña incorrectos</div>';
            }
        } else {
            echo '<div class="alert alert-danger">Correo o contraseña incorrectos</div>';
        }
    }
}
?>

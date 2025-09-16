<?php
// Incluir conexión (usa ruta relativa desde /backend/Usuarios)
include __DIR__ . '/../Conexion.php';

// Iniciar sesión solo si no está activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!empty($_POST["iniciar_sesion"])) {
    if (empty($_POST["correo"]) || empty($_POST["contraseña"])) {
        echo '<div class="alert alert-danger">Los campos están vacíos, por favor ingrese sus datos</div>';
    } else {
        $email = trim($_POST["correo"]);
        $passw = trim($_POST["contraseña"]);

        $stmt = $conn->prepare(
            "SELECT id, Correo, Contraseña
             FROM usuario
             WHERE Correo = ?"
        );
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            if (password_verify($passw, $row['Contraseña'])) {
                session_regenerate_id(true);
                $_SESSION['usuario_id'] = $row['id'];
                $_SESSION['correo']     = $row['Correo'];

                header("Location: ../index.php");
                exit;
            } else {
                echo '<div class="alert alert-danger">Correo o contraseña incorrectos</div>';
            }
        } else {
            echo '<div class="alert alert-danger">Correo o contraseña incorrectos</div>';
        }
    }
}

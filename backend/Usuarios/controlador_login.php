<?php
// Incluir conexión
include __DIR__ . '/../Conexion.php';

// Iniciar sesión solo si no está activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['correo']) && isset($_POST['contraseña'])) {
    
    $email = trim($_POST["correo"]);
    $passw = trim($_POST["contraseña"]);

    // Validar campos vacíos
    if (empty($email) || empty($passw)) {
        $_SESSION['error_login'] = "Los campos están vacíos, por favor ingrese sus datos";
        header("Location: ../../Frontend/login.php");
        exit;
    }

    // Preparar consulta
    $stmt = $conn->prepare("SELECT ID_Cliente, Correo, Contraseña, Nombre, Apellido, bloquear FROM cliente WHERE Correo = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        
        // Verificar si el usuario está bloqueado
        if ($row['bloquear'] == 1) {
            $_SESSION['error_login'] = "Tu cuenta ha sido bloqueada. Contacta al administrador.";
            $stmt->close();
            header("Location: ../../Frontend/login.php");
            exit;
        }
        
        // Verificar contraseña
        $password_valida = false;
        
        // Intenta verificar con hash primero
        if (password_verify($passw, $row['Contraseña'])) {
            $password_valida = true;
        } 
        // Si falla, compara en texto plano (solo para migración)
        elseif ($passw === $row['Contraseña']) {
            $password_valida = true;
            
            // OPCIONAL: Actualizar a hash en el primer login
            /*$nuevo_hash = password_hash($passw, PASSWORD_BCRYPT);
            $update = $conn->prepare("UPDATE cliente SET Contraseña = ? WHERE ID_Cliente = ?");
            $update->bind_param("si", $nuevo_hash, $row['ID_Cliente']);
            $update->execute();
            $update->close();*/
        }

        if ($password_valida) {
            // Regenerar ID de sesión por seguridad
            session_regenerate_id(true);
            
            // Guardar datos en sesión
            $_SESSION['ID_Cliente'] = $row['ID_Cliente'];
            $_SESSION['correo'] = $row['Correo'];
            $_SESSION['nombre_usuario'] = $row['Nombre'];
            $_SESSION['logueado'] = true;

            $stmt->close();
            $conn->close();
            
            // Redirigir al index
            header("Location: ../../Frontend/index.php");
            exit;
        } else {
            $_SESSION['error_login'] = "Correo o contraseña incorrectos";
        }
    } else {
        $_SESSION['error_login'] = "Correo o contraseña incorrectos";
    }
    
    $stmt->close();
    $conn->close();
    
    // Si llegamos aquí, hubo error
    header("Location: ../../Frontend/login.php");
    exit;
}
?>
<?php 
session_start();

// Si ya está logueado, redirigir al index
if (isset($_SESSION['logueado']) && $_SESSION['logueado'] === true) {
    header("Location: index.php");
    exit;
}

// Procesar login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include("../backend/Usuarios/controlador_login.php");
}

// Capturar mensaje de error si existe
$error_login = isset($_SESSION['error_login']) ? $_SESSION['error_login'] : '';
unset($_SESSION['error_login']); // Limpiar después de mostrar
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">
    <title>Iniciar Sesión</title>
    <style>
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
        }
        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }
    </style>
</head>
<body>

    <div class="contenedor">
      <h1>Iniciar Sesión</h1>
  
      <?php if (!empty($error_login)): ?>
        <div class="alert alert-danger">
            <?php echo htmlspecialchars($error_login); ?>
        </div>
      <?php endif; ?>

      <form method="POST" action="">
        <div class="caja">
          <input type="email" id="correo" name="correo" placeholder="Correo" required>
          <i class="fas fa-envelope"></i>
        </div>
        
        <div class="caja">
          <input type="password" id="contraseña" name="contraseña" placeholder="Contraseña" required>
          <i class="fas fa-lock"></i>
        </div>
        
        <button type="submit" class="iniciar_sesion">Iniciar Sesión</button>
      </form>
      
      <div class="registrar_link">
        <p>¿No tienes una cuenta? <a href="register.php">Registrarse</a></p>
      </div>
      
      <div class="separador">
        <hr><span>O</span><hr>
      </div>
      
      <button type="button" class="boton_google">
        <img class="google_logo" src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/c1/Google_%22G%22_logo.svg/768px-Google_%22G%22_logo.svg.png" alt="Google Logo">
        <span>Continuar con Google</span>
      </button>
    </div>
    
    <img class="imagen_inicio_sesion" src="https://misalto.uy/wp-content/uploads/2024/12/WhatsApp-Image-2024-12-11-at-14.55.05.jpeg" alt="">

  </body>
</html>
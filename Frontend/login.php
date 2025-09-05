<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/login.css">
    <title>iniciar sesion</title>
</head>
<body>

    <div class="contenedor">
      <form method="post" action="index.php">
      <h1>iniciar sesion</h1>
      
      <?php
        include("Conexion.php");
        include("controlador_login.php");
      ?>

        <div class="caja">
          <input type="email" id=Correo name="correo" placeholder="Correo" required>
          <i class="fas fa-envelope"></i>
        </div>
        <div class="caja">
          <input type="password" id=contraseña name="contraseña" placeholder="Contraseña" required>
          <i class="fas fa-lock"></i>
        </div>
        <button type="submit" class="iniciar_sesion">iniciar sesion</button>
      </form>
      <div class="registrar_link">
        <p>¿No tienes una cuenta? <a href="Crear_cuenta.html">Registrarse</a></p>
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

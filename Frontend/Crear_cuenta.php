<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Crear_cuenta.css">
    <title>Crear_cuenta</title>
</head>
<body>
    <img class="imagen_register" src="https://misalto.uy/wp-content/uploads/2024/12/WhatsApp-Image-2024-12-11-at-14.55.05.jpeg" alt="">

    <div class="contenedor">
      <h1>Crear Cuenta</h1>
  
      <form action="../backend/Insertar.php" method="POST">
  
        <div class="caja">
          <input type="text" id=nombre name="nombre" placeholder="Nombre" required>
          <i class="fas fa-user"></i>
        </div>
        <div class="caja">
          <input type="text" id=apellido name="apellido" placeholder="Apellido" required>
          <i class="fas fa-user"></i>
        </div>
        <div class="caja">
          <input type="email" id=Correo name="correo" placeholder="Correo" required>
          <i class="fas fa-envelope"></i>
        </div>
        <div class="caja">
          <input type="password" id=contraseña name="contraseña" placeholder="Contraseña" required>
          <i class="fas fa-lock"></i>
        </div>
        <button type="submit" class="crear_cuenta">Crear Cuenta</button>
      </form>
      <div class="registrar_link">
        <p>¿Ya tienes una cuenta? <a href="Inicio_sesion.php">Inicia sesión</a></p>
      </div>
      <div class="separador">
        <hr><span>O</span><hr>
      </div>
      <button type="button" class="boton_google">
        <img class="google_logo" src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/c1/Google_%22G%22_logo.svg/768px-Google_%22G%22_logo.svg.png" alt="Google Logo">
        <span>Continuar con Google</span>
      </button>
    </div>
  </body>
</html>

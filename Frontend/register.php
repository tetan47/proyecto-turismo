<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/register.css">
    <title>Crear_cuenta</title>
</head>
<body>
    <img class="imagen_register" src="https://misalto.uy/wp-content/uploads/2024/12/WhatsApp-Image-2024-12-11-at-14.55.05.jpeg" alt="">

    <div class="contenedor">
      <h1>Crear Cuenta</h1>
  
      <form id="registerForm" method="POST" action="../backend/Usuarios/Insertar.php">
        <input type="hidden" name="role" value="user"> <!-- forzar role en el formulario -->
        <div class="caja">
          <input type="text" id="nombre" name="nombre" placeholder="Nombre" required>
          <i class="fas fa-user"></i>
        </div>
        <div class="caja">
          <input type="text" id="apellido" name="apellido" placeholder="Apellido" required>
          <i class="fas fa-user"></i>
        </div>
        <div class="caja">
          <input type="email" id="Correo" name="correo" placeholder="Correo" required>
          <i class="fas fa-envelope"></i>
        </div>
        <div class="caja">
          <input type="password" id="contraseña" name="contraseña" placeholder="Contraseña" required>
          <i class="fas fa-lock"></i>
        </div>
        <button type="submit" class="crear_cuenta">Crear Cuenta</button>
      </form>
      <div class="registrar_link">
        <p>¿Ya tienes una cuenta? <a href="login.php">Inicia sesión</a></p>
      </div>
      <div class="separador">
        <hr><span>O</span><hr>
      </div>
      <button type="button" class="boton_google">
        <img class="google_logo" src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/c1/Google_%22G%22_logo.svg/768px-Google_%22G%22_logo.svg.png" alt="Google Logo">
        <span>Continuar con Google</span>
      </button>
    </div>

<script>
document.getElementById('registerForm').addEventListener('submit', async function(e) {
  e.preventDefault();
  const correo = document.getElementById('Correo').value;
  try {
    const resp = await fetch('../backend/Usuarios/check_admin_email.php', {
      method: 'POST',
      headers: {'Content-Type': 'application/json'},
      body: JSON.stringify({ correo })
    });
    const data = await resp.json();
    if (data.is_admin) {
      alert('No puedes registrarte con un correo que ya tiene permisos de administrador. Contacta con un administrador.');
      return;
    }
    // si no es admin, enviar el formulario normalmente
    this.submit();
  } catch (err) {
    console.error(err);
    alert('Error comprobando el correo. Intente nuevamente.');
  }
});
</script>

  </body>
</html>

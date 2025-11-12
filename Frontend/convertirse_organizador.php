<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Convertirse en Organizador</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="css/estructura_fundamental.css">
  <link rel="stylesheet" href="css/formularios.css">
</head>
<body>
<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include("header.php");

if (!isset($_SESSION['ID_Cliente']) || !isset($_SESSION['logueado']) || $_SESSION['logueado'] !== true) {
    echo "<script>
            alert('Debes iniciar sesión para enviar una solicitud');
            window.location.href='login.php';
          </script>";
    exit();
}
?>

<div class="formulario">
  <h1>Solicitud para Organizador</h1>
  <p style="text-align: center; color: #e0e0e0; margin-bottom: 30px; font-size: 15px;">
    Envía tu solicitud para convertirte en organizador de eventos
  </p>
  
  <form action="../backend/organizador/procesar_organizadores.php" method="post">
    <label for="cedula">Cédula <span style="color: red;">*</span></label><br />
    <input type="text" id="cedula" name="cedula" required maxlength="10" placeholder="Ingresa tu número de cédula (7-10 dígitos)" /><br /><br />

    <label for="telefono">Teléfono <span style="color: red;">*</span></label><br />
    <input type="tel" id="telefono" name="telefono" required maxlength="20" placeholder="Ej: 099123456 o +598 99 123 456" /><br /><br />

    <div style="background: rgba(157, 77, 248, 0.1); border: 1px solid rgba(157, 77, 248, 0.3); border-radius: 10px; padding: 15px; margin-bottom: 20px;">
      <p style="margin: 0; font-size: 14px; color: #e0e0e0;">
        <i class="fas fa-info-circle" style="color: #9d4df8; margin-right: 8px;"></i>
        <strong>Importante:</strong> Tu solicitud será revisada por los administradores. 
        Una vez aprobada, podrás crear y gestionar eventos. Asegúrate de ingresar datos correctos.
      </p>
    </div>

    <p style="font-size: 12px; color: #666; margin-bottom: 15px;">
      <span style="color: red;">*</span> Campos obligatorios
    </p>

    <button type="submit">Enviar Solicitud</button>
  </form>
</div>

<script>
document.getElementById("cedula").addEventListener("input", function(e) {
    const valorAnterior = this.value;
    this.value = this.value.replace(/[^0-9]/g, '');
    
  if (valorAnterior !== this.value) {
      this.style.borderColor = "#ff6b6b";
      setTimeout(() => {
        this.style.borderColor = "";
      }, 300);
    }
});

document.getElementById("telefono").addEventListener("input", function(e) {
    const valorAnterior = this.value;
    this.value = this.value.replace(/[^0-9+\-\s()]/g, '');
    
  if (valorAnterior !== this.value) {
      this.style.borderColor = "#ff6b6b";
      setTimeout(() => {
        this.style.borderColor = "";
      }, 300);
    }
});

document.querySelector("form").addEventListener("submit", function(e) {
  const cedula = document.getElementById("cedula").value;
  const telefono = document.getElementById("telefono").value;

  if (cedula.length < 7 || cedula.length > 10) {
    e.preventDefault();
    document.getElementById("cedula").style.borderColor = "#ff6b6b";
    alert("La cédula debe tener entre 7 y 10 dígitos");
    return false;
  }

  if (telefono.length < 8 || telefono.length > 20) {
    e.preventDefault();
    document.getElementById("telefono").style.borderColor = "#ff6b6b";
    alert("El teléfono debe tener entre 8 y 20 caracteres");
    return false;
  }
});
</script>
<?php include("footer.html") ?>
</body>
</html>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Editar Evento</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="css/estructura_fundamental.css">
  <link rel="stylesheet" href="css/Crear_eventos.css">
</head>
<body>
<?php 
// Iniciar sesión
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$evento_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

include("header.php");

// Verificar que el usuario esté logueado
if (!isset($_SESSION['ID_Cliente']) || !isset($_SESSION['logueado']) || $_SESSION['logueado'] !== true) {
    echo "<script>
            alert('Debes iniciar sesión para crear un evento');
            window.location.href='login.php';
          </script>";
    exit();
}
?>

<div class="formulario">
  <h1>Editar Evento</h1>
  <form action="../backend/eventos/editarorg.php" method="post" enctype="multipart/form-data">
    <label for="titulo">Título <span style="color: red;">*</span></label><br />
    <input type="text" id="titulo" name="titulo" required maxlength="50" placeholder="Nombre del evento" /><br /><br />

    <label for="descripcion">Descripción</label><br />
    <textarea id="descripcion" name="descripcion" style="min-height: 60px; max-height: 200px;" rows="4" maxlength="200" placeholder="Describe tu evento (máx. 200 caracteres)"></textarea><br /><br />

    <label for="categoria">Categoría <span style="color: red;">*</span></label><br />
    <select id="categoria" name="categoria" required>
      <option value="">Seleccionar…</option>
      <option value="música">Música</option>
      <option value="deporte">Deporte</option>
      <option value="arte">Arte</option>
      <option value="gastronómico">Gastronómico</option>
      <option value="historia">Historia</option>
      <option value="cultural">Cultural</option>
      <option value="otros">Otros</option>
    </select><br /><br />

    <label for="ubicacion">Ubicación <span style="color: red;">*</span></label><br />
    <input type="text" id="ubicacion" name="ubicacion" required maxlength="50" placeholder="Dirección o lugar del evento" /><br /><br />

    <label for="fecha_inicio">Fecha inicio <span style="color: red;">*</span></label><br />
    <input type="date" id="fecha_inicio" name="fecha_inicio" required min="<?php echo date('Y-m-d'); ?>" /><br /><br />

    <label for="fecha_fin">Fecha fin <span style="color: red;">*</span></label><br />
    <input type="date" id="fecha_fin" name="fecha_fin" required min="<?php echo date('Y-m-d'); ?>" /><br /><br />

    <label for="hora_evento">Hora <span style="color: red;">*</span></label><br />
    <input type="time" id="hora_evento" name="hora_evento" required /><br /><br />

    <label for="capacidad">Capacidad <span style="color: red;">*</span></label><br />
    <input type="number" id="capacidad" name="capacidad" min="1" max="100000" required placeholder="Numero de personas" /><br /><br />

    <label for="imagen">Imagen del evento</label><br />
    <input type="file" class="btn-img" id="imagen" name="imagen" accept="image/*" /><br />
    <img id="preview" alt="Vista previa de la imagen" style="display: none; max-width: 300px; margin-top: 10px; border-radius: 8px;" /><br /><br />

    <p style="font-size: 12px; color: #666; margin-bottom: 15px;">
      <span style="color: red;">*</span> Campos obligatorios
    </p>

    <button type="submit">Crear Evento</button>
  </form>
</div>

<script>
  // Vista previa de la imagen
  document.getElementById("imagen").addEventListener("change", function(event) {
    const file = event.target.files[0];
    const preview = document.getElementById("preview");

    if (file) {
      // Validar tamaño (5MB máximo)
      if (file.size > 5000000) {
        alert("La imagen es demasiado grande. El tamaño máximo es 5MB.");
        this.value = "";
        preview.style.display = "none";
        return;
      }

      // Validar tipo de archivo
      const tiposPermitidos = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
      if (!tiposPermitidos.includes(file.type)) {
        alert("Tipo de archivo no permitido. Solo se aceptan: JPG, JPEG, PNG, GIF, WEBP");
        this.value = "";
        preview.style.display = "none";
        return;
      }

      // Mostrar vista previa
      const reader = new FileReader();
      reader.onload = function(e) {
        preview.src = e.target.result;
        preview.style.display = "block";
      };
      reader.readAsDataURL(file);
    } else {
      preview.style.display = "none";
      preview.src = "";
    }
  });

  // Sincronizar fecha mínima de fecha_fin con fecha_inicio
  document.getElementById("fecha_inicio").addEventListener("change", function() {
    const fechaInicio = this.value;
    const fechaFinInput = document.getElementById("fecha_fin");
    
    // Establecer la fecha mínima
    fechaFinInput.setAttribute("min", fechaInicio);
    
    // Si ya hay una fecha_fin seleccionada, validarla
    if (fechaFinInput.value && fechaFinInput.value < fechaInicio) {
      alert("La fecha de fin no puede ser anterior a la fecha de inicio. Por favor, selecciona una nueva fecha de fin.");
      fechaFinInput.value = "";
    }
  });

  // Validar que fecha_fin no sea menor que fecha_inicio
  document.getElementById("fecha_fin").addEventListener("blur", function() {
    const fechaInicio = document.getElementById("fecha_inicio").value;
    const fechaFin = this.value;

    // Solo validar si ambas fechas están completamente ingresadas
    if (fechaInicio && fechaFin && fechaFin.length === 10) {
      if (fechaFin < fechaInicio) {
        alert("La fecha de fin no puede ser anterior a la fecha de inicio");
        this.value = "";
        this.focus();
      }
    }
  });
</script>
<?php include("footer.html") ?>
</body>
</html>
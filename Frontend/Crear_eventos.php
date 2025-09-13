<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Crear Evento</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="css/Crear_eventos.css">
  <link rel="stylesheet" href="css/estructura_fundamental.css">
</head>
<body>
<?php include("header.php") ?>

<div class="formulario">
  <h1>Crear Evento</h1>
  <form action="/crear-evento" method="post">
    <label for="titulo">Título</label><br />
    <input type="text" id="titulo" name="titulo" required /><br /><br />

    <label for="descripcion">Descripción</label><br />
    <textarea id="descripcion" name="descripcion" rows="4"></textarea><br /><br />

    <label for="categoria">Categoría</label><br />
    <select id="categoria" name="categoria" required>
      <option value="">Seleccionar…</option>
      <option value="concierto">Concierto</option>
      <option value="teatro">Teatro</option>
      <option value="feria">Feria</option>
      <option value="deporte">Deporte</option>
      <option value="otro">Otro</option>
    </select><br /><br />

    <label for="ubicacion">Ubicación</label><br />
    <input type="text" id="ubicacion" name="ubicacion" required /><br /><br />

    <label for="fecha_inicio">Fecha inicio</label><br />
    <input type="date" id="fecha_inicio" name="fecha_inicio" required /><br /><br />

    <label for="fecha_fin">Fecha fin</label><br />
    <input type="date" id="fecha_fin" name="fecha_fin" required /><br /><br />

    <label for="hora_evento">Hora</label><br />
    <input type="time" id="hora_evento" name="hora_evento"required /><br /><br />

    <label for="capacidad">Capacidad</label><br />
    <input type="number" id="capacidad" name="capacidad" min="1" required /><br /><br />

    <label for="imagen">Imagen del evento</label><br />
    <input type="file" id="imagen" name="imagen" accept="image/*" /><br />
    <img id="preview" alt="Vista previa de la imagen" /><br /><br />

    <button type="submit">subir</button>
  </form>
</div>

<script>
  document.getElementById("imagen").addEventListener("change", function(event) {
    const file = event.target.files[0];
    const preview = document.getElementById("preview");

    if (file) {
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
</script>
<?php include("footer.html") ?>
</body>
</html>

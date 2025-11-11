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
session_start();
include('../backend/Conexion.php');

// Validar sesión y ID
if (!isset($_SESSION['ID_Cliente']) || !isset($_GET['id'])) {
    header('Location: login.php');
    exit();
}

$evento_id = intval($_GET['id']);

// Obtener datos del evento
$sql = "SELECT Título, Descripción, categoria, Ubicacion, Fecha_Inicio, Fecha_Fin, Hora, Capacidad, imagen 
        FROM eventos WHERE ID_Evento = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $evento_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<script>alert('Evento no encontrado'); window.history.back();</script>";
    exit();
}

$evento = $result->fetch_assoc();
$stmt->close();

// Preparar imagen para mostrar (SIN base64)
$imagen_preview = $evento['imagen'] ?? '';
if (empty($imagen_preview)) {
    $imagen_preview = 'https://via.placeholder.com/300?text=Sin+imagen';
}

include("header.php");
?>

<div class="formulario">
  <h1>Editar Evento</h1>
  <form action="../backend/eventos/editarevent.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="evento_id" value="<?php echo $evento_id; ?>">

    <label>Título <span style="color: red;">*</span></label>
    <input type="text" name="titulo" value="<?php echo htmlspecialchars($evento['Título']); ?>" required maxlength="50" /><br /><br />

    <label>Descripción</label>
    <textarea name="descripcion" rows="4" maxlength="200"><?php echo htmlspecialchars($evento['Descripción']); ?></textarea><br /><br />

    <label>Categoría <span style="color: red;">*</span></label>
    <select name="categoria" required>
      <option value="música" <?php echo $evento['categoria'] === 'música' ? 'selected' : ''; ?>>Música</option>
      <option value="deporte" <?php echo $evento['categoria'] === 'deporte' ? 'selected' : ''; ?>>Deporte</option>
      <option value="arte" <?php echo $evento['categoria'] === 'arte' ? 'selected' : ''; ?>>Arte</option>
      <option value="gastronómico" <?php echo $evento['categoria'] === 'gastronómico' ? 'selected' : ''; ?>>Gastronómico</option>
      <option value="historia" <?php echo $evento['categoria'] === 'historia' ? 'selected' : ''; ?>>Historia</option>
      <option value="cultural" <?php echo $evento['categoria'] === 'cultural' ? 'selected' : ''; ?>>Cultural</option>
      <option value="otros" <?php echo $evento['categoria'] === 'otros' ? 'selected' : ''; ?>>Otros</option>
    </select><br /><br />

    <label>Ubicación <span style="color: red;">*</span></label>
    <input type="text" name="ubicacion" value="<?php echo htmlspecialchars($evento['Ubicacion']); ?>" required maxlength="100" /><br /><br />

    <label>Fecha inicio <span style="color: red;">*</span></label>
    <input type="date" name="fecha_inicio" value="<?php echo $evento['Fecha_Inicio']; ?>" required /><br /><br />

    <label>Fecha fin <span style="color: red;">*</span></label>
    <input type="date" name="fecha_fin" value="<?php echo $evento['Fecha_Fin']; ?>" required /><br /><br />

    <label>Hora <span style="color: red;">*</span></label>
    <input type="time" name="hora_evento" value="<?php echo $evento['Hora']; ?>" required /><br /><br />

    <label>Capacidad <span style="color: red;">*</span></label>
    <input type="number" name="capacidad" value="<?php echo $evento['Capacidad']; ?>" min="1" max="100000" required /><br /><br />

    <label>Imagen del evento</label>
    <input type="file" name="imagen" accept="image/*" /><br />
    <!-- Mostrar imagen -->
    <?php if ($imagen_preview): ?>
        <img id="preview" src="<?php echo $imagen_preview; ?>" alt="Imagen actual" style="max-width: 300px; margin-top: 10px; border-radius: 8px;" /><br /><br />
    <?php else: ?>
        <img id="preview" style="display: none; max-width: 300px; margin-top: 10px; border-radius: 8px;" />
    <?php endif; ?>

    <button type="submit">Guardar Cambios</button>
  </form>
</div>

<script>
  // Vista previa de nueva imagen
  document.querySelector('input[name="imagen"]').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (!file) return;

    if (file.size > 5000000) {
      alert('La imagen es muy grande (máx. 5MB)');
      this.value = '';
      return;
    }

    const tipos = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    if (!tipos.includes(file.type)) {
      alert('Solo se aceptan: JPG, PNG, GIF, WEBP');
      this.value = '';
      return;
    }

    const reader = new FileReader();
    reader.onload = (e) => {
      document.getElementById('preview').src = e.target.result;
      document.getElementById('preview').style.display = 'block';
    };
    reader.readAsDataURL(file);
  });

  // Validar fechas
  document.querySelector('input[name="fecha_inicio"]').addEventListener('change', function() {
    document.querySelector('input[name="fecha_fin"]').setAttribute('min', this.value);
  });
</script>
<?php include("footer.html") ?>
</body>
</html>
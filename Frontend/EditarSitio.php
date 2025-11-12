<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Editar Sitio Turístico</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="css/estructura_fundamental.css">
  <link rel="stylesheet" href="css/formularios.css">
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

$sitio_id = intval($_GET['id']);

// Obtener datos del sitio turístico
$sql = "SELECT Titulo, Descripcion, Categoria, Ubicacion, Hora_Inicio, Hora_Fin, Estado, Imagen, telefono 
        FROM sitioturistico WHERE ID_Sitio = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $sitio_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<script>alert('Sitio turístico no encontrado'); window.history.back();</script>";
    exit();
}

$sitio = $result->fetch_assoc();
$stmt->close();

// Preparar imagen para mostrar
$imagen_preview = $sitio['Imagen'] ?? '';
if (empty($imagen_preview)) {
    $imagen_preview = 'https://via.placeholder.com/300?text=Sin+imagen';
}

include("header.php");
?>

<div class="formulario">
  <h1>Editar Sitio Turístico</h1>
  <form action="../backend/sitios/editarsitio.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="sitio_id" value="<?php echo $sitio_id; ?>">

    <label>Título <span style="color: red;">*</span></label>
    <input type="text" name="titulo" value="<?php echo htmlspecialchars($sitio['Titulo']); ?>" required maxlength="50" /><br /><br />

    <label>Descripción</label>
    <textarea name="descripcion" rows="4" maxlength="2600"><?php echo htmlspecialchars($sitio['Descripcion']); ?></textarea><br /><br />

    <label>Categoría <span style="color: red;">*</span></label>
    <select name="categoria" required>
      <option value="Termas" <?php echo $sitio['Categoria'] === 'Termas' ? 'selected' : ''; ?>>Termas</option>
      <option value="Cultural" <?php echo $sitio['Categoria'] === 'Cultural' ? 'selected' : ''; ?>>Cultural</option>
      <option value="Recreativo" <?php echo $sitio['Categoria'] === 'Recreativo' ? 'selected' : ''; ?>>Recreativo</option>
      <option value="Gastronomico" <?php echo $sitio['Categoria'] === 'Gastronomico' ? 'selected' : ''; ?>>Gastronómico</option>
      <option value="Deporte" <?php echo $sitio['Categoria'] === 'Deporte' ? 'selected' : ''; ?>>Deporte</option>
      <option value="Naturaleza" <?php echo $sitio['Categoria'] === 'Naturaleza' ? 'selected' : ''; ?>>Naturaleza</option>
      <option value="Historico" <?php echo $sitio['Categoria'] === 'Historico' ? 'selected' : ''; ?>>Histórico</option>
      <option value="RutasMiradores" <?php echo $sitio['Categoria'] === 'RutasMiradores' ? 'selected' : ''; ?>>Rutas y Miradores</option>
      <option value="Alojamiento" <?php echo $sitio['Categoria'] === 'Alojamiento' ? 'selected' : ''; ?>>Alojamiento</option>
      <option value="Arte" <?php echo $sitio['Categoria'] === 'Arte' ? 'selected' : ''; ?>>Arte</option>
    </select><br /><br />

    <label>Ubicación</label>
    <textarea name="ubicacion" rows="3" maxlength="600"><?php echo htmlspecialchars($sitio['Ubicacion']); ?></textarea>
    <small>Puede ingresar texto o código de iframe de Google Maps</small><br /><br />

    <label>Estado <span style="color: red;">*</span></label>
    <select name="estado" required>
      <option value="Abierto" <?php echo $sitio['Estado'] === 'Abierto' ? 'selected' : ''; ?>>Abierto</option>
      <option value="Cerrado" <?php echo $sitio['Estado'] === 'Cerrado' ? 'selected' : ''; ?>>Cerrado</option>
    </select><br /><br />

    <label>Teléfono</label>
    <input type="tel" name="telefono" value="<?php echo htmlspecialchars($sitio['telefono']); ?>" maxlength="15" /><br /><br />

    <label>Hora de Apertura</label>
    <input type="time" name="hora_inicio" value="<?php echo $sitio['Hora_Inicio']; ?>" /><br /><br />

    <label>Hora de Cierre</label>
    <input type="time" name="hora_fin" value="<?php echo $sitio['Hora_Fin']; ?>" /><br /><br />

    <label>Imagen del sitio</label>
    <input type="file" name="imagen" accept="image/*" /><br />
    <!-- Mostrar imagen actual -->
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

  // Validar horas
  document.querySelector('input[name="hora_inicio"]').addEventListener('change', function() {
    const horaFin = document.querySelector('input[name="hora_fin"]');
    if (this.value && horaFin.value && this.value >= horaFin.value) {
      alert('La hora de apertura debe ser anterior a la hora de cierre');
      this.value = '';
    }
  });

  document.querySelector('input[name="hora_fin"]').addEventListener('change', function() {
    const horaInicio = document.querySelector('input[name="hora_inicio"]');
    if (this.value && horaInicio.value && this.value <= horaInicio.value) {
      alert('La hora de cierre debe ser posterior a la hora de apertura');
      this.value = '';
    }
  });
</script>
<?php include("footer.html") ?>
</body>
</html>
<?php session_start(); ?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Catálogo de Eventos</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="css/estructura_fundamental.css">
  <link rel="stylesheet" href="css/catalogo.css">
  <?php include('../backend/Conexion.php'); ?>  

</head>

<body>
  <?php include("header.php") ?>

  <div class="contenedor_nav">
    <nav>
      <form id="form-filtros" class="busqueda-eventos" autocomplete="off">
        <input type="text" name="Busqueda" placeholder="Buscar eventos..." minlength="3">
        <div id="filtros" style="display:none;">
          <div class="grupo-filtro">
            <div>
              <label for="fecha-inicio">Fecha Inicio</label>
              <input type="date" name="fecha-inicio" id="fecha-inicio">
            </div>
            <div>
              <label for="fecha-fin">Fecha Final</label>
              <input type="date" name="fecha-fin" id="fecha-fin">
            </div>
          </div>

          <div class="grupo-filtro">
            <div>
              <label for="hora-inicio">Hora Inicial</label>
              <input type="time" name="hora-inicio" id="hora-inicio">
            </div>
            <div>
              <label for="hora-fin">Hora Final</label>
              <input type="time" name="hora-fin" id="hora-fin">
            </div>
          </div>

          <div class="grupo-filtro">
            <div>
              <label for="categoria">Categoría</label>
              <select name="categoria" id="categoria">
                <option value="">Todas</option>
                <option value="musica">Música</option>
                <option value="deporte">Deporte</option>
                <option value="arte">Arte</option>
                <option value="gastronomia">Gastronomía</option>
                <option value="historia">Historia</option>
                <option value="cultura">Cultura</option>
                <option value="otros">Otros</option>
              </select>
            </div>
          </div>
        </div>
        <button type="button" id="mostrar-filtros">&#9660; Filtros</button>
        <button type="submit">Buscar</button>
        <button type="reset" id="btn-limpiar">Limpiar</button>
      </form>
    </nav>
  </div>

  <section class="catalogo" id="catalogo-eventos">
    <!-- Aquí se cargarán los eventos filtrados -->
  </section>

  <?php include("footer.html") ?>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('form-filtros');
  const catalogo = document.getElementById('catalogo-eventos');
  const mostrarFiltros = document.getElementById('mostrar-filtros');
  const filtros = document.getElementById('filtros');
  const btnLimpiar = document.getElementById('btn-limpiar');

  mostrarFiltros.addEventListener('click', function (e) {
    e.preventDefault();
    filtros.style.display = filtros.style.display === 'none' ? 'block' : 'none';
  });

  function cargarEventos() {
    const datos = new FormData(form);
    fetch("../backend/eventos/Filtrar.php", {
      method: 'POST',
      body: datos
    })
      .then(res => res.text())
      .then(html => {
        catalogo.innerHTML = html;
      });
  }

  // Cargar todos los eventos al inicio
  cargarEventos();

  // Al enviar el formulario, filtra sin recargar
  form.addEventListener('submit', function (e) {
    e.preventDefault();
    cargarEventos();
  });

  // Limpiar el formulario y recargar eventos
  btnLimpiar.addEventListener('click', function (e) {
    form.reset();
    cargarEventos();
  });
});

function toggleMapa(btn) {
  const mapa = btn.nextElementSibling;
  if (mapa.style.display === "none" || mapa.style.display === "") {
    mapa.style.display = "block";
    btn.textContent = "Ocultar mapa";
  } else {
    mapa.style.display = "none";
    btn.textContent = "Ver mapa";
  }
}
  </script>
</body>

</html>
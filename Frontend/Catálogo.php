<?php session_start(); ?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Catálogo de Eventos</title>
  <link rel="stylesheet" href="catalogo.css">
  <?php include ('../backend/Conexion.php'); ?>

</head>
<body>
  <?php include("header.php") ?>

  <div class="contenedor_nav">
  <nav>
    <form id="form-filtros" class="busqueda-eventos" autocomplete="off">
      <input type="text" name="Busqueda" placeholder="Buscar eventos..." minlength="3">
          <div id="filtros" style="display:none;">
        <input type="date" name="Fecha_Inicio">
        <input type="time" name="hora">
        <select name="categoria">
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
      <button type="button" id="mostrar-filtros">&#9660; Filtros</button>
      <button type="submit">Buscar</button>
    </form>
  </nav>
  </div>

  <section class="catalogo" id="catalogo-eventos">
    <!-- Aquí se cargarán los eventos filtrados -->
  </section>

  <?php include("footer.html") ?>

  <script>
  document.addEventListener('DOMContentLoaded', function() { 
    const form = document.getElementById('form-filtros');
    const catalogo = document.getElementById('catalogo-eventos');
    const mostrarFiltros = document.getElementById('mostrar-filtros');
    const filtros = document.getElementById('filtros');

    mostrarFiltros.addEventListener('click', function(e) {
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
    form.addEventListener('submit', function(e) {
      e.preventDefault();
      cargarEventos();
    });
  });
  </script>
</body>
</html>

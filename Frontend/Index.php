<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>¡Qué Viaje!</title>
  <link rel="stylesheet" href="css/estructura_fundamental.css">
  <link rel="stylesheet" href="css/index.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>

  <!-- HEADER -->
  <?php
    include('header.php');
  ?>

  <!-- SECCIÓN EVENTOS -->
<section class="eventos"> 
  <h2>¡Descubre los eventos más interesantes!</h2>
  <div class="carrusel-container">
    <button class="prev"><i class="fas fa-chevron-left"></i></button>
    
    <div id="carrusel" class="carrusel">
      <div class="elemento"><img src="../Images/museo.webp" alt="imagen 1" loading="lazy"></div>
      <div class="elemento"><img src="../Images/artigas.webp" alt="imagen 2" loading="lazy"></div>
      <div class="elemento"><img src="../Images/plaza33.webp" alt="imagen 3" loading="lazy"></div>
      <div class="elemento"><img src="../Images/arapey.webp" alt="imagen 4" loading="lazy"></div>
      <div class="elemento"><img src="../Images/calleuy.webp" alt="imagen 5" loading="lazy"></div>
    </div>

    <button class="next"><i class="fas fa-chevron-right"></i></button>
  </div>
</section>

  <!-- BOTONES PRINCIPALES -->
  <section class="botones">
    <a href="Catálogo.php" class="btn">Ver Eventos</a>
    <a href="sitios_turisticos.php" class="btn">Lugares Turísticos</a>
  </section>

  <!-- INFO -->
  <section class="info">
    <div class="info-contenido">
      <h2>¿Qué ofrece ¡Qué Viaje!?</h2>
      
      <div class="bloque">
        <h3>Centralización de eventos</h3>
        <p>
          Nuestra plataforma organiza y centraliza toda la información sobre 
          eventos turísticos, culturales y sociales de Salto. 
        </p>
      </div>

      <div class="bloque">
        <h3>Agenda interactiva</h3>
        <p>
          Los usuarios podrán explorar los eventos por fecha, categoría 
          o ubicación en un calendario sencillo y práctico.
        </p>
      </div>

      <div class="bloque">
        <h3>Oportunidades para organizadores</h3>
        <p>
          Los organizadores tendrán un espacio para publicar sus actividades, 
          llegar a más personas y recibir mayor visibilidad.
        </p>
      </div>

      <div class="bloque">
        <h3>Accesible para todos</h3>
        <p>
          La web está pensada tanto para turistas como para residentes, 
          con una interfaz clara y adaptable a cualquier dispositivo.
        </p>
      </div>
    </div>
  </section>

<script>
  const carrusel = document.querySelector(".carrusel");
  const elementos = document.querySelectorAll(".elemento");
  const prev = document.querySelector(".prev");
  const next = document.querySelector(".next");

  let index = 0;

  function mostrarSlide(n) {
    if (n < 0) {
      index = elementos.length - 1;
    } else if (n >= elementos.length) {
      index = 0;
    }
    carrusel.style.transform = `translateX(${-index * 100}%)`;
  }

  prev.addEventListener("click", () => {
    index--;
    mostrarSlide(index);
  });

  next.addEventListener("click", () => {
    index++;
    mostrarSlide(index);
  });

  // Loop automático cada 5 segundos
  setInterval(() => {
    index++;
    mostrarSlide(index);
  }, 5000);
</script>
<?php include("footer.html") ?>
</body>
</html>

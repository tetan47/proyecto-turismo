<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>¡Qué Viaje! - Tu guía de eventos y turismo en Salto</title>
  <meta name="description" content="Descubre los mejores eventos y lugares turísticos de Salto. Agenda interactiva, eventos culturales y más.">
  <link rel="stylesheet" href="css/estructura_fundamental.css">
  <link rel="stylesheet" href="css/index.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="icon" href="../Images/logo-queviaje.webp" sizes="64x64" type="image/x-icon">
</head>
<body>

  <!-- HEADER -->
  <?php
    include('header.php');
  ?>

  <section class="hero">
    <div class="hero-content">
      <h1 class="hero-title">Descubre Salto como nunca antes</h1>
      <p class="hero-subtitle">Tu guía completa de eventos, cultura y turismo en un solo lugar</p>
      <div class="hero-buttons">
        <a href="Catálogo.php" class="btn-primario">
          <i class="fas fa-calendar-alt"></i> Explorar Eventos
        </a>
        <a href="sitios_turisticos.php" class="btn-secundario">
          <i class="fa fa-map-marked-alt"></i> Sitios Turísticos
        </a>
      </div>
      <div class="hero-stats">
        <div class="stat">
          <span class="stat-number">0</span>
          <span class="stat-label">Eventos publicados</span>
        </div>
        <div class="stat">
          <span class="stat-number">30+</span>
          <span class="stat-label">Lugares turísticos</span>
        </div>
        <div class="stat">
          <span class="stat-number">0</span>
          <span class="stat-label">Usuarios activos</span>
        </div>
      </div>
    </div>
  </section>

  <!-- SECCIÓN EVENTOS DESTACADOS -->
  <section class="eventos"> 
    <div class="section-header">
      <h2>Eventos destacados esta semana</h2>
      <p>No te pierdas las mejores experiencias que Salto tiene para ofrecer</p>
    </div>

     <div class="carrusel-container">
      <button class="prev" aria-label="Anterior"><i class="fas fa-chevron-left"></i></button>
      
      <div id="carrusel" class="carrusel">
        <div class="elemento">
          <img src="../Images/museo.webp" alt="Museo del Hombre y la Tecnología" loading="lazy">
          <div class="carrusel-caption">
            <h3>Museo del Hombre y la Tecnología</h3>
            <p>Exposición permanente</p>
            <span class="evento-tag">Cultural</span>
          </div>
        </div>
        <div class="elemento">
          <img src="../Images/artigas.webp" alt="Plaza Artigas" loading="lazy">
          <div class="carrusel-caption">
            <h3> Plaza Artigas</h3>
            <p>Muy visitada</p>
            <span class="evento-tag">Festival</span>
          </div>
        </div>
        <div class="elemento">
          <img src="../Images/plaza33.webp" alt="Plaza de los Treinta y Tres" loading="lazy">
          <div class="carrusel-caption">
            <h3>Plaza 33 Orientales</h3>
            <p>Muy visitada</p>
            <span class="evento-tag">Artesanía</span>
          </div>
        </div>
        <div class="elemento">
          <img src="../Images/arapey.webp" alt="Termas del Arapey" loading="lazy">
          <div class="carrusel-caption">
            <h3>Termas del Arapey</h3>
            <p>Relax y bienestar</p>
            <span class="evento-tag">Turismo</span>
          </div>
        </div>
        <div class="elemento">
          <img src="../Images/calleuy.webp" alt="Calle Uruguay" loading="lazy">
          <div class="carrusel-caption">
            <h3>Centro Histórico</h3>
            <p>Locales abierto a partir de las 10:00 AM</p>
            <span class="evento-tag">Tour</span>
          </div>
        </div>
      </div>

      <button class="next" aria-label="Siguiente"><i class="fas fa-chevron-right"></i></button>
      
      <!-- Indicadores del carrusel -->
      <div class="carrusel-indicators">
        <span class="indicator active" data-slide="0"></span>
        <span class="indicator" data-slide="1"></span>
        <span class="indicator" data-slide="2"></span>
        <span class="indicator" data-slide="3"></span>
        <span class="indicator" data-slide="4"></span>
      </div>
  </section>

      <!-- Categorías Eventos -->
    <section class="categorias">
    <h2>Explora por categorías</h2>
    <div class="categorias-grid">
      <a href="Catálogo.php?categoria=cultural" class="categoria-card">
        <i class="fas fa-theater-masks"></i>
        <h3>Cultural</h3>
        <p>Teatro, música y arte</p>
      </a>
      <a href="Catálogo.php?categoria=deportivo" class="categoria-card">
        <i class="fas fa-running"></i>
        <h3>Deportivo</h3>
        <p>Competencias y actividades</p>
      </a>
      <a href="Catálogo.php?categoria=gastronomico" class="categoria-card">
        <i class="fas fa-utensils"></i>
        <h3>Gastronómico</h3>
        <p>Ferias y degustaciones</p>
      </a>
      <a href="Catálogo.php?categoria=familiar" class="categoria-card">
        <i class="fas fa-users"></i>
        <h3>Familiar</h3>
        <p>Para toda la familia</p>
      </a>
    </div>
  </section>

  <section id="como-funciona" class="como-funciona">
    <h2>¿Cómo funciona ¡Qué Viaje!?</h2>
    <div class="pasos-container">
      <div class="paso">
        <div class="paso-numero">1</div>
        <i class="fas fa-search paso-icono"></i>
        <h3>Explora</h3>
        <p>Busca eventos por fecha, categoría o ubicación en nuestra plataforma intuitiva</p>
      </div>
      <div class="paso">
        <div class="paso-numero">2</div>
        <i class="fas fa-bookmark paso-icono"></i>
        <h3>Guarda</h3>
        <p>Marca tus eventos favoritos y crea tu propia agenda personalizada</p>
      </div>
      <div class="paso">
        <div class="paso-numero">3</div>
        <i class="fas fa-share-alt paso-icono"></i>
        <h3>Comparte</h3>
        <p>Invita a amigos y familia a unirse a las mejores experiencias de Salto</p>
      </div>
    </div>

     <section class="info">
      <div class="info-contenido">
        <h2>¿Por qué elegir ¡Qué Viaje!?</h2>

        <div class="beneficios-grid">
          <div class="bloque">
            <i class="fas fa-map-marked-alt bloque-icono"></i>
            <h3>Centralización de eventos</h3>
            <p>Toda la información sobre eventos turísticos, culturales y sociales de Salto en un solo lugar. Nunca más te perderás de nada.</p>
          </div>

          <div class="bloque">
            <i class="fas fa-calendar-check bloque-icono"></i>
            <h3>Agenda interactiva</h3>
            <p>Calendario inteligente que te permite filtrar por tus intereses, disponibilidad y ubicación. Planifica tu semana perfecta.</p>
          </div>

          <div class="bloque">
            <i class="fas fa-bullhorn bloque-icono"></i>
            <h3>Para organizadores</h3>
            <p>Plataforma completa para publicar eventos, gestionar asistentes, obtener estadísticas y llegar a miles de personas.</p>
          </div>

          <div class="bloque">
            <i class="fas fa-mobile-alt bloque-icono"></i>
            <h3>Acceso universal</h3>
            <p>Funciona perfectamente en cualquier dispositivo, para turistas y residentes.</p>
          </div>

          <div class="bloque">
            <i class="fas fa-bell bloque-icono"></i>
            <h3>Notificaciones inteligentes</h3>
            <p>Recibe alertas sobre nuevos eventos de tu interés y recordatorios de tus actividades guardadas.</p>
          </div>

          <div class="bloque">
            <i class="fas fa-star bloque-icono"></i>
            <h3>Reseñas y valoraciones</h3>
            <p>Lee experiencias de otros usuarios y comparte las tuyas para ayudar a la comunidad.</p>
          </div>
    </section>
        </div>
      </div>
    </section>

  <section class="testimonios">
    <h2>Lo que dicen nuestros usuarios</h2>
      <div class="testimonios-grid">
        <div class="testimonio">
          <div class="testimonio-header">
            <img src="https://i.pravatar.cc/100?img=1" alt="Usuario">
          <div>
            <h4>María González</h4>
            <span class="testimonio-rol">Turista</span>
          </div>
        </div>
        <p>"Gracias a ¡Qué Viaje! descubrí eventos increíbles que no aparecían en ninguna guía turística tradicional."</p>
        <div class="testimonio-rating">
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
        </div>
      </div>
         <div class="testimonio">
        <div class="testimonio-header">
          <img src="https://i.pravatar.cc/100?img=3" alt="Usuario">
          <div>
            <h4>Juan Pérez</h4>
            <span class="testimonio-rol">Organizador</span>
          </div>
        </div>
        <p>"La plataforma es intuitiva y muy completa."</p>
        <div class="testimonio-rating">
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
        </div>
      </div>
      
      <div class="testimonio">
        <div class="testimonio-header">
          <img src="https://i.pravatar.cc/100?img=5" alt="Usuario">
          <div>
            <h4>Ana Rodríguez</h4>
            <span class="testimonio-rol">Residente</span>
          </div>
        </div>
        <p>"Como salteña, ahora estoy al día con todo lo que pasa en mi ciudad. ¡Es genial!"</p>
        <div class="testimonio-rating">
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
        </div>
      </div>
    </div>
  </section>

  <section class="cta">
    <div class="cta-content">
      <h2>¿Listo para descubrir Salto?</h2>
      <p>Únete a más usuarios que ya están disfrutando de los mejores eventos</p>
      <div class="cta-buttons">
        <a href="register.php" class="btn-cta-primary">
          <i class="fas fa-user-plus"></i> Crear cuenta gratis
        </a>
        <a href="Catálogo.php" class="btn-cta-secondary">
          <i class="fas fa-compass"></i> Explorar sin registro
        </a>
         </div>
  </section>

  <!-- PRÓXIMOS EVENTOS -->
  <section class="proximos-eventos">
    <h2>Próximos eventos destacados</h2>
    <div class="eventos-lista">
      <div class="evento-item">
        <div class="evento-fecha">
          <span class="dia">15</span>
          <span class="mes">NOV</span>
        </div>
        <div class="evento-info">
          <h3>Festival de la Primavera</h3>
          <p><i class="fas fa-map-marker-alt"></i> Plaza Artigas</p>
          <p><i class="fas fa-clock"></i> 18:00 - 23:00</p>
        </div>
        <a href="#" class="btn-ver-mas">Ver más</a>
      </div>
      
      <div class="evento-item">
        <div class="evento-fecha">
          <span class="dia">20</span>
          <span class="mes">NOV</span>
        </div>
        <div class="evento-info">
          <h3>Expo Artesanías del Litoral</h3>
          <p><i class="fas fa-map-marker-alt"></i> Centro Cultural</p>
          <p><i class="fas fa-clock"></i> 10:00 - 20:00</p>
        </div>
        <a href="#" class="btn-ver-mas">Ver más</a>
      </div>
      
      <div class="evento-item">
        <div class="evento-fecha">
          <span class="dia">25</span>
          <span class="mes">NOV</span>
        </div>
        <div class="evento-info">
          <h3>Maratón Ciudad de Salto</h3>
          <p><i class="fas fa-map-marker-alt"></i> Costanera</p>
          <p><i class="fas fa-clock"></i> 07:00 - 12:00</p>
        </div>
        <a href="#" class="btn-ver-mas">Ver más</a>
         </div>
    </div>
  </section>
  <?php
   include("footer.html") 
   ?>
  <script>

document.addEventListener('DOMContentLoaded', function() {
  const carrusel = document.querySelector(".carrusel");
  const elementos = document.querySelectorAll(".elemento");
  const prev = document.querySelector(".prev");
  const next = document.querySelector(".next");
  const indicators = document.querySelectorAll(".indicator");
  const container = document.querySelector(".carrusel-container");

  let index = 0;
  let autoSlideInterval;
  const slideDuration = 5000;
  let isMobile = window.innerWidth <= 768;

  // Detectar cambios de tamaño de ventana
  window.addEventListener('resize', function() {
    const wasMobile = isMobile;
    isMobile = window.innerWidth <= 768;
    
    // Si cambió de celular a pc o viceversa, reiniciar
    if (wasMobile !== isMobile) {
      index = 0;
      mostrarSlide(index);
      if (!isMobile) {
        startAutoSlide();
      } else {
        clearInterval(autoSlideInterval);
      }
    }
  });

  function updateIndicators() {
    indicators.forEach((indicator, i) => {
      indicator.classList.toggle("active", i === index);
    });
  }

  function mostrarSlide(n) {
    if (n < 0) {
      index = elementos.length - 1;
    } else if (n >= elementos.length) {
      index = 0;
    } else {
      index = n;
    }

    if (isMobile) {
      // En pc, usar scroll suave
      const scrollPosition = index * carrusel.offsetWidth;
      carrusel.scrollTo({
        left: scrollPosition,
        behavior: 'smooth'
      });
    } else {
      // En pc, usar transform
      carrusel.style.transform = `translateX(${-index * 100}%)`;
    }
    
    updateIndicators();
  }

  // Botones de navegación
  if (prev && next) {
    prev.addEventListener("click", () => {
      index--;
      mostrarSlide(index);
      if (!isMobile) resetAutoSlide();
    });

    next.addEventListener("click", () => {
      index++;
      mostrarSlide(index);
      if (!isMobile) resetAutoSlide();
    });
  }

  // Indicadores
  indicators.forEach((indicator, i) => {
    indicator.addEventListener("click", () => {
      index = i;
      mostrarSlide(index);
      if (!isMobile) resetAutoSlide();
    });
  });

  // Auto-slide (solo pc)
  function startAutoSlide() {
    if (!isMobile) {
      autoSlideInterval = setInterval(() => {
        index++;
        mostrarSlide(index);
      }, slideDuration);
    }
  }

  function resetAutoSlide() {
    clearInterval(autoSlideInterval);
    startAutoSlide();
  }

  // Pausar auto-slide al hover (solo pc)
  if (container) {
    container.addEventListener("mouseenter", () => {
      if (!isMobile) clearInterval(autoSlideInterval);
    });
    
    container.addEventListener("mouseleave", () => {
      if (!isMobile) startAutoSlide();
    });
  }

  // Detectar scroll manual en celular
  if (isMobile) {
    let scrollTimeout;
    carrusel.addEventListener('scroll', function() {
      clearTimeout(scrollTimeout);
      scrollTimeout = setTimeout(() => {
        const scrollLeft = carrusel.scrollLeft;
        const slideWidth = carrusel.offsetWidth;
        const newIndex = Math.round(scrollLeft / slideWidth);
        if (newIndex !== index) {
          index = newIndex;
          updateIndicators();
        }
      }, 100);
    });
  }

  // Inicializar
  updateIndicators();
  if (!isMobile) {
    startAutoSlide();
  }
});
  </script>

  <script src="JavaScript/translations.js"></script>
  <script src="JavaScript/language.js"></script>

</body>
</html>

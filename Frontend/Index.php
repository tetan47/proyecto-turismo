<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>¡Qué Viaje!</title>
  <link rel="stylesheet" href="Indexest.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>

  <!-- HEADER -->
  <header>
    <div class="logo">
      <img src="../Images/logo3.png" alt="Logo Qué Viaje">
    </div>
    <nav>
      <?php if ($usuario): ?>
        <!-- Si está logueado -->
        <span class="saludo">👤 Hola, <?php echo htmlspecialchars($usuario); ?></span>
        <a href="logout.php" class="btn-logout">Cerrar Sesión</a>
      <?php else: ?>
        <!-- Si no está logueado -->
        <a href="login.php" class="btn-login">Iniciar Sesión</a>
        <a href="registro.php" class="btn-register">Registrarse</a>
      <?php endif; ?>

      <select class="idioma">
        <option>ES</option>
        <option>EN</option> 
      </select>
      <a href="#" class="perfil"><i class="fas fa-user"></i> Perfil</a>
    </nav>
  </header>

  <!-- SECCIÓN EVENTOS -->
  <section class="eventos">
    <h2>¡Descubre los eventos más interesantes!</h2>
    <div class="carrusel">
      <div class="elemento"></div>
      <div class="elemento"></div>
      <div class="elemento"></div>
      <div class="elemento"></div>
      <div class="elemento"></div>
    </div>
  </section>

  <!-- BOTONES PRINCIPALES -->
  <section class="botones">
    <a href="catalogo.php" class="btn">Ver Eventos</a>
    <a href="#" class="btn">Lugares Turísticos</a>
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

  <!-- FOOTER -->
  <footer>
    <div class="social">
      <a href="#"><i class="fab fa-whatsapp"></i></a>
      <a href="#"><i class="fab fa-instagram"></i></a>
      <a href="#"><i class="fab fa-facebook"></i></a>
    </div>
    <div class="links">
      <a href="#">Soporte</a>
      <a href="#">Manual de Usuario</a>
      <a href="mailto:Vivalagrasa@mail.com">Contacto</a>
    </div>
  </footer>

</body>
</html>

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-11-2025 a las 12:20:06
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `turismo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administra`
--

CREATE TABLE `administra` (
  `Cédula` varchar(10) DEFAULT NULL,
  `ID_Evento` int(11) DEFAULT NULL,
  `ID_Administrador` int(11) DEFAULT NULL,
  `Organizador_Verificado` tinyint(1) DEFAULT NULL,
  `Evento_Verificado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `administra`
--

INSERT INTO `administra` (`Cédula`, `ID_Evento`, `ID_Administrador`, `Organizador_Verificado`, `Evento_Verificado`) VALUES
('12345678', 1, 1, 1, 1),
('87654321', 2, 2, 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administradores`
--

CREATE TABLE `administradores` (
  `ID_Administrador` int(11) NOT NULL,
  `Teléfono` varchar(25) DEFAULT NULL,
  `Activo` tinyint(1) DEFAULT NULL,
  `Nombre` varchar(25) NOT NULL,
  `Apellido` varchar(25) NOT NULL,
  `Correo` varchar(50) DEFAULT NULL,
  `Contraseña` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `administradores`
--

INSERT INTO `administradores` (`ID_Administrador`, `Teléfono`, `Activo`, `Nombre`, `Apellido`, `Correo`, `Contraseña`) VALUES
(1, '099123456', 1, 'Ana', 'López', 'ana.lopez@gmail.com', 'adminana'),
(2, '098987654', 0, 'Jorge', 'Martínez', 'jorge.martinez@gmail.com', 'adminjorge');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `ID_Cliente` int(11) NOT NULL,
  `Nombre` varchar(20) NOT NULL,
  `Apellido` varchar(20) NOT NULL,
  `Correo` varchar(50) NOT NULL,
  `Contraseña` varchar(25) NOT NULL,
  `Registro` date DEFAULT current_timestamp(),
  `imag_perfil` varchar(255) DEFAULT 'https://cdn-icons-png.flaticon.com/512/6378/6378141.png',
  `bloquear` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`ID_Cliente`, `Nombre`, `Apellido`, `Correo`, `Contraseña`, `Registro`, `imag_perfil`, `bloquear`) VALUES
(1, 'Lucía', 'Pérez', 'lucia.perez@gmail.com', 'lucia123', '2025-06-01', 'https://images.pexels.com/photos/29026195/pexels-photo-29026195/free-photo-of-mujer-serena-relajandose-junto-al-rio.jpeg', 0),
(2, 'Carlos', 'Gómez', 'carlos.gomez@gmail.com', 'carlos456', '2025-06-02', NULL, 0),
(4, 'Keylor', 'Navarro', 'keylornava23@gmail.com', 'keylor123', '2025-10-03', 'https://cdn-icons-png.flaticon.com/512/6378/6378141.png', 0),
(5, 'Cristian', 'Castro', 'crisgoku@gmail.com', 'cristian123', '2025-10-03', 'https://cdn-icons-png.flaticon.com/512/6378/6378141.png', 0),
(6, 'Ana', 'López', 'ana.lopez@gmail.com', 'adminana', '2025-10-03', 'https://cdn-icons-png.flaticon.com/512/6378/6378141.png', 0),
(7, 'pedro', 'gallino', 'pedrogallino@gmail.com', 'pedrogallino', '2025-10-03', 'https://cdn-icons-png.flaticon.com/512/6378/6378141.png', 0),
(8, 'Jorge', 'Martinez', 'jorge.martinez@gmail.com', 'adminjorge', '2025-10-20', 'https://cdn-icons-png.flaticon.com/512/6378/6378141.png', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios`
--

CREATE TABLE `comentarios` (
  `ID_Comentario` int(11) NOT NULL,
  `ID_Cliente` int(11) NOT NULL,
  `ID_Evento` int(11) DEFAULT NULL,
  `ID_Sitio` int(11) DEFAULT NULL,
  `LIKES` int(4) DEFAULT 0,
  `Texto` varchar(250) DEFAULT NULL,
  `Creación_Comentario` datetime DEFAULT current_timestamp(),
  `Cédula` varchar(10) DEFAULT NULL,
  `usuarios_like` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `comentarios`
--

INSERT INTO `comentarios` (`ID_Comentario`, `ID_Cliente`, `ID_Evento`, `ID_Sitio`, `LIKES`, `Texto`, `Creación_Comentario`, `Cédula`, `usuarios_like`) VALUES
(1, 1, 1, NULL, 12, 'Muy buen ambiente y productos.', '2025-06-11 00:00:00', NULL, ''),
(2, 2, 2, NULL, 9, 'Excelente sonido y organización.', '2025-06-16 00:00:00', NULL, ''),
(6, 1, 5, NULL, NULL, 'Primer comentario', '2025-09-03 19:27:06', NULL, NULL),
(8, 1, 5, NULL, NULL, 'Primer comentario', '2025-09-03 19:29:14', NULL, NULL),
(9, 1, 5, NULL, NULL, 'Segundo comentario', '2025-09-03 19:29:14', NULL, NULL),
(10, 1, 1, NULL, 1, 'me gustó mucho xd .', '2025-09-15 16:33:19', NULL, '1'),
(12, 1, 1, NULL, 0, 'pruebas', '2025-09-17 10:55:35', NULL, NULL),
(14, 5, 1, NULL, 0, 'Así era ella', '2025-10-03 11:14:29', NULL, ''),
(15, 5, NULL, 2, 1, 'Fui con mi perra y me corrieron 😞', '2025-10-09 10:59:42', NULL, '5'),
(17, 5, NULL, 5, 0, 'Qué se hace?', '2025-10-09 12:29:27', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eventos`
--

CREATE TABLE `eventos` (
  `ID_Evento` int(11) NOT NULL,
  `Título` varchar(50) NOT NULL,
  `Descripción` varchar(200) NOT NULL,
  `Capacidad` int(11) NOT NULL DEFAULT 0,
  `Creacion_Evento` date DEFAULT current_timestamp(),
  `Ubicacion` varchar(600) DEFAULT NULL,
  `Cédula` varchar(10) DEFAULT NULL,
  `Hora` time DEFAULT NULL,
  `imagen` varchar(255) NOT NULL DEFAULT 'https://upload.wikimedia.org/wikipedia/commons/0/0e/DefaultImage.png',
  `categoria` varchar(25) DEFAULT NULL,
  `Fecha_Inicio` date DEFAULT NULL,
  `Fecha_Fin` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `eventos`
--

INSERT INTO `eventos` (`ID_Evento`, `Título`, `Descripción`, `Capacidad`, `Creacion_Evento`, `Ubicacion`, `Cédula`, `Hora`, `imagen`, `categoria`, `Fecha_Inicio`, `Fecha_Fin`) VALUES
(1, 'Feria de Artesanos', 'Evento cultural con productos locales.', 0, '2025-06-10', 'Plaza Artigas', '12345678', '12:00:00', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTQZeYDEJsUpT3ezV087qItQsAA6AK-5sRm4Q&s', 'Otros', '2025-08-30', NULL),
(2, 'Concierto de Rock', 'Banda local en vivo.', 0, '2025-06-15', 'Teatro Larrañaga', '87654321', '21:30:00', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSzNOofyD4Mr6H45aMbkOV9nVoykLczluR1Pw&s', 'Música', '2026-01-02', NULL),
(3, 'Fiesta de Aaron', 'Festejamos el cumple de Aaron', 0, '2025-08-29', 'Casa de Aaron', '12345678', '00:00:00', 'https://upload.wikimedia.org/wikipedia/commons/0/0e/DefaultImage.png', 'Otros', '2025-09-10', NULL),
(4, 'Prueba 4', 'xd', 0, '2025-11-21', 'Casa de Aaron', '12345678', '00:00:00', 'https://upload.wikimedia.org/wikipedia/commons/0/0e/DefaultImage.png', 'Otros', '2025-11-21', NULL),
(5, 'Festival de Jazz en el Larrañaga', 'Gran festival internacional de jazz con artistas de Argentina, Brasil y Uruguay. Tres días de música en vivo con entrada libre y gratuita. Incluye talleres y jam sessions.', 0, '2025-10-20', 'Teatro Larrañaga, Av. Uruguay 1100', NULL, '20:00:00', 'https://images.unsplash.com/photo-1511192336575-5a79af67a629?w=800&h=500&fit=crop', 'musica', '2025-11-15', '2025-11-17'),
(6, 'Maratón Termal de Salto', 'Competencia atlética de 21km y 10km por las termas del Daymán y Salto Grande. Inscripciones abiertas. Incluye kit del corredor y medalla finisher.', 0, '2025-10-20', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d2021.7026815861896!2d-57.94460762469598!3d-31.4141820087294!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1spesca%20salto!5e0!3m2!1ses-419!2suy!4v1762859925433!5m2!1ses-419!2suy\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', NULL, '07:00:00', 'https://images.unsplash.com/photo-1452626038306-9aae5e071dd3?w=800&h=500&fit=crop', 'deporte', '2025-12-08', '2025-12-08'),
(7, 'Feria Gastronómica del Río Uruguay', 'Muestra gastronómica con productores locales, food trucks y chefs reconocidos. Degustación de vinos, aceites de oliva y productos artesanales de la región.', 0, '2025-10-20', 'Costanera Sur, Parque García Lorca', NULL, '18:00:00', 'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?w=800&h=500&fit=crop', 'gastronomia', '2025-11-22', '2025-11-24'),
(8, 'Noche de los Museos Salto', 'Recorrido cultural nocturno gratuito por los principales museos de la ciudad. Incluye actividades interactivas, música en vivo y performances artísticas.', 0, '2025-10-20', 'Circuito: Teatro Larrañaga - Museo de Artes Plásti', NULL, '19:00:00', 'https://images.unsplash.com/photo-1544967082-d9d25d867eeb?w=800&h=500&fit=crop', 'cultura', '2025-10-25', '2025-10-25'),
(9, 'Torneo de Pesca del Río Uruguay', 'Competencia anual de pesca deportiva con modalidades embarcado y costa. Premios para las mejores piezas. Inscripción previa obligatoria.', 0, '2025-10-20', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6819.023791099313!2d-57.953578003841834!3d-31.289594001796047!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x95adc16676af68eb%3A0x1c57de9978ad7fb9!2sParque%20Jos%C3%A9%20Luis%2C%20Departamento%20de%20Salto!5e0!3m2!1ses-419!2suy!4v1762857906385!5m2!1ses-419!2suy\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', NULL, '06:00:00', 'https://images.unsplash.com/photo-1559827260-dc66d52bef19?w=800&h=500&fit=crop', 'deporte', '2025-11-30', '2025-12-01'),
(10, 'Carnaval de Salto 2026', 'El carnaval más largo del mundo. Desfiles de comparsas, murgas y conjuntos en el corsódromo oficial. Entrada gratuita. Cuatro semanas de espectáculos.', 0, '2025-10-20', 'Corsódromo de Salto, Zona Parque Solari', NULL, '21:00:00', 'https://images.unsplash.com/photo-1516450360452-9312f5e86fc7?w=800&h=500&fit=crop', 'cultura', '2026-01-10', '2026-02-15'),
(11, 'Exposición de Arte Contemporáneo', 'Muestra colectiva de artistas plásticos del litoral uruguayo. Pinturas, esculturas e instalaciones. Entrada libre.', 0, '2025-10-20', 'Museo de Artes Plásticas M.I. Olarreaga Gallino', NULL, '10:00:00', 'https://images.unsplash.com/photo-1460661419201-fd4cecdf8a8b?w=800&h=500&fit=crop', 'arte', '2025-11-05', '2025-11-30'),
(12, 'Festival de Folklore y Tradición', 'Encuentro de jineteadas, folklore y danzas tradicionales. Presenta grupos de Uruguay y Argentina. Feria artesanal y gastronómica incluida.', 0, '2025-10-20', 'Predio Salto Grande', NULL, '16:00:00', 'https://images.unsplash.com/photo-1533174072545-7a4b6ad7a6c3?w=800&h=500&fit=crop', 'cultura', '2025-12-14', '2025-12-15'),
(13, 'Concierto Sinfónico de Fin de Año', 'La Orquesta Sinfónica de Salto presenta su tradicional concierto de cierre de año con obras clásicas y populares. Entrada con bono contribución.', 0, '2025-10-20', 'Teatro Larrañaga, Av. Uruguay 1100', NULL, '21:00:00', 'https://images.unsplash.com/photo-1465847899084-d164df4dedc6?w=800&h=500&fit=crop', 'musica', '2025-12-28', '2025-12-28'),
(14, 'Salto en Bicicleta - Paseo Nocturno', 'Ciclo paseo familiar por la costanera y centro histórico. Actividad gratuita con punto de encuentro en Plaza Artigas. Traer bicicleta y casco.', 0, '2025-10-20', 'Salida: Plaza Artigas - Recorrido Costanera', NULL, '20:00:00', 'https://images.unsplash.com/photo-1571068316344-75bc76f77890?w=800&h=500&fit=crop', 'deporte', '2025-11-12', '2025-11-12'),
(15, 'Feria del Libro de Salto', 'Encuentro literario con escritores nacionales y regionales. Presentaciones de libros, talleres de escritura y actividades para niños. Entrada gratuita.', 0, '2025-10-20', 'Ateneo de Salto, Calle Brasil 1056', NULL, '10:00:00', 'https://images.unsplash.com/photo-1481627834876-b7833e8f5570?w=800&h=500&fit=crop', 'cultura', '2025-11-08', '2025-11-10'),
(16, 'Rock en las Termas', 'Festival de rock nacional con bandas emergentes y consagradas. Dos escenarios simultáneos. Entrada con preventa disponible.', 0, '2025-10-20', 'Complejo Termal Salto Grande', NULL, '19:00:00', 'https://images.unsplash.com/photo-1501281668745-f7f57925c3b4?w=800&h=500&fit=crop', 'musica', '2026-01-20', '2026-01-20'),
(17, 'Torneo de Fútbol Infantil Copa Salto', 'Campeonato para categorías sub-10, sub-12 y sub-14. Participan clubes de toda la región litoral. Entrada libre para espectadores.', 0, '2025-10-20', 'Complejo Deportivo Municipal', NULL, '09:00:00', 'https://images.unsplash.com/photo-1489944440615-453fc2b6a9a9?w=800&h=500&fit=crop', 'deporte', '2025-11-16', '2025-11-17'),
(18, 'Semana de la Cerveza Artesanal', 'Encuentro de cerveceros artesanales del Uruguay. Degustaciones, charlas técnicas y maridajes. Food trucks y música en vivo.', 0, '2025-10-20', 'Mercado 18 de Julio, Centro Salto', NULL, '18:00:00', 'https://images.unsplash.com/photo-1535958636474-b021ee887b13?w=800&h=500&fit=crop', 'gastronomia', '2025-12-05', '2025-12-08'),
(19, 'Encuentro de Teatro Independiente', 'Cuatro días de teatro con compañías de todo el país. Obras para adultos y niños. Entrada con bono contribución voluntario.', 0, '2025-10-20', 'Teatro Larrañaga y espacios alternativos', NULL, '20:00:00', 'https://images.unsplash.com/photo-1503095396549-807759245b35?w=800&h=500&fit=crop', 'arte', '2025-11-27', '2025-11-30'),
(20, 'Fiesta del Olivo', 'Celebración de la cosecha del olivo con actividades educativas sobre producción de aceite. Degustación, venta de productos y recorridos por olivares.', 0, '2025-10-20', 'Olivares Salteños, Zona Rural', NULL, '10:00:00', 'https://images.unsplash.com/photo-1474440692490-2e83ae13ba29?w=800&h=500&fit=crop', 'gastronomia', '2025-12-20', '2025-12-20'),
(21, 'Caminata Histórica por el Ayuí', 'Recorrido guiado por el sitio histórico donde comenzó el Éxodo del Pueblo Oriental. Incluye charla histórica y refrigerio. Actividad gratuita.', 0, '2025-10-20', 'Sitio Histórico del Ayuí, Salto Grande', NULL, '09:00:00', 'https://images.unsplash.com/photo-1507619665486-cbb202cfd968?w=800&h=500&fit=crop', 'historia', '2025-11-18', '2025-11-18'),
(22, 'Festival de Tango Río de los Pájaros', 'Encuentro de tango con milongas, clases y shows de reconocidas orquestas. Dos días de pura tradición rioplatense.', 0, '2025-10-20', 'Centro Cultural Mercado 18 de Julio', NULL, '20:00:00', 'https://images.unsplash.com/photo-1504609773096-104ff2c73ba4?w=800&h=500&fit=crop', 'musica', '2025-12-12', '2025-12-13'),
(23, 'Golden Gym', 'PONETE FUETTE', 90, '2025-11-10', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6812.011317105549!2d-57.97363762229001!3d-31.386407499999972!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x95addd13903bf4ed%3A0x2be3661688be163d!2sGolden%20Gym%20Salto!5e0!3m2!1ses-419!2suy!4v1762810143752!5m2!1ses-419!2suy\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', '12345678', '00:00:00', '/portadas-eventos/evento_1762805667_691247a3af31d.jfif', 'arte', '2026-01-01', '2040-01-01');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `organizadores`
--

CREATE TABLE `organizadores` (
  `Cedula` varchar(10) NOT NULL,
  `RUT` varchar(15) DEFAULT NULL,
  `Teléfono` varchar(20) DEFAULT NULL,
  `ID_Cliente` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `organizadores`
--

INSERT INTO `organizadores` (`Cedula`, `RUT`, `Teléfono`, `ID_Cliente`) VALUES
('12345678', '12345678901', '099111222', 1),
('87654321', '98765432109', '098222111', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respondercomentario`
--

CREATE TABLE `respondercomentario` (
  `comentario_responder` int(11) NOT NULL,
  `respuesta` text NOT NULL,
  `ID_Comentario` int(11) NOT NULL,
  `Creación_Respuesta` datetime DEFAULT current_timestamp(),
  `ID_Cliente` int(11) NOT NULL,
  `LIKESRES` int(11) NOT NULL DEFAULT 0,
  `usuarios_like_res` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `respondercomentario`
--

INSERT INTO `respondercomentario` (`comentario_responder`, `respuesta`, `ID_Comentario`, `Creación_Respuesta`, `ID_Cliente`, `LIKESRES`, `usuarios_like_res`) VALUES
(3, 'pruebienda', 1, '2025-09-15 17:36:15', 1, 3, '1'),
(5, 'quien sos lucia?? que haces comentando la pagina de mi noviO?', 1, '2025-09-16 09:37:45', 1, 1, '1'),
(8, 'prueba 1', 12, '2025-09-18 08:43:55', 1, 1, '1'),
(9, 'Hola me llamo Kaze', 1, '2025-10-03 11:14:43', 5, 0, NULL),
(12, 'jajaj XD', 15, '2025-10-09 11:10:06', 5, 1, '5');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sitioturistico`
--

CREATE TABLE `sitioturistico` (
  `ID_Sitio` int(11) NOT NULL,
  `Titulo` varchar(50) NOT NULL,
  `Descripcion` varchar(2600) NOT NULL,
  `Ubicacion` varchar(600) DEFAULT NULL,
  `Imagen` varchar(255) NOT NULL DEFAULT 'https://upload.wikimedia.org/wikipedia/commons/0/0e/DefaultImage.png',
  `Categoria` varchar(25) DEFAULT NULL,
  `Hora_Inicio` time DEFAULT NULL,
  `Hora_Fin` time DEFAULT NULL,
  `Estado` enum('Abierto','Cerrado') DEFAULT 'Abierto',
  `telefono` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `sitioturistico`
--

INSERT INTO `sitioturistico` (`ID_Sitio`, `Titulo`, `Descripcion`, `Ubicacion`, `Imagen`, `Categoria`, `Hora_Inicio`, `Hora_Fin`, `Estado`, `telefono`) VALUES
(1, 'Teatro Dámaso Antonio Larrañaga', '', 'Joaquín Suarez 39', 'https://lh3.googleusercontent.com/gps-cs-s/AC9h4npOGBWwBUsDD2PGmKqoLwOWJuOdJCvHqGNMbc8frliOQajdFt7bgTxHu1XC53UNsxa5TlOq35hMhozmmNi4qOUeFn953r1yTfm9gxfoBDuPklYVphKR0sPSk7dwl2O_cdT4rTg=w408-h306-k-no', 'Cultural', NULL, NULL, 'Abierto', 47327224),
(2, 'Plaza Artigas', 'Se permiten perros', 'Artigas 1162', 'https://lh3.googleusercontent.com/gps-cs-s/AC9h4npCS5AnEg10WtIfWwYITHAihjg5PGtYMSA6AITHjq4bzoRsBrOZrUUOg7T5RlCdu2JvJgq2WibW2wWrxcjO3YLDG0AXrqlVGfRBnKfm-DpZqknWuwVFxHGHLybzWrzeKKmI11Dv=w408-h306-k-no', 'Recreativo', NULL, NULL, 'Abierto', 47332430),
(3, 'Complejo Termal San Nicanor', 'Centro termal boutique con aguas naturales que emergen a 40°C. Piscinas techadas y al aire libre con hidromasajes. Spa con tratamientos de barro termal y masajes. Restaurant con vista panorámica.', 'Ruta 3 Km 478, Termas San Nicanor', 'https://images.unsplash.com/photo-1544161515-4ab6ce6db874?w=800&h=500&fit=crop', 'Termas', '08:00:00', '23:00:00', 'Abierto', 47336700),
(4, 'Termas del Arapey', 'Termas del Arapey es una localidad del departamento de Salto, en el Noroeste de Uruguay, a orillas del río Arapey. Se desarrolló en torno a pozos de aguas termales, actualmente explotados turísticamente. Posee una población estable de 256 habitantes.\r\nLas termas del Arapey se encuentran entre uno de los principales atractivos turísticos del país, junto con las termas del Daymán, la capital, el casco histórico de Colonia del Sacramento y la zona costera del territorio nacional, entre otros sitios.', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d109501.26759209967!2d-57.6034623631478!3d-30.944949231635903!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1ses-419!2suy!4v1760020662418!5m2!1ses-419!2suy\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', 'https://lh3.googleusercontent.com/gps-cs-s/AC9h4nqckI9MdZ5qTkEN37aWhczK0p_RcMoSA0e5QknFOxZ_SCjUCC5aX0VSWTTnsX7QKqJegNs-LHQJKUyFoVHSUEaH6EH6UC8nNOweJG80X7lva4H2mltS9FwJuVb8O0FP2mvy2bnL=w408-h306-k-no', 'Termas', '07:00:00', '23:00:00', '', 47332430),
(5, 'Termas del Daymán', 'Termas del Daymán es un centro termal que se halla a 10 kilómetros de la ciudad de Salto, Uruguay, situado a 487 kilómetros de Montevideo y a 440 kilómetros de Buenos Aires.\r\n\r\nSu origen se remonta a 1957, cuando la excavación en la región del Río Daymán, en la búsqueda de reservas petrolíferas, reveló la presencia del Acuífero Guaraní, fuente de aguas termales que alimentan las piscinas climatizadas de la zona.\r\n \r\nParques\r\nSpa Thermal Daymán\r\nHorarios: 10:00 a 22:00 (abierto todos los días).\r\nCosto entrada $250\r\nPresentando voucher de Hotel $200.\r\n - \r\nParque Agua Clara\r\nHorario: 08:00 a 22:00 (abierto todos los días).\r\nCosto General. Lunes a viernes $300\r\nResidentes y huésped de hotel $250\r\n - \r\nParque Municipal Termas del Daymán\r\nHorario: 08:00 a 22:00 (abierto todos los días).\r\nCosto entrada $200 general y $150 residentes.\r\nNiños menores de 12 años $120.\r\nMenores a 6 años gratis.\r\nJubilados y Pensionistas $120.\r\nEntradas en venta en centro termal (tarjeta de débito y crédito) y en locales de\r\ncobranza.\r\n - \r\nAcuamanía\r\nHorario: 10:30 a 18:30\r\nCosto: menores de 3 años no abonan\r\nTarifa general: $650\r\nCon voucher de hotel $550\r\nMenores de 4 a 10 años $480\r\nResidentes $430 (Salto, Paysandú, Colón, Concordia con documento de identidad).', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d13614.820883785334!2d-57.92083150401623!3d-31.449781282317538!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x95addbfde9a99c57%3A0x4fb57ff68cbb2659!2s50000%20Termas%20del%20Dayman%2C%20Departamento%20de%20Salto!5e0!3m2!1ses-419!2suy!4v1760023139891!5m2!1ses-419!2suy\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', 'https://lh3.googleusercontent.com/gps-cs-s/AC9h4nrYKXpdTFBi-8lLRydAj8HowpmaOZ8XtvKAI2jRX2dCwgdW0-h4S_qGsujvCFGVdboyVg-jBfRvq684iSu70LMAtFSgXTUsELt-6u8svpaHDyfaNnEaG3Ff3NN__sLP3FDGnqvF=w495-h240-k-no', 'Termas', '08:00:00', '22:00:00', '', 47369960),
(6, 'Parque Solari', 'Amplio parque público con zona de juegos infantiles, canchas deportivas y espacios verdes. Popular para picnics familiares. Cuenta con parrilleros y sanitarios públicos. Arboleda de eucaliptos centenarios.', 'Av. Harriague y Batlle, Salto', 'https://images.unsplash.com/photo-1469395446868-fb6a048d5ca3?w=800&h=500&fit=crop', 'Recreativo', '06:00:00', '22:00:00', 'Abierto', 47320010),
(7, 'Acuamanía Parque Acuático', 'El primer parque acuático termal de Sudamérica. Toboganes gigantes, río lento climatizado, piscinas de olas y zona infantil. Shows en vivo los fines de semana. Restaurant y vestuarios completos.', 'Ruta 3 Km 487, Termas del Daymán', 'https://images.unsplash.com/photo-1519046904884-53103b34b206?w=800&h=500&fit=crop', 'Termas', '10:00:00', '19:00:00', 'Abierto', 47369960),
(8, 'Bodega Familia Deicas', 'Viñedos orgánicos con producción de vinos premium. Visitas guiadas con degustación incluida. Recorrido por cavas subterráneas y proceso de elaboración. Tienda con venta de vinos y productos gourmet.', 'Ruta 31 Km 15, Zona Rural Salto', 'https://images.unsplash.com/photo-1506377247377-2a5b3b417ebb?w=800&h=500&fit=crop', 'Gastronomico', '09:00:00', '18:00:00', 'Abierto', 47350100),
(9, 'Mirador del Puente Internacional', 'Punto panorámico con vista al Puente Salto Grande que une Uruguay con Argentina. Ideal para fotografías del río Uruguay y la represa. Zona de descanso con bancos y cartelería informativa.', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3478.9!2d-57.92!3d-31.28!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMzHCsDE2JzQ4LjAiUyA1N8KwNTUnMTIuMCJX!5e0!3m2!1ses!2suy!4v1234567892\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\"></iframe>', 'https://images.unsplash.com/photo-1519922639192-e73293ca430e?w=800&h=500&fit=crop', 'RutasMiradores', '00:00:00', '23:59:00', 'Abierto', 0),
(10, 'Casa de la Cultura', 'Espacio cultural municipal con exposiciones permanentes y temporales de arte local. Biblioteca pública, salas de talleres y auditorio. Agenda mensual de actividades gratuitas para toda la familia.', 'Calle Uruguay 783, Centro', 'https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?w=800&h=500&fit=crop', 'Cultural', '08:00:00', '20:00:00', 'Abierto', 47322890),
(11, 'Camping Municipal Salto Chico', 'Camping a orillas del río Uruguay con playa de arena. Parrilleros, sanitarios, proveeduría y zona de camping. Ideal para pesca y deportes náuticos. Alquiler de kayaks y canoas disponible.', 'Costanera Norte, Parque Solari', 'https://images.unsplash.com/photo-1504280390367-361c6d9f38f4?w=800&h=500&fit=crop', 'Recreativo', '07:00:00', '22:00:00', 'Abierto', 47321500),
(12, 'Monumento a la Bandera', 'Escultura icónica ubicada en un espacio verde céntrico. Punto de encuentro popular y lugar histórico para ceremonias cívicas. Iluminación nocturna especial los fines de semana.', 'Plaza Treinta y Tres, Centro Salto', 'https://images.unsplash.com/photo-1513635269975-59663e0ac1ad?w=800&h=500&fit=crop', 'Historico', '00:00:00', '23:59:00', 'Abierto', 0),
(13, 'Paseo de los Artesanos', 'Feria permanente de artesanos locales. Productos en cuero, cerámica, tejidos, orfebrería y dulces caseros. Abierto fines de semana y feriados. Ambiente familiar con música en vivo ocasional.', 'Costanera Sur, Parque García Lorca', 'https://images.unsplash.com/photo-1528698827591-e19ccd7bc23d?w=800&h=500&fit=crop', 'Cultural', '10:00:00', '20:00:00', 'Abierto', 0),
(14, 'Rancho Grande - Parrilla Típica', 'Restaurante tradicional especializado en asado al estilo uruguayo. Carnes de primera calidad a leña. Amplio salón con capacidad para grupos. Menú infantil disponible. Reservas recomendadas fines de semana.', 'Av. Batlle y Ordóñez 850', 'https://images.unsplash.com/photo-1544025162-d76694265947?w=800&h=500&fit=crop', 'Gastronomico', '11:00:00', '23:00:00', 'Abierto', 47323456),
(15, 'Parque Acuático Aquapark', 'Complejo termal con toboganes de alta velocidad, piscinas climatizadas y río de corriente. Zona exclusiva para adultos con jacuzzis. Bar acuático y snack bar. Estacionamiento amplio sin cargo.', 'Termas de Salto Grande, Ruta 2', 'https://images.unsplash.com/photo-1575429198097-0414ec08e8cd?w=800&h=500&fit=crop', 'Termas', '09:00:00', '21:00:00', 'Abierto', 47332430),
(16, 'Sendero Ecológico Parque del Lago', 'Circuito de trekking de 5km bordeando el lago artificial de Salto Grande. Observación de aves nativas y flora autóctona. Miradores panorámicos cada 1km. Dificultad baja, apto para toda la familia.', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6957.1!2d-57.95!3d-31.30!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMzHCsDE4JzAwLjAiUyA1N8KwNTcnMDAuMCJX!5e0!3m2!1ses!2suy!4v1234567893\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\"></iframe>', 'https://images.unsplash.com/photo-1551632811-561732d1e306?w=800&h=500&fit=crop', 'Naturaleza', '06:00:00', '19:00:00', 'Abierto', 0),
(17, 'Club Náutico Salto', 'Instalaciones deportivas con amarres para embarcaciones, escuela de vela y remo. Restaurant con terraza sobre el río. Organiza competencias y cursos de navegación. Membresía requerida para algunas actividades.', 'Costanera Norte Km 2', 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=800&h=500&fit=crop', 'Deporte', '08:00:00', '20:00:00', 'Abierto', 47324567),
(18, 'Termas del Arapey Complejo Termal', 'Complejo termal histórico con aguas que emergen a 38°C. Múltiples piscinas al aire libre y techadas. Hoteles de distintas categorías dentro del predio. Ambiente tranquilo ideal para descanso y relajación.', 'Ruta 3 Km 70, Termas del Arapey', 'https://images.unsplash.com/photo-1571902943202-507ec2618e8f?w=800&h=500&fit=crop', 'Termas', '07:00:00', '23:00:00', 'Abierto', 47732000),
(19, 'Complejo Deportivo Ernesto Dickinson', 'Polideportivo municipal con canchas de fútbol, básquet, vóley y atletismo. Pista de atletismo homologada. Gimnasio con equipamiento moderno. Clases grupales y personalizadas. Inscripciones abiertas todo el año.', 'Av. Harriague 2100', 'https://images.unsplash.com/photo-1576678927484-cc907957088c?w=800&h=500&fit=crop', 'Deporte', '07:00:00', '22:00:00', 'Abierto', 47325678),
(20, 'Playa Arenitas Blancas', 'Playa sobre el río Uruguay con arena fina y aguas calmas. Ideal para familias con niños. Cuenta con parador, alquiler de sombrillas y juegos infantiles. Vigilancia durante temporada estival. Estacionamiento gratuito.', 'Costanera Sur, Salto', 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=800&h=500&fit=crop', 'Recreativo', '08:00:00', '20:00:00', 'Abierto', 0),
(22, 'Hotel Casino Horacio Quiroga', 'Hotel cinco estrellas con casino, spa termal y múltiples restaurantes. Ubicado en complejo termal Salto Grande. Sala de juegos con ruleta, blackjack y máquinas tragamonedas. Shows en vivo los fines de semana.', 'Termas de Salto Grande', 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=800&h=500&fit=crop', 'Alojamiento', '00:00:00', '23:59:00', 'Abierto', 47332430),
(23, 'Posada del Daymán', 'Alojamiento familiar con piscinas termales privadas. Habitaciones con termas individuales. Desayuno incluido con productos caseros. Ambiente tranquilo rodeado de naturaleza. Estacionamiento gratuito.', 'Termas del Daymán, Ruta 3', 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=800&h=500&fit=crop', 'Alojamiento', '00:00:00', '23:59:00', 'Abierto', 47369800);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administra`
--
ALTER TABLE `administra`
  ADD KEY `Cédula` (`Cédula`),
  ADD KEY `ID_Evento` (`ID_Evento`),
  ADD KEY `ID_Administrador` (`ID_Administrador`);

--
-- Indices de la tabla `administradores`
--
ALTER TABLE `administradores`
  ADD PRIMARY KEY (`ID_Administrador`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`ID_Cliente`),
  ADD UNIQUE KEY `Correo` (`Correo`);

--
-- Indices de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`ID_Comentario`),
  ADD KEY `ID_Cliente` (`ID_Cliente`),
  ADD KEY `Cédula` (`Cédula`),
  ADD KEY `ID_Evento_2` (`ID_Evento`),
  ADD KEY `idx_evento` (`ID_Evento`),
  ADD KEY `ID_Sitio` (`ID_Sitio`);

--
-- Indices de la tabla `eventos`
--
ALTER TABLE `eventos`
  ADD PRIMARY KEY (`ID_Evento`),
  ADD KEY `Cédula` (`Cédula`);

--
-- Indices de la tabla `organizadores`
--
ALTER TABLE `organizadores`
  ADD PRIMARY KEY (`Cedula`),
  ADD UNIQUE KEY `ID_Cliente` (`ID_Cliente`) USING BTREE,
  ADD UNIQUE KEY `RUT` (`RUT`);

--
-- Indices de la tabla `respondercomentario`
--
ALTER TABLE `respondercomentario`
  ADD PRIMARY KEY (`comentario_responder`),
  ADD KEY `ID_Cliente` (`ID_Cliente`),
  ADD KEY `fk_ID_Comentario` (`ID_Comentario`);

--
-- Indices de la tabla `sitioturistico`
--
ALTER TABLE `sitioturistico`
  ADD PRIMARY KEY (`ID_Sitio`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `administradores`
--
ALTER TABLE `administradores`
  MODIFY `ID_Administrador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `ID_Cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `ID_Comentario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `eventos`
--
ALTER TABLE `eventos`
  MODIFY `ID_Evento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `respondercomentario`
--
ALTER TABLE `respondercomentario`
  MODIFY `comentario_responder` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `sitioturistico`
--
ALTER TABLE `sitioturistico`
  MODIFY `ID_Sitio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `administra`
--
ALTER TABLE `administra`
  ADD CONSTRAINT `administra_ibfk_1` FOREIGN KEY (`Cédula`) REFERENCES `organizadores` (`Cedula`),
  ADD CONSTRAINT `administra_ibfk_10` FOREIGN KEY (`Cédula`) REFERENCES `organizadores` (`Cedula`),
  ADD CONSTRAINT `administra_ibfk_11` FOREIGN KEY (`ID_Evento`) REFERENCES `eventos` (`ID_Evento`),
  ADD CONSTRAINT `administra_ibfk_12` FOREIGN KEY (`ID_Administrador`) REFERENCES `administradores` (`ID_Administrador`),
  ADD CONSTRAINT `administra_ibfk_13` FOREIGN KEY (`Cédula`) REFERENCES `organizadores` (`Cedula`),
  ADD CONSTRAINT `administra_ibfk_14` FOREIGN KEY (`ID_Evento`) REFERENCES `eventos` (`ID_Evento`),
  ADD CONSTRAINT `administra_ibfk_15` FOREIGN KEY (`ID_Administrador`) REFERENCES `administradores` (`ID_Administrador`),
  ADD CONSTRAINT `administra_ibfk_16` FOREIGN KEY (`Cédula`) REFERENCES `organizadores` (`Cedula`),
  ADD CONSTRAINT `administra_ibfk_17` FOREIGN KEY (`ID_Evento`) REFERENCES `eventos` (`ID_Evento`),
  ADD CONSTRAINT `administra_ibfk_18` FOREIGN KEY (`ID_Administrador`) REFERENCES `administradores` (`ID_Administrador`),
  ADD CONSTRAINT `administra_ibfk_19` FOREIGN KEY (`Cédula`) REFERENCES `organizadores` (`Cedula`),
  ADD CONSTRAINT `administra_ibfk_2` FOREIGN KEY (`ID_Evento`) REFERENCES `eventos` (`ID_Evento`),
  ADD CONSTRAINT `administra_ibfk_20` FOREIGN KEY (`ID_Evento`) REFERENCES `eventos` (`ID_Evento`),
  ADD CONSTRAINT `administra_ibfk_21` FOREIGN KEY (`ID_Administrador`) REFERENCES `administradores` (`ID_Administrador`),
  ADD CONSTRAINT `administra_ibfk_22` FOREIGN KEY (`Cédula`) REFERENCES `organizadores` (`Cedula`),
  ADD CONSTRAINT `administra_ibfk_23` FOREIGN KEY (`ID_Evento`) REFERENCES `eventos` (`ID_Evento`),
  ADD CONSTRAINT `administra_ibfk_24` FOREIGN KEY (`ID_Administrador`) REFERENCES `administradores` (`ID_Administrador`),
  ADD CONSTRAINT `administra_ibfk_25` FOREIGN KEY (`Cédula`) REFERENCES `organizadores` (`Cedula`),
  ADD CONSTRAINT `administra_ibfk_26` FOREIGN KEY (`ID_Evento`) REFERENCES `eventos` (`ID_Evento`),
  ADD CONSTRAINT `administra_ibfk_27` FOREIGN KEY (`ID_Administrador`) REFERENCES `administradores` (`ID_Administrador`),
  ADD CONSTRAINT `administra_ibfk_28` FOREIGN KEY (`Cédula`) REFERENCES `organizadores` (`Cedula`),
  ADD CONSTRAINT `administra_ibfk_29` FOREIGN KEY (`ID_Evento`) REFERENCES `eventos` (`ID_Evento`),
  ADD CONSTRAINT `administra_ibfk_3` FOREIGN KEY (`Cédula`) REFERENCES `organizadores` (`Cedula`),
  ADD CONSTRAINT `administra_ibfk_30` FOREIGN KEY (`ID_Administrador`) REFERENCES `administradores` (`ID_Administrador`),
  ADD CONSTRAINT `administra_ibfk_31` FOREIGN KEY (`Cédula`) REFERENCES `organizadores` (`Cedula`),
  ADD CONSTRAINT `administra_ibfk_32` FOREIGN KEY (`ID_Evento`) REFERENCES `eventos` (`ID_Evento`),
  ADD CONSTRAINT `administra_ibfk_33` FOREIGN KEY (`ID_Administrador`) REFERENCES `administradores` (`ID_Administrador`),
  ADD CONSTRAINT `administra_ibfk_34` FOREIGN KEY (`Cédula`) REFERENCES `organizadores` (`Cedula`),
  ADD CONSTRAINT `administra_ibfk_35` FOREIGN KEY (`ID_Evento`) REFERENCES `eventos` (`ID_Evento`),
  ADD CONSTRAINT `administra_ibfk_36` FOREIGN KEY (`ID_Administrador`) REFERENCES `administradores` (`ID_Administrador`),
  ADD CONSTRAINT `administra_ibfk_4` FOREIGN KEY (`ID_Evento`) REFERENCES `eventos` (`ID_Evento`),
  ADD CONSTRAINT `administra_ibfk_5` FOREIGN KEY (`Cédula`) REFERENCES `organizadores` (`Cedula`),
  ADD CONSTRAINT `administra_ibfk_6` FOREIGN KEY (`ID_Evento`) REFERENCES `eventos` (`ID_Evento`),
  ADD CONSTRAINT `administra_ibfk_7` FOREIGN KEY (`Cédula`) REFERENCES `organizadores` (`Cedula`),
  ADD CONSTRAINT `administra_ibfk_8` FOREIGN KEY (`ID_Evento`) REFERENCES `eventos` (`ID_Evento`),
  ADD CONSTRAINT `administra_ibfk_9` FOREIGN KEY (`ID_Administrador`) REFERENCES `administradores` (`ID_Administrador`);

--
-- Filtros para la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD CONSTRAINT `comentarios_ibfk_1` FOREIGN KEY (`ID_Cliente`) REFERENCES `cliente` (`ID_Cliente`),
  ADD CONSTRAINT `comentarios_ibfk_10` FOREIGN KEY (`ID_Cliente`) REFERENCES `cliente` (`ID_Cliente`),
  ADD CONSTRAINT `comentarios_ibfk_11` FOREIGN KEY (`ID_Cliente`) REFERENCES `cliente` (`ID_Cliente`),
  ADD CONSTRAINT `comentarios_ibfk_12` FOREIGN KEY (`ID_Cliente`) REFERENCES `cliente` (`ID_Cliente`),
  ADD CONSTRAINT `comentarios_ibfk_13` FOREIGN KEY (`ID_Cliente`) REFERENCES `cliente` (`ID_Cliente`),
  ADD CONSTRAINT `comentarios_ibfk_14` FOREIGN KEY (`Cédula`) REFERENCES `organizadores` (`Cedula`),
  ADD CONSTRAINT `comentarios_ibfk_15` FOREIGN KEY (`ID_Sitio`) REFERENCES `sitioturistico` (`ID_Sitio`),
  ADD CONSTRAINT `comentarios_ibfk_2` FOREIGN KEY (`ID_Cliente`) REFERENCES `cliente` (`ID_Cliente`),
  ADD CONSTRAINT `comentarios_ibfk_3` FOREIGN KEY (`ID_Cliente`) REFERENCES `cliente` (`ID_Cliente`),
  ADD CONSTRAINT `comentarios_ibfk_4` FOREIGN KEY (`ID_Cliente`) REFERENCES `cliente` (`ID_Cliente`),
  ADD CONSTRAINT `comentarios_ibfk_5` FOREIGN KEY (`ID_Cliente`) REFERENCES `cliente` (`ID_Cliente`),
  ADD CONSTRAINT `comentarios_ibfk_6` FOREIGN KEY (`ID_Cliente`) REFERENCES `cliente` (`ID_Cliente`),
  ADD CONSTRAINT `comentarios_ibfk_7` FOREIGN KEY (`ID_Cliente`) REFERENCES `cliente` (`ID_Cliente`),
  ADD CONSTRAINT `comentarios_ibfk_8` FOREIGN KEY (`ID_Cliente`) REFERENCES `cliente` (`ID_Cliente`),
  ADD CONSTRAINT `comentarios_ibfk_9` FOREIGN KEY (`ID_Cliente`) REFERENCES `cliente` (`ID_Cliente`);

--
-- Filtros para la tabla `eventos`
--
ALTER TABLE `eventos`
  ADD CONSTRAINT `eventos_ibfk_1` FOREIGN KEY (`Cédula`) REFERENCES `organizadores` (`Cedula`);

--
-- Filtros para la tabla `organizadores`
--
ALTER TABLE `organizadores`
  ADD CONSTRAINT `organizadores_ibfk_1` FOREIGN KEY (`ID_Cliente`) REFERENCES `cliente` (`ID_Cliente`),
  ADD CONSTRAINT `organizadores_ibfk_10` FOREIGN KEY (`ID_Cliente`) REFERENCES `cliente` (`ID_Cliente`),
  ADD CONSTRAINT `organizadores_ibfk_11` FOREIGN KEY (`ID_Cliente`) REFERENCES `cliente` (`ID_Cliente`),
  ADD CONSTRAINT `organizadores_ibfk_12` FOREIGN KEY (`ID_Cliente`) REFERENCES `cliente` (`ID_Cliente`),
  ADD CONSTRAINT `organizadores_ibfk_13` FOREIGN KEY (`ID_Cliente`) REFERENCES `cliente` (`ID_Cliente`),
  ADD CONSTRAINT `organizadores_ibfk_2` FOREIGN KEY (`ID_Cliente`) REFERENCES `cliente` (`ID_Cliente`),
  ADD CONSTRAINT `organizadores_ibfk_3` FOREIGN KEY (`ID_Cliente`) REFERENCES `cliente` (`ID_Cliente`),
  ADD CONSTRAINT `organizadores_ibfk_4` FOREIGN KEY (`ID_Cliente`) REFERENCES `cliente` (`ID_Cliente`),
  ADD CONSTRAINT `organizadores_ibfk_5` FOREIGN KEY (`ID_Cliente`) REFERENCES `cliente` (`ID_Cliente`),
  ADD CONSTRAINT `organizadores_ibfk_6` FOREIGN KEY (`ID_Cliente`) REFERENCES `cliente` (`ID_Cliente`),
  ADD CONSTRAINT `organizadores_ibfk_7` FOREIGN KEY (`ID_Cliente`) REFERENCES `cliente` (`ID_Cliente`),
  ADD CONSTRAINT `organizadores_ibfk_8` FOREIGN KEY (`ID_Cliente`) REFERENCES `cliente` (`ID_Cliente`),
  ADD CONSTRAINT `organizadores_ibfk_9` FOREIGN KEY (`ID_Cliente`) REFERENCES `cliente` (`ID_Cliente`);

--
-- Filtros para la tabla `respondercomentario`
--
ALTER TABLE `respondercomentario`
  ADD CONSTRAINT `fk_ID_Comentario` FOREIGN KEY (`ID_Comentario`) REFERENCES `comentarios` (`ID_Comentario`) ON DELETE CASCADE,
  ADD CONSTRAINT `respondercomentario_ibfk_1` FOREIGN KEY (`ID_Comentario`) REFERENCES `comentarios` (`ID_Comentario`),
  ADD CONSTRAINT `respondercomentario_ibfk_2` FOREIGN KEY (`ID_Cliente`) REFERENCES `cliente` (`ID_Cliente`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-09-2025 a las 15:54:18
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
  `cedula` varchar(10) DEFAULT NULL,
  `id_evento` int(11) DEFAULT NULL,
  `id_administrador` int(11) DEFAULT NULL,
  `organizador_verificado` tinyint(1) DEFAULT NULL,
  `evento_verificado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `administra`
--

INSERT INTO `administra` (`cedula`, `id_evento`, `id_administrador`, `organizador_verificado`, `evento_verificado`) VALUES
('12345678', 1, 1, 1, 1),
('87654321', 2, 2, 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administradores`
--

CREATE TABLE `administradores` (
  `id_administrador` int(11) NOT NULL,
  `telefono` varchar(25) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT NULL,
  `nombre` varchar(25) NOT NULL,
  `apellido` varchar(25) NOT NULL,
  `correo` varchar(50) DEFAULT NULL,
  `contrasena` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `administradores`
--

INSERT INTO `administradores` (`id_administrador`, `telefono`, `activo`, `nombre`, `apellido`, `correo`, `contrasena`) VALUES
(1, '099123456', 1, 'Ana', 'López', 'ana.lopez@gmail.com', 'adminana'),
(2, '098987654', 0, 'Jorge', 'Martínez', 'jorge.martinez@gmail.com', 'adminjorge');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `id_cliente` int(11) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `apellido` varchar(20) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `contrasena` varchar(25) NOT NULL,
  `registro` date DEFAULT current_timestamp(),
  `imag_perfil` varchar(255) DEFAULT 'https://cdn-icons-png.flaticon.com/512/6378/6378141.png',
  `bloquear` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`id_cliente`, `nombre`, `apellido`, `correo`, `contrasena`, `registro`, `imag_perfil`, `bloquear`) VALUES
(1, 'Lucía', 'Pérez', 'lucia.perez@gmail.com', 'lucia123', '2025-06-01', 'https://images.pexels.com/photos/29026195/pexels-photo-29026195/free-photo-of-mujer-serena-relajandose-junto-al-rio.jpeg', 0),
(2, 'Carlos', 'Gómez', 'carlos.gomez@gmail.com', 'carlos456', '2025-06-02', NULL, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios`
--

CREATE TABLE `comentarios` (
  `id_comentario` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_evento` int(11) DEFAULT NULL,
  `likes` int(4) DEFAULT 0,
  `texto` varchar(250) DEFAULT NULL,
  `creacion_comentario` datetime DEFAULT current_timestamp(),
  `cedula` varchar(10) DEFAULT NULL,
  `usuarios_like` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `comentarios`
--

INSERT INTO `comentarios` (`id_comentario`, `id_cliente`, `id_evento`, `likes`, `texto`, `creacion_comentario`, `cedula`, `usuarios_like`) VALUES
(1, 1, 1, 12, 'Muy buen ambiente y productos.', '2025-06-11 00:00:00', NULL, NULL),
(2, 2, 2, 9, 'Excelente sonido y organización.', '2025-06-16 00:00:00', NULL, NULL),
(3, 2, 1, 10, 'Muy limpio y ordenado', '2025-09-27 00:00:00', NULL, '1'),
(6, 1, 5, NULL, 'Primer comentario', '2025-09-03 19:27:06', NULL, NULL),
(8, 1, 5, NULL, 'Primer comentario', '2025-09-03 19:29:14', NULL, NULL),
(9, 1, 5, NULL, 'Segundo comentario', '2025-09-03 19:29:14', NULL, NULL),
(10, 1, 1, 0, 'me gustó mucho xd', '2025-09-15 16:33:19', NULL, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eventos`
--

CREATE TABLE `eventos` (
  `id_evento` int(11) NOT NULL,
  `titulo` varchar(50) NOT NULL,
  `descripcion` varchar(200) NOT NULL,
  `creacion_evento` date DEFAULT current_timestamp(),
  `ubicacion` varchar(50) DEFAULT NULL,
  `cedula` varchar(10) DEFAULT NULL,
  `hora` time DEFAULT NULL,
  `imagen` varchar(255) NOT NULL DEFAULT 'https://upload.wikimedia.org/wikipedia/commons/0/0e/DefaultImage.png',
  `categoria` varchar(25) DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `eventos`
--

INSERT INTO `eventos` (`id_evento`, `titulo`, `descripcion`, `creacion_evento`, `ubicacion`, `cedula`, `hora`, `imagen`, `categoria`, `fecha_inicio`, `fecha_fin`) VALUES
(1, 'Feria de Artesanos', 'Evento cultural con productos locales.', '2025-06-10', 'Plaza Artigas', '12345678', '12:00:00', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTQZeYDEJsUpT3ezV087qItQsAA6AK-5sRm4Q&s', 'Otros', '2025-08-30', NULL),
(2, 'Concierto de Rock', 'Banda local en vivo.', '2025-06-15', 'Teatro Larrañaga', '87654321', '21:30:00', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSzNOofyD4Mr6H45aMbkOV9nVoykLczluR1Pw&s', 'Música', '2026-01-02', NULL),
(3, 'Fiesta de Aaron', 'Festejamos el cumple de Aaron', '2025-08-29', 'Casa de Aaron', '12345678', '00:00:00', 'https://upload.wikimedia.org/wikipedia/commons/0/0e/DefaultImage.png', 'Otros', '2025-09-10', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `organizadores`
--

CREATE TABLE `organizadores` (
  `cedula` varchar(10) NOT NULL,
  `rut` varchar(15) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `id_cliente` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `organizadores`
--

INSERT INTO `organizadores` (`cedula`, `rut`, `telefono`, `id_cliente`) VALUES
('12345678', '12345678901', '099111222', 1),
('87654321', '98765432109', '098222111', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respondercomentario`
--

CREATE TABLE `respondercomentario` (
  `comentario_responder` int(11) NOT NULL,
  `respuesta` text NOT NULL,
  `id_comentario` int(11) NOT NULL,
  `creacion_respuesta` datetime DEFAULT current_timestamp(),
  `id_cliente` int(11) NOT NULL,
  `likesres` int(11) NOT NULL DEFAULT 0,
  `usuarios_like_res` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `respondercomentario`
--

INSERT INTO `respondercomentario` (`comentario_responder`, `respuesta`, `id_comentario`, `creacion_respuesta`, `id_cliente`, `likesres`, `usuarios_like_res`) VALUES
(1, 'n', 1, '2025-09-15 16:32:27', 1, 0, NULL),
(2, 'CUALQUIERAs', 3, '2025-09-15 16:45:00', 1, 1, '1'),
(3, 'waow', 1, '2025-09-15 17:36:15', 1, 3, '1'),
(4, 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Culpa eligendi animi repellat deserunt libero dolor voluptas nesciunt, nihil quis doloribus ducimus reiciendis cum magni corporis facere ratione recusandae cumque dolores.', 1, '2025-09-15 17:37:02', 1, 0, NULL),
(5, 'quien sos lucia?? que haces comentando la pagina de mi noviO?', 1, '2025-09-16 09:37:45', 1, 1, '1');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administra`
--
ALTER TABLE `administra`
  ADD KEY `Cédula` (`cedula`),
  ADD KEY `ID_Evento` (`id_evento`),
  ADD KEY `ID_Administrador` (`id_administrador`);

--
-- Indices de la tabla `administradores`
--
ALTER TABLE `administradores`
  ADD PRIMARY KEY (`id_administrador`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id_cliente`),
  ADD UNIQUE KEY `Correo` (`correo`);

--
-- Indices de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`id_comentario`),
  ADD KEY `ID_Cliente` (`id_cliente`),
  ADD KEY `Cédula` (`cedula`),
  ADD KEY `ID_Evento_2` (`id_evento`),
  ADD KEY `idx_evento` (`id_evento`);

--
-- Indices de la tabla `eventos`
--
ALTER TABLE `eventos`
  ADD PRIMARY KEY (`id_evento`),
  ADD KEY `Cédula` (`cedula`);

--
-- Indices de la tabla `organizadores`
--
ALTER TABLE `organizadores`
  ADD PRIMARY KEY (`cedula`),
  ADD UNIQUE KEY `ID_Cliente` (`id_cliente`) USING BTREE,
  ADD UNIQUE KEY `RUT` (`rut`);

--
-- Indices de la tabla `respondercomentario`
--
ALTER TABLE `respondercomentario`
  ADD PRIMARY KEY (`comentario_responder`),
  ADD KEY `ID_Comentario` (`id_comentario`),
  ADD KEY `ID_Cliente` (`id_cliente`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `administra`
--
ALTER TABLE `administra`
  ADD CONSTRAINT `administra_ibfk_1` FOREIGN KEY (`cedula`) REFERENCES `organizadores` (`Cedula`),
  ADD CONSTRAINT `administra_ibfk_10` FOREIGN KEY (`cedula`) REFERENCES `organizadores` (`Cedula`),
  ADD CONSTRAINT `administra_ibfk_11` FOREIGN KEY (`ID_Evento`) REFERENCES `eventos` (`ID_Evento`),
  ADD CONSTRAINT `administra_ibfk_12` FOREIGN KEY (`ID_Administrador`) REFERENCES `administradores` (`ID_Administrador`),
  ADD CONSTRAINT `administra_ibfk_13` FOREIGN KEY (`cedula`) REFERENCES `organizadores` (`Cedula`),
  ADD CONSTRAINT `administra_ibfk_14` FOREIGN KEY (`ID_Evento`) REFERENCES `eventos` (`ID_Evento`),
  ADD CONSTRAINT `administra_ibfk_15` FOREIGN KEY (`ID_Administrador`) REFERENCES `administradores` (`ID_Administrador`),
  ADD CONSTRAINT `administra_ibfk_16` FOREIGN KEY (`cedula`) REFERENCES `organizadores` (`Cedula`),
  ADD CONSTRAINT `administra_ibfk_17` FOREIGN KEY (`ID_Evento`) REFERENCES `eventos` (`ID_Evento`),
  ADD CONSTRAINT `administra_ibfk_18` FOREIGN KEY (`ID_Administrador`) REFERENCES `administradores` (`ID_Administrador`),
  ADD CONSTRAINT `administra_ibfk_19` FOREIGN KEY (`cedula`) REFERENCES `organizadores` (`Cedula`),
  ADD CONSTRAINT `administra_ibfk_2` FOREIGN KEY (`ID_Evento`) REFERENCES `eventos` (`ID_Evento`),
  ADD CONSTRAINT `administra_ibfk_20` FOREIGN KEY (`ID_Evento`) REFERENCES `eventos` (`ID_Evento`),
  ADD CONSTRAINT `administra_ibfk_21` FOREIGN KEY (`ID_Administrador`) REFERENCES `administradores` (`ID_Administrador`),
  ADD CONSTRAINT `administra_ibfk_22` FOREIGN KEY (`cedula`) REFERENCES `organizadores` (`Cedula`),
  ADD CONSTRAINT `administra_ibfk_23` FOREIGN KEY (`ID_Evento`) REFERENCES `eventos` (`ID_Evento`),
  ADD CONSTRAINT `administra_ibfk_24` FOREIGN KEY (`ID_Administrador`) REFERENCES `administradores` (`ID_Administrador`),
  ADD CONSTRAINT `administra_ibfk_25` FOREIGN KEY (`cedula`) REFERENCES `organizadores` (`Cedula`),
  ADD CONSTRAINT `administra_ibfk_26` FOREIGN KEY (`ID_Evento`) REFERENCES `eventos` (`ID_Evento`),
  ADD CONSTRAINT `administra_ibfk_27` FOREIGN KEY (`ID_Administrador`) REFERENCES `administradores` (`ID_Administrador`),
  ADD CONSTRAINT `administra_ibfk_28` FOREIGN KEY (`cedula`) REFERENCES `organizadores` (`Cedula`),
  ADD CONSTRAINT `administra_ibfk_29` FOREIGN KEY (`ID_Evento`) REFERENCES `eventos` (`ID_Evento`),
  ADD CONSTRAINT `administra_ibfk_3` FOREIGN KEY (`cedula`) REFERENCES `organizadores` (`Cedula`),
  ADD CONSTRAINT `administra_ibfk_30` FOREIGN KEY (`ID_Administrador`) REFERENCES `administradores` (`ID_Administrador`),
  ADD CONSTRAINT `administra_ibfk_31` FOREIGN KEY (`cedula`) REFERENCES `organizadores` (`Cedula`),
  ADD CONSTRAINT `administra_ibfk_32` FOREIGN KEY (`ID_Evento`) REFERENCES `eventos` (`ID_Evento`),
  ADD CONSTRAINT `administra_ibfk_33` FOREIGN KEY (`ID_Administrador`) REFERENCES `administradores` (`ID_Administrador`),
  ADD CONSTRAINT `administra_ibfk_34` FOREIGN KEY (`cedula`) REFERENCES `organizadores` (`Cedula`),
  ADD CONSTRAINT `administra_ibfk_35` FOREIGN KEY (`ID_Evento`) REFERENCES `eventos` (`ID_Evento`),
  ADD CONSTRAINT `administra_ibfk_36` FOREIGN KEY (`ID_Administrador`) REFERENCES `administradores` (`ID_Administrador`),
  ADD CONSTRAINT `administra_ibfk_4` FOREIGN KEY (`ID_Evento`) REFERENCES `eventos` (`ID_Evento`),
  ADD CONSTRAINT `administra_ibfk_5` FOREIGN KEY (`cedula`) REFERENCES `organizadores` (`Cedula`),
  ADD CONSTRAINT `administra_ibfk_6` FOREIGN KEY (`ID_Evento`) REFERENCES `eventos` (`ID_Evento`),
  ADD CONSTRAINT `administra_ibfk_7` FOREIGN KEY (`cedula`) REFERENCES `organizadores` (`Cedula`),
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
  ADD CONSTRAINT `comentarios_ibfk_14` FOREIGN KEY (`cedula`) REFERENCES `organizadores` (`Cedula`),
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
  ADD CONSTRAINT `eventos_ibfk_1` FOREIGN KEY (`cedula`) REFERENCES `organizadores` (`Cedula`);

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
  ADD CONSTRAINT `respondercomentario_ibfk_1` FOREIGN KEY (`ID_Comentario`) REFERENCES `comentarios` (`ID_Comentario`),
  ADD CONSTRAINT `respondercomentario_ibfk_2` FOREIGN KEY (`ID_Cliente`) REFERENCES `cliente` (`ID_Cliente`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

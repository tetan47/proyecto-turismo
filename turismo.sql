-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-10-2025 a las 18:19:10
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
(7, 'pedro', 'gallino', 'pedrogallino@gmail.com', 'pedrogallino', '2025-10-03', 'https://cdn-icons-png.flaticon.com/512/6378/6378141.png', 0);

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
  `Ubicacion` varchar(50) DEFAULT NULL,
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
(4, 'Prueba 4', 'xd', 0, '2025-11-21', 'Casa de Aaron', '12345678', '00:00:00', 'https://upload.wikimedia.org/wikipedia/commons/0/0e/DefaultImage.png', 'Otros', '2025-11-21', NULL);

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
(4, 'Termas del Arapey', 'Termas del Arapey es una localidad del departamento de Salto, en el Noroeste de Uruguay, a orillas del río Arapey. Se desarrolló en torno a pozos de aguas termales, actualmente explotados turísticamente. Posee una población estable de 256 habitantes.\r\nLas termas del Arapey se encuentran entre uno de los principales atractivos turísticos del país, junto con las termas del Daymán, la capital, el casco histórico de Colonia del Sacramento y la zona costera del territorio nacional, entre otros sitios.', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d109501.26759209967!2d-57.6034623631478!3d-30.944949231635903!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1ses-419!2suy!4v1760020662418!5m2!1ses-419!2suy\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', 'https://lh3.googleusercontent.com/gps-cs-s/AC9h4nqckI9MdZ5qTkEN37aWhczK0p_RcMoSA0e5QknFOxZ_SCjUCC5aX0VSWTTnsX7QKqJegNs-LHQJKUyFoVHSUEaH6EH6UC8nNOweJG80X7lva4H2mltS9FwJuVb8O0FP2mvy2bnL=w408-h306-k-no', 'Termas', '07:00:00', '23:00:00', '', 47332430),
(5, 'Termas del Daymán', 'Termas del Daymán es un centro termal que se halla a 10 kilómetros de la ciudad de Salto, Uruguay, situado a 487 kilómetros de Montevideo y a 440 kilómetros de Buenos Aires.\r\n\r\nSu origen se remonta a 1957, cuando la excavación en la región del Río Daymán, en la búsqueda de reservas petrolíferas, reveló la presencia del Acuífero Guaraní, fuente de aguas termales que alimentan las piscinas climatizadas de la zona.\r\n \r\nParques\r\nSpa Thermal Daymán\r\nHorarios: 10:00 a 22:00 (abierto todos los días).\r\nCosto entrada $250\r\nPresentando voucher de Hotel $200.\r\n - \r\nParque Agua Clara\r\nHorario: 08:00 a 22:00 (abierto todos los días).\r\nCosto General. Lunes a viernes $300\r\nResidentes y huésped de hotel $250\r\n - \r\nParque Municipal Termas del Daymán\r\nHorario: 08:00 a 22:00 (abierto todos los días).\r\nCosto entrada $200 general y $150 residentes.\r\nNiños menores de 12 años $120.\r\nMenores a 6 años gratis.\r\nJubilados y Pensionistas $120.\r\nEntradas en venta en centro termal (tarjeta de débito y crédito) y en locales de\r\ncobranza.\r\n - \r\nAcuamanía\r\nHorario: 10:30 a 18:30\r\nCosto: menores de 3 años no abonan\r\nTarifa general: $650\r\nCon voucher de hotel $550\r\nMenores de 4 a 10 años $480\r\nResidentes $430 (Salto, Paysandú, Colón, Concordia con documento de identidad).', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d13614.820883785334!2d-57.92083150401623!3d-31.449781282317538!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x95addbfde9a99c57%3A0x4fb57ff68cbb2659!2s50000%20Termas%20del%20Dayman%2C%20Departamento%20de%20Salto!5e0!3m2!1ses-419!2suy!4v1760023139891!5m2!1ses-419!2suy\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', 'https://lh3.googleusercontent.com/gps-cs-s/AC9h4nrYKXpdTFBi-8lLRydAj8HowpmaOZ8XtvKAI2jRX2dCwgdW0-h4S_qGsujvCFGVdboyVg-jBfRvq684iSu70LMAtFSgXTUsELt-6u8svpaHDyfaNnEaG3Ff3NN__sLP3FDGnqvF=w495-h240-k-no', 'Termas', '08:00:00', '22:00:00', '', 47369960);

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
  MODIFY `ID_Cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `ID_Comentario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `eventos`
--
ALTER TABLE `eventos`
  MODIFY `ID_Evento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `respondercomentario`
--
ALTER TABLE `respondercomentario`
  MODIFY `comentario_responder` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `sitioturistico`
--
ALTER TABLE `sitioturistico`
  MODIFY `ID_Sitio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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

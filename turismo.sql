-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-08-2025 a las 00:23:53
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
  `Registro` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`ID_Cliente`, `Nombre`, `Apellido`, `Correo`, `Contraseña`, `Registro`) VALUES
(1, 'Lucía', 'Pérez', 'lucia.perez@gmail.com', 'lucia123', '2025-06-01'),
(2, 'Carlos', 'Gómez', 'carlos.gomez@gmail.com', 'carlos456', '2025-06-02');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios`
--

CREATE TABLE `comentarios` (
  `ID_Comentario` int(11) NOT NULL,
  `ID_Cliente` int(11) DEFAULT NULL,
  `ID_Evento` int(11) DEFAULT NULL,
  `Valoración` tinyint(4) DEFAULT NULL CHECK (`Valoración` between 1 and 10),
  `Texto` varchar(250) DEFAULT NULL,
  `Creación_Comentario` date DEFAULT NULL,
  `Cédula` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `comentarios`
--

INSERT INTO `comentarios` (`ID_Comentario`, `ID_Cliente`, `ID_Evento`, `Valoración`, `Texto`, `Creación_Comentario`, `Cédula`) VALUES
(1, 1, 1, 8, 'Muy buen ambiente y productos.', '2025-06-11', NULL),
(2, 2, 2, 9, 'Excelente sonido y organización.', '2025-06-16', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eventos`
--

CREATE TABLE `eventos` (
  `ID_Evento` int(11) NOT NULL,
  `Título` varchar(50) NOT NULL,
  `Descripción` varchar(200) NOT NULL,
  `Creacion_Evento` date DEFAULT NULL,
  `Ubicacion` varchar(50) DEFAULT NULL,
  `Cédula` varchar(10) DEFAULT NULL,
  `Hora` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `eventos`
--

INSERT INTO `eventos` (`ID_Evento`, `Título`, `Descripción`, `Creacion_Evento`, `Ubicacion`, `Cédula`, `Hora`) VALUES
(1, 'Feria de Artesanos', 'Evento cultural con productos locales.', '2025-06-10', 'Plaza Artigas', '12345678', NULL),
(2, 'Concierto de Rock', 'Banda local en vivo.', '2025-06-15', 'Teatro Larrañaga', '87654321', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `organizadores`
--

CREATE TABLE `organizadores` (
  `Cédula` varchar(10) NOT NULL,
  `RUT` varchar(15) DEFAULT NULL,
  `Teléfono` varchar(20) DEFAULT NULL,
  `ID_Cliente` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `organizadores`
--

INSERT INTO `organizadores` (`Cédula`, `RUT`, `Teléfono`, `ID_Cliente`) VALUES
('12345678', '12345678901', '099111222', 1),
('87654321', '98765432109', '098222111', 2);

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
  ADD UNIQUE KEY `ID_Evento` (`ID_Evento`),
  ADD KEY `ID_Cliente` (`ID_Cliente`),
  ADD KEY `Cédula` (`Cédula`),
  ADD KEY `ID_Evento_2` (`ID_Evento`);

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
  ADD PRIMARY KEY (`Cédula`),
  ADD UNIQUE KEY `ID_Cliente` (`ID_Cliente`) USING BTREE,
  ADD UNIQUE KEY `RUT` (`RUT`);

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
  MODIFY `ID_Cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `ID_Comentario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `eventos`
--
ALTER TABLE `eventos`
  MODIFY `ID_Evento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `administra`
--
ALTER TABLE `administra`
  ADD CONSTRAINT `administra_ibfk_1` FOREIGN KEY (`Cédula`) REFERENCES `organizadores` (`Cédula`),
  ADD CONSTRAINT `administra_ibfk_10` FOREIGN KEY (`Cédula`) REFERENCES `organizadores` (`Cédula`),
  ADD CONSTRAINT `administra_ibfk_11` FOREIGN KEY (`ID_Evento`) REFERENCES `eventos` (`ID_Evento`),
  ADD CONSTRAINT `administra_ibfk_12` FOREIGN KEY (`ID_Administrador`) REFERENCES `administradores` (`ID_Administrador`),
  ADD CONSTRAINT `administra_ibfk_13` FOREIGN KEY (`Cédula`) REFERENCES `organizadores` (`Cédula`),
  ADD CONSTRAINT `administra_ibfk_14` FOREIGN KEY (`ID_Evento`) REFERENCES `eventos` (`ID_Evento`),
  ADD CONSTRAINT `administra_ibfk_15` FOREIGN KEY (`ID_Administrador`) REFERENCES `administradores` (`ID_Administrador`),
  ADD CONSTRAINT `administra_ibfk_16` FOREIGN KEY (`Cédula`) REFERENCES `organizadores` (`Cédula`),
  ADD CONSTRAINT `administra_ibfk_17` FOREIGN KEY (`ID_Evento`) REFERENCES `eventos` (`ID_Evento`),
  ADD CONSTRAINT `administra_ibfk_18` FOREIGN KEY (`ID_Administrador`) REFERENCES `administradores` (`ID_Administrador`),
  ADD CONSTRAINT `administra_ibfk_19` FOREIGN KEY (`Cédula`) REFERENCES `organizadores` (`Cédula`),
  ADD CONSTRAINT `administra_ibfk_2` FOREIGN KEY (`ID_Evento`) REFERENCES `eventos` (`ID_Evento`),
  ADD CONSTRAINT `administra_ibfk_20` FOREIGN KEY (`ID_Evento`) REFERENCES `eventos` (`ID_Evento`),
  ADD CONSTRAINT `administra_ibfk_21` FOREIGN KEY (`ID_Administrador`) REFERENCES `administradores` (`ID_Administrador`),
  ADD CONSTRAINT `administra_ibfk_22` FOREIGN KEY (`Cédula`) REFERENCES `organizadores` (`Cédula`),
  ADD CONSTRAINT `administra_ibfk_23` FOREIGN KEY (`ID_Evento`) REFERENCES `eventos` (`ID_Evento`),
  ADD CONSTRAINT `administra_ibfk_24` FOREIGN KEY (`ID_Administrador`) REFERENCES `administradores` (`ID_Administrador`),
  ADD CONSTRAINT `administra_ibfk_25` FOREIGN KEY (`Cédula`) REFERENCES `organizadores` (`Cédula`),
  ADD CONSTRAINT `administra_ibfk_26` FOREIGN KEY (`ID_Evento`) REFERENCES `eventos` (`ID_Evento`),
  ADD CONSTRAINT `administra_ibfk_27` FOREIGN KEY (`ID_Administrador`) REFERENCES `administradores` (`ID_Administrador`),
  ADD CONSTRAINT `administra_ibfk_28` FOREIGN KEY (`Cédula`) REFERENCES `organizadores` (`Cédula`),
  ADD CONSTRAINT `administra_ibfk_29` FOREIGN KEY (`ID_Evento`) REFERENCES `eventos` (`ID_Evento`),
  ADD CONSTRAINT `administra_ibfk_3` FOREIGN KEY (`Cédula`) REFERENCES `organizadores` (`Cédula`),
  ADD CONSTRAINT `administra_ibfk_30` FOREIGN KEY (`ID_Administrador`) REFERENCES `administradores` (`ID_Administrador`),
  ADD CONSTRAINT `administra_ibfk_31` FOREIGN KEY (`Cédula`) REFERENCES `organizadores` (`Cédula`),
  ADD CONSTRAINT `administra_ibfk_32` FOREIGN KEY (`ID_Evento`) REFERENCES `eventos` (`ID_Evento`),
  ADD CONSTRAINT `administra_ibfk_33` FOREIGN KEY (`ID_Administrador`) REFERENCES `administradores` (`ID_Administrador`),
  ADD CONSTRAINT `administra_ibfk_34` FOREIGN KEY (`Cédula`) REFERENCES `organizadores` (`Cédula`),
  ADD CONSTRAINT `administra_ibfk_35` FOREIGN KEY (`ID_Evento`) REFERENCES `eventos` (`ID_Evento`),
  ADD CONSTRAINT `administra_ibfk_36` FOREIGN KEY (`ID_Administrador`) REFERENCES `administradores` (`ID_Administrador`),
  ADD CONSTRAINT `administra_ibfk_4` FOREIGN KEY (`ID_Evento`) REFERENCES `eventos` (`ID_Evento`),
  ADD CONSTRAINT `administra_ibfk_5` FOREIGN KEY (`Cédula`) REFERENCES `organizadores` (`Cédula`),
  ADD CONSTRAINT `administra_ibfk_6` FOREIGN KEY (`ID_Evento`) REFERENCES `eventos` (`ID_Evento`),
  ADD CONSTRAINT `administra_ibfk_7` FOREIGN KEY (`Cédula`) REFERENCES `organizadores` (`Cédula`),
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
  ADD CONSTRAINT `comentarios_ibfk_14` FOREIGN KEY (`Cédula`) REFERENCES `organizadores` (`Cédula`),
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
  ADD CONSTRAINT `eventos_ibfk_1` FOREIGN KEY (`Cédula`) REFERENCES `organizadores` (`Cédula`);

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

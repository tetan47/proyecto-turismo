-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-09-2025 a las 15:07:55
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
-- Estructura de tabla para la tabla `comentarios`
--

CREATE TABLE `comentarios` (
  `ID_Comentario` int(11) NOT NULL,
  `ID_Cliente` int(11) NOT NULL,
  `ID_Evento` int(11) DEFAULT NULL,
  `LIKES` int(4) DEFAULT 0,
  `Texto` varchar(250) DEFAULT NULL,
  `Creación_Comentario` datetime DEFAULT current_timestamp(),
  `Cédula` varchar(10) DEFAULT NULL,
  `comentario_responder` text NOT NULL,
  `usuarios_like` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `comentarios`
--

INSERT INTO `comentarios` (`ID_Comentario`, `ID_Cliente`, `ID_Evento`, `LIKES`, `Texto`, `Creación_Comentario`, `Cédula`, `comentario_responder`, `usuarios_like`) VALUES
(1, 1, 1, 12, 'Muy buen ambiente y productos.', '2025-06-11 00:00:00', NULL, '', NULL),
(2, 2, 2, 9, 'Excelente sonido y organización.', '2025-06-16 00:00:00', NULL, '', NULL),
(3, 2, 1, 9, 'Muy limpio y ordenado', '2025-09-27 00:00:00', NULL, '', NULL),
(6, 1, 5, NULL, 'Primer comentario', '2025-09-03 19:27:06', NULL, '', NULL),
(8, 1, 5, NULL, 'Primer comentario', '2025-09-03 19:29:14', NULL, '', NULL),
(9, 1, 5, NULL, 'Segundo comentario', '2025-09-03 19:29:14', NULL, '', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`ID_Comentario`),
  ADD KEY `ID_Cliente` (`ID_Cliente`),
  ADD KEY `Cédula` (`Cédula`),
  ADD KEY `ID_Evento_2` (`ID_Evento`),
  ADD KEY `idx_evento` (`ID_Evento`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `ID_Comentario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Restricciones para tablas volcadas
--

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-09-2025 a las 23:08:28
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
(1, 'n', 1, '2025-09-15 16:32:27', 1, 0, NULL),
(2, 'CUALQIERA', 3, '2025-09-15 16:45:00', 1, 0, NULL),
(3, 'waow', 1, '2025-09-15 17:36:15', 1, 3, '1'),
(4, 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Culpa eligendi animi repellat deserunt libero dolor voluptas nesciunt, nihil quis doloribus ducimus reiciendis cum magni corporis facere ratione recusandae cumque dolores.', 1, '2025-09-15 17:37:02', 1, 0, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `respondercomentario`
--
ALTER TABLE `respondercomentario`
  ADD PRIMARY KEY (`comentario_responder`),
  ADD KEY `ID_Comentario` (`ID_Comentario`),
  ADD KEY `ID_Cliente` (`ID_Cliente`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `respondercomentario`
--
ALTER TABLE `respondercomentario`
  MODIFY `comentario_responder` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

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

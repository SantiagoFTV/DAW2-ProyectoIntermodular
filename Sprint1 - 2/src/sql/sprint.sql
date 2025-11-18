-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-11-2025 a las 11:46:46
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
-- Base de datos: `sprint`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `voluntarios_db`
--

CREATE TABLE `voluntarios_db` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `telefono` int(11) NOT NULL,
  `horas_disponibles` varchar(255) NOT NULL,
  `habilidades` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `voluntarios_db`
--

INSERT INTO `voluntarios_db` (`id`, `nombre`, `telefono`, `horas_disponibles`, `habilidades`) VALUES
(20, 'Santiago Francisco Torrico Valdivieso', 654456564, '20', 'Cocinar, Lavar'),
(21, 'Pedro macaquinho', 654456564, '25', 'Comer');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `voluntarios_db`
--
ALTER TABLE `voluntarios_db`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `voluntarios_db`
--
ALTER TABLE `voluntarios_db`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
INSERT INTO voluntarios_db (nombre, telefono, horas_disponibles, habilidades, fecha_creacion) VALUES ('Asis', '765567766', 16, 'Bailar', '2025-11-18 12:04:31');
INSERT INTO voluntarios_db (nombre, telefono, horas_disponibles, habilidades, fecha_creacion) VALUES ('Manuel', '654765456', 20, 'Cocinar', '2025-11-18 12:05:46');

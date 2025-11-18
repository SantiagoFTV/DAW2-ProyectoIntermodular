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
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `telefono` int(11) NOT NULL,
  `horas_disponibles` varchar(255) NOT NULL,
  `habilidades` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
--
-- AUTO_INCREMENT de las tablas volcadas
--
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
INSERT INTO `voluntarios_db` (`id`, `nombre`, `telefono`, `horas_disponibles`, `habilidades`) VALUES (22, 'Asis', '765567766', 16, 'Bailar');
INSERT INTO `voluntarios_db` (`id`, `nombre`, `telefono`, `horas_disponibles`, `habilidades`) VALUES (23, 'Manuel', '654765456', 20, 'Cocinar');
INSERT INTO `voluntarios_db` (`nombre`, `telefono`, `horas_disponibles`, `habilidades`) VALUES ('Arturo', '654765456', 17, 'Logistica');
INSERT INTO voluntarios_db (nombre, telefono, horas_disponibles, habilidades, fecha_creacion) VALUES ('Arturo', '5685685', 16, 'Pensar', '2025-11-18 17:42:59');
INSERT INTO voluntarios_db (nombre, telefono, horas_disponibles, habilidades, fecha_creacion) VALUES ('Arturo', '5685685', 16, 'Pensar', '2025-11-18 17:46:13');

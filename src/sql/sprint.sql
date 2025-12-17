-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-12-2025 a las 21:01:06
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
-- Estructura de tabla para la tabla `alertas_caducidad`
--

CREATE TABLE `alertas_caducidad` (
  `id` int(11) NOT NULL,
  `nombre_producto` varchar(255) NOT NULL,
  `punto_distribucion_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `fecha_caducidad` date NOT NULL,
  `ubicacion` varchar(255) NOT NULL,
  `estado` varchar(50) DEFAULT 'ok',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `alertas_caducidad`
--

INSERT INTO `alertas_caducidad` (`id`, `nombre_producto`, `punto_distribucion_id`, `cantidad`, `fecha_caducidad`, `ubicacion`, `estado`, `created_at`, `updated_at`) VALUES
(1, 'Leche Entera', 1, 20, '2025-12-19', 'Estante A-1', 'critico', '2025-12-17 20:44:50', '2025-12-17 20:44:50'),
(2, 'Pan Integral', 1, 15, '2025-12-18', 'Estante A-2', 'critico', '2025-12-17 20:44:50', '2025-12-17 20:44:50'),
(3, 'Yogur Natural', 1, 30, '2025-12-22', 'Estante B-1', 'urgente', '2025-12-17 20:44:50', '2025-12-17 20:44:50'),
(4, 'Queso Fresco', 1, 10, '2025-12-27', 'Estante B-2', 'proximo', '2025-12-17 20:44:50', '2025-12-17 20:44:50'),
(5, 'Leche Cortada', 1, 20, '2026-01-13', 'Estante A-2', 'ok', '2025-12-17 20:53:04', '2025-12-17 20:53:04');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `puntos_distribucion`
--

CREATE TABLE `puntos_distribucion` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `direccion` text NOT NULL,
  `responsable` varchar(255) NOT NULL,
  `telefono` varchar(50) NOT NULL,
  `latitud` decimal(10,6) DEFAULT NULL,
  `longitud` decimal(10,6) DEFAULT NULL,
  `horario` varchar(255) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `puntos_distribucion`
--

INSERT INTO `puntos_distribucion` (`id`, `nombre`, `direccion`, `responsable`, `telefono`, `latitud`, `longitud`, `horario`, `descripcion`, `created_at`) VALUES
(1, 'Centro Norte', 'Av. Principal 123, Madrid', 'Lucia Perez', '+34 600 123 456', 40.416800, -3.703800, 'Lun-Vie 09:00-18:00', 'Punto con acceso para camiones y zona de carga.', '2025-12-17 20:44:50'),
(2, 'Centro Sur', 'Calle las palmeras con cocos', 'Juanito', '+34 654 456 456', 40.100000, -3.788000, 'Lun-Vie  10:00am', 'Comidas y ropas', '2025-12-17 21:00:31');

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
(1, 'Santiago Francisco Torrico Valdivieso', 654456564, '20', 'Cocinar, Lavar'),
(2, 'Pedro macaquinho', 654456564, '25', 'Comer'),
(3, 'Asis', 765567766, '16', 'Bailar'),
(4, 'Manuel', 654765456, '20', 'Cocinar'),
(5, 'Francisco', 5464564, '13', 'Lavar');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alertas_caducidad`
--
ALTER TABLE `alertas_caducidad`
  ADD PRIMARY KEY (`id`),
  ADD KEY `punto_distribucion_id` (`punto_distribucion_id`);

--
-- Indices de la tabla `puntos_distribucion`
--
ALTER TABLE `puntos_distribucion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `voluntarios_db`
--
ALTER TABLE `voluntarios_db`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alertas_caducidad`
--
ALTER TABLE `alertas_caducidad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `puntos_distribucion`
--
ALTER TABLE `puntos_distribucion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `voluntarios_db`
--
ALTER TABLE `voluntarios_db`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `alertas_caducidad`
--
ALTER TABLE `alertas_caducidad`
  ADD CONSTRAINT `alertas_caducidad_ibfk_1` FOREIGN KEY (`punto_distribucion_id`) REFERENCES `puntos_distribucion` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

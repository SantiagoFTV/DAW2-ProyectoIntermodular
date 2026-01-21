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

CREATE DATABASE IF NOT EXISTS `sprint`;
USE `sprint`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `voluntarios_db`
--

CREATE TABLE IF NOT EXISTS `voluntarios_db` (
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

INSERT IGNORE INTO `voluntarios_db` (`id`, `nombre`, `telefono`, `horas_disponibles`, `habilidades`) VALUES
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
INSERT IGNORE INTO `voluntarios_db` (`id`, `nombre`, `telefono`, `horas_disponibles`, `habilidades`) VALUES (22, 'Asis', '765567766', 16, 'Bailar');
INSERT IGNORE INTO `voluntarios_db` (`id`, `nombre`, `telefono`, `horas_disponibles`, `habilidades`) VALUES (23, 'Manuel', '654765456', 20, 'Cocinar');
INSERT IGNORE INTO `voluntarios_db` (`nombre`, `telefono`, `horas_disponibles`, `habilidades`) VALUES ('Arturo', '654765456', 17, 'Logistica');

--
-- Estructura de tabla para la tabla `puntos_distribucion`
--

CREATE TABLE IF NOT EXISTS `puntos_distribucion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `direccion` text NOT NULL,
  `responsable` varchar(255) NOT NULL,
  `telefono` varchar(50) NOT NULL,
  `latitud` decimal(10,6) DEFAULT NULL,
  `longitud` decimal(10,6) DEFAULT NULL,
  `horario` varchar(255) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `puntos_distribucion`
--

INSERT IGNORE INTO puntos_distribucion (nombre, direccion, responsable, telefono, latitud, longitud, horario, descripcion, created_at) VALUES ('Centro Norte', 'Av. Principal 123, Madrid', 'Lucia Perez', '+34 600 123 456', 40.416800, -3.703800, 'Lun-Vie 09:00-18:00', 'Punto con acceso para camiones y zona de carga.', '2025-12-09 10:00:00');

--
-- Estructura de tabla para la tabla `alertas_caducidad`
--

CREATE TABLE IF NOT EXISTS `alertas_caducidad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_producto` varchar(255) NOT NULL,
  `punto_distribucion_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `fecha_caducidad` date NOT NULL,
  `ubicacion` varchar(255) NOT NULL,
  `estado` varchar(50) DEFAULT 'ok',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `punto_distribucion_id` (`punto_distribucion_id`),
  CONSTRAINT `alertas_caducidad_ibfk_1` FOREIGN KEY (`punto_distribucion_id`) REFERENCES `puntos_distribucion` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `alertas_caducidad`
--

INSERT IGNORE INTO alertas_caducidad (nombre_producto, punto_distribucion_id, cantidad, fecha_caducidad, ubicacion, estado) VALUES ('Leche Entera', 1, 20, DATE_ADD(CURDATE(), INTERVAL 2 DAY), 'Estante A-1', 'critico');
INSERT IGNORE INTO alertas_caducidad (nombre_producto, punto_distribucion_id, cantidad, fecha_caducidad, ubicacion, estado) VALUES ('Pan Integral', 1, 15, DATE_ADD(CURDATE(), INTERVAL 1 DAY), 'Estante A-2', 'critico');
INSERT IGNORE INTO alertas_caducidad (nombre_producto, punto_distribucion_id, cantidad, fecha_caducidad, ubicacion, estado) VALUES ('Yogur Natural', 1, 30, DATE_ADD(CURDATE(), INTERVAL 5 DAY), 'Estante B-1', 'urgente');
INSERT IGNORE INTO alertas_caducidad (nombre_producto, punto_distribucion_id, cantidad, fecha_caducidad, ubicacion, estado) VALUES ('Queso Fresco', 1, 10, DATE_ADD(CURDATE(), INTERVAL 10 DAY), 'Estante B-2', 'proximo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `beneficiarios`
--

CREATE TABLE IF NOT EXISTS `beneficiarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `apellidos` varchar(255) NOT NULL,
  `numero_identificacion` varchar(50) UNIQUE,
  `telefono` varchar(20),
  `email` varchar(255),
  `direccion` text,
  `tamaño_familiar` int(11),
  `necesidades` text,
  `estado_validacion` varchar(50) DEFAULT 'pendiente',
  `fecha_ultima_asignacion` datetime DEFAULT NULL,
  `frecuencia_maxima_dias` int(11) DEFAULT 30,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `beneficiarios`
--

INSERT IGNORE INTO `beneficiarios` (`nombre`, `apellidos`, `numero_identificacion`, `telefono`, `email`, `direccion`, `tamaño_familiar`, `necesidades`, `estado_validacion`, `fecha_ultima_asignacion`, `frecuencia_maxima_dias`) VALUES
('Juan', 'García López', '12345678A', '654123456', 'juan@example.com', 'Calle Principal 10, Madrid', 4, 'Alimentos básicos, productos de higiene', 'validado', NULL, 1),
('María', 'Rodríguez Martínez', '87654321B', '654987654', 'maria@example.com', 'Avenida Central 25, Madrid', 5, 'Alimentos, medicinas', 'validado', NULL, 1),
('Carlos', 'López Fernández', '11223344C', '645555666', 'carlos@example.com', 'Plaza Mayor 5, Madrid', 3, 'Alimentos básicos', 'pendiente', NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignaciones_productos`
--

CREATE TABLE IF NOT EXISTS `asignaciones_productos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `beneficiario_id` int(11) NOT NULL,
  `nombre_producto` varchar(255) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `punto_distribucion_id` int(11),
  `coordinador` varchar(255),
  `fecha_asignacion` datetime NOT NULL DEFAULT current_timestamp(),
  `comprobante` varchar(255),
  `notas` text,
  PRIMARY KEY (`id`),
  KEY `beneficiario_id` (`beneficiario_id`),
  KEY `punto_distribucion_id` (`punto_distribucion_id`),
  CONSTRAINT `asignaciones_productos_ibfk_1` FOREIGN KEY (`beneficiario_id`) REFERENCES `beneficiarios` (`id`) ON DELETE CASCADE,
  CONSTRAINT `asignaciones_productos_ibfk_2` FOREIGN KEY (`punto_distribucion_id`) REFERENCES `puntos_distribucion` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO puntos_distribucion (nombre, direccion, responsable, telefono, latitud, longitud, horario, descripcion, created_at) VALUES ('Centro Sur', 'La casa de mario', 'Mario', '645456564', NULL, NULL, 'Lunes a Viernes 10am -  11pm', 'Preguntar por manu', '2026-01-17 15:57:44');
INSERT INTO puntos_distribucion (nombre, direccion, responsable, telefono, latitud, longitud, horario, descripcion, created_at) VALUES ('Polo Norte', 'Ciudad parez', 'Juan', '654456654', NULL, NULL, 'Lunes a Viernes 10am -  11pm', 'Jardin', '2026-01-17 16:16:37');
INSERT INTO puntos_distribucion (nombre, direccion, responsable, telefono, latitud, longitud, horario, descripcion, created_at) VALUES ('Polo Norte', 'Iglu al lado del pinguino verde', 'Fernando', '3123123123', NULL, NULL, 'Lunes a Viernes 10am -  11pm', 'Foca sonriente', '2026-01-17 16:21:53');
INSERT INTO puntos_distribucion (nombre, direccion, responsable, telefono, latitud, longitud, horario, descripcion, created_at) VALUES ('Polo Norteasdsadsad', 'Iglu al lado del pinguino verde', 'Fernando', '3123123123', NULL, NULL, 'Lunes a Viernes 10am -  11pm', 'Foca sonriente', '2026-01-17 16:21:59');
INSERT INTO puntos_distribucion (nombre, direccion, responsable, telefono, latitud, longitud, horario, descripcion, created_at) VALUES ('Badajoz', 'Farmacia Panchita', 'Mario Lopez', '3123123123', NULL, NULL, 'Lunes a Viernes 10am -  11pm', 'Frenesi', '2026-01-17 16:34:40');
INSERT INTO puntos_distribucion (nombre, direccion, responsable, telefono, latitud, longitud, horario, descripcion, created_at) VALUES ('asda', 'asdas', 'asd', 'asdas', NULL, NULL, 'asdas', 'asdasd', '2026-01-17 16:42:48');
INSERT INTO puntos_distribucion (nombre, direccion, responsable, telefono, latitud, longitud, horario, descripcion, created_at) VALUES ('asdasd', 'asdas', 'asdasd', 'asdasd', NULL, NULL, 'asdas', 'asdasd', '2026-01-17 16:46:32');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `donaciones`
--

CREATE TABLE IF NOT EXISTS `donaciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_donante` varchar(255) NOT NULL,
  `tipo_producto` varchar(255) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `unidad_medida` varchar(50) DEFAULT 'unidades',
  `fecha_recepcion` date NOT NULL,
  `fecha_caducidad` date DEFAULT NULL,
  `punto_distribucion_id` int(11) DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  `estado` varchar(50) DEFAULT 'recibido',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `punto_distribucion_id` (`punto_distribucion_id`),
  CONSTRAINT `donaciones_ibfk_1` FOREIGN KEY (`punto_distribucion_id`) REFERENCES `puntos_distribucion` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `donaciones`
--

INSERT IGNORE INTO `donaciones` (`nombre_donante`, `tipo_producto`, `cantidad`, `unidad_medida`, `fecha_recepcion`, `fecha_caducidad`, `punto_distribucion_id`, `observaciones`, `estado`) VALUES
('Supermercados ABC', 'Arroz', 100, 'kg', CURDATE(), DATE_ADD(CURDATE(), INTERVAL 365 DAY), 1, 'Donación mensual', 'recibido'),
('Panadería El Pan Dorado', 'Pan de molde', 50, 'unidades', CURDATE(), DATE_ADD(CURDATE(), INTERVAL 7 DAY), 1, 'Excedente semanal', 'recibido'),
('Granja Santa Elena', 'Leche', 30, 'litros', CURDATE(), DATE_ADD(CURDATE(), INTERVAL 5 DAY), 1, 'Donación especial', 'recibido');
INSERT INTO puntos_distribucion (nombre, direccion, responsable, telefono, latitud, longitud, horario, descripcion, created_at) VALUES ('Maranguita', 'La casa de borja', 'Borja', '65445654', NULL, NULL, 'Lunes a Viernes 10am -  11pm', 'rorbar', '2026-01-21 21:06:36');

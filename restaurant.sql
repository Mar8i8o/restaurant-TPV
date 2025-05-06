-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-02-2025 a las 16:15:03
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
-- Base de datos: `restaurant`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `elaborado`
--

CREATE TABLE `elaborado` (
  `elaborado_id` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `descripcion` varchar(2550) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingrediente`
--

CREATE TABLE `ingrediente` (
  `ingrediente_id` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ingrediente`
--

INSERT INTO `ingrediente` (`ingrediente_id`, `nombre`) VALUES
(1, 'Salsa Boloñesa'),
(2, 'Aceite'),
(3, 'Queso Rallado'),
(4, 'Champiñones en láminas'),
(5, 'Carne picada vacuno'),
(6, 'Cebolla'),
(7, 'Albóndigas'),
(8, 'Salsa bechamel'),
(9, 'Salsa Pesto'),
(10, 'Espaguetis'),
(11, 'Macarrones'),
(12, 'Salsa carbonara'),
(13, 'Arroz'),
(14, 'Masa de pizza'),
(15, 'Huevos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `restaurante_id` int(11) DEFAULT NULL,
  `timeStamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `tipo_accion` int(11) DEFAULT NULL,
  `tipo_tabla` int(11) DEFAULT NULL,
  `registro_id` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `comentario` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `platos`
--

CREATE TABLE `platos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `imagen` varchar(250) DEFAULT NULL,
  `instrucciones` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `platos_ingrediente`
--

CREATE TABLE `platos_ingrediente` (
  `id` int(11) NOT NULL,
  `id_plato` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `cantidad` decimal(10,2) NOT NULL,
  `unidad` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `platos_preelaborados`
--

CREATE TABLE `platos_preelaborados` (
  `id` int(11) NOT NULL,
  `id_plato` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `cantidad` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plato_restaurante`
--

CREATE TABLE `plato_restaurante` (
  `id` int(11) NOT NULL,
  `id_plato` int(11) NOT NULL,
  `id_restaurante` int(11) NOT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `receta`
--

CREATE TABLE `receta` (
  `restaurante_id` int(11) DEFAULT NULL,
  `receta_id` int(11) NOT NULL,
  `elaborado_id` int(11) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `descripcion` varchar(2550) DEFAULT NULL,
  `cantidad_producida` int(11) DEFAULT NULL,
  `cantidad_producida_unidad` int(11) DEFAULT NULL,
  `imagen` varchar(250) DEFAULT NULL,
  `descripcion_corta` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `receta_ingrediente`
--

CREATE TABLE `receta_ingrediente` (
  `receta_id` int(11) DEFAULT NULL,
  `ingrediente_id` int(11) DEFAULT NULL,
  `cantidad` decimal(10,2) DEFAULT NULL,
  `unidad` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `restaurante`
--

CREATE TABLE `restaurante` (
  `restaurante_id` int(11) NOT NULL,
  `CIF` varchar(255) NOT NULL,
  `Dirección` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `restaurante`
--

INSERT INTO `restaurante` (`restaurante_id`, `CIF`, `Dirección`) VALUES
(1, 'Q1673095D', 'C/ de Manuel Melià i Fuster, 1'),
(2, 'E99788119', 'C/ de Murillo, 22, Ciutat Vella, 46001 València, Valencia');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `stock`
--

CREATE TABLE `stock` (
  `id` int(11) NOT NULL,
  `restaurante_id` int(11) DEFAULT NULL,
  `elaborado_id` int(11) DEFAULT NULL,
  `ingrediente_id` int(11) DEFAULT NULL,
  `cantidad_stock` varchar(100) DEFAULT NULL,
  `unidad` int(11) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `moneda` int(11) DEFAULT NULL,
  `caducidad` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_accion`
--

CREATE TABLE `tipo_accion` (
  `id` int(11) NOT NULL,
  `accion` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_accion`
--

INSERT INTO `tipo_accion` (`id`, `accion`) VALUES
(1, 'compra'),
(2, 'venta');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_moneda`
--

CREATE TABLE `tipo_moneda` (
  `id` int(11) NOT NULL,
  `Moneda` varchar(50) DEFAULT NULL,
  `Simbolo` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_moneda`
--

INSERT INTO `tipo_moneda` (`id`, `Moneda`, `Simbolo`) VALUES
(1, 'EUR', '€'),
(2, 'DOL', '$'),
(3, 'SAR', '﷼');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_tabla`
--

CREATE TABLE `tipo_tabla` (
  `id` int(11) NOT NULL,
  `tabla` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_tabla`
--

INSERT INTO `tipo_tabla` (`id`, `tabla`) VALUES
(1, 'Usuario'),
(2, 'Stock'),
(3, 'Ingrediente'),
(4, 'Elaborado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_unidad`
--

CREATE TABLE `tipo_unidad` (
  `id` int(11) NOT NULL,
  `unidad` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_unidad`
--

INSERT INTO `tipo_unidad` (`id`, `unidad`) VALUES
(1, 'Qty'),
(2, 'kg'),
(3, 'g'),
(4, 'l'),
(5, 'ml'),
(6, 'lb');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_usuario`
--

CREATE TABLE `tipo_usuario` (
  `id` int(11) NOT NULL,
  `rol` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_usuario`
--

INSERT INTO `tipo_usuario` (`id`, `rol`) VALUES
(1, 'Gerente'),
(2, 'Cocinero');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `usuario_id` int(11) NOT NULL,
  `restaurante_id` int(11) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `contacto` varchar(255) DEFAULT NULL,
  `tipo_usuario_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`usuario_id`, `restaurante_id`, `password`, `nombre`, `direccion`, `contacto`, `tipo_usuario_id`) VALUES
(2, 1, '$2y$10$GeY5yrLaaUehZDa0hOBQIuYFkz5EJxxFVHNtUBsa9/Pm3yFFWBKTm', 'MIguel Gresa', NULL, NULL, 1),
(6, 1, '$2y$10$y33mvtnk0s4iqP4BoNDG5e0yMWez.aVDzKq5mhVWevG9.6V1ouxwW', 'Paco Garcia', NULL, NULL, 2),
(7, 1, '$2y$10$4Cg8Z05zUh/gTZ2TCjAJ7.bvnKz2gN.wZFZ4GI0/4/cTBFUJjkxV6', 'Manolo', NULL, NULL, 1),
(8, 2, '$2y$10$l1kiC4xTnYI4b6KIKby.ouLAAfGSCRITgxhIIkdzpekBFQsJ.Ua6u', 'Adrian Campos', NULL, NULL, 1),
(9, 1, '$2y$10$31DI7vOKYsI9Gg3eob.3Gepwhn/3YATtXzXCViK5OqZZBMzOzapQ2', 'Admin', NULL, NULL, 1),
(10, 1, '$2y$10$m9y3E8BypRwhxJiUMTwRY.LJmXTiEyNuZXzymOX4iwNKhnMUY9Ure', 'asd', NULL, NULL, 1),
(12, 2, '$2y$10$avrh6DmQF4wP6Bi.KJbqiuXvNKqtxmxXHT861eYnbWQ94HXEjWYNS', 'admin', NULL, NULL, 1),
(13, 1, '$2y$10$mVDRTe4l9irsIoW9iO/TQuHnjFUOyHMVm6quysAGbP/NE3PQRa6Ue', 'Toni', NULL, NULL, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `elaborado`
--
ALTER TABLE `elaborado`
  ADD PRIMARY KEY (`elaborado_id`);

--
-- Indices de la tabla `ingrediente`
--
ALTER TABLE `ingrediente`
  ADD PRIMARY KEY (`ingrediente_id`);

--
-- Indices de la tabla `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `restaurante_id` (`restaurante_id`),
  ADD KEY `tipo_accion` (`tipo_accion`),
  ADD KEY `tipo_tabla` (`tipo_tabla`);

--
-- Indices de la tabla `platos`
--
ALTER TABLE `platos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `platos_ingrediente`
--
ALTER TABLE `platos_ingrediente`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_plato` (`id_plato`);

--
-- Indices de la tabla `platos_preelaborados`
--
ALTER TABLE `platos_preelaborados`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_plato` (`id_plato`);

--
-- Indices de la tabla `plato_restaurante`
--
ALTER TABLE `plato_restaurante`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_plato` (`id_plato`),
  ADD KEY `id_restaurante` (`id_restaurante`);

--
-- Indices de la tabla `receta`
--
ALTER TABLE `receta`
  ADD PRIMARY KEY (`receta_id`),
  ADD KEY `cantidad_producida_unidad` (`cantidad_producida_unidad`),
  ADD KEY `restaurante_id` (`restaurante_id`),
  ADD KEY `elaborado_id` (`elaborado_id`);

--
-- Indices de la tabla `receta_ingrediente`
--
ALTER TABLE `receta_ingrediente`
  ADD KEY `unidad` (`unidad`),
  ADD KEY `receta_id` (`receta_id`),
  ADD KEY `ingrediente_id` (`ingrediente_id`);

--
-- Indices de la tabla `restaurante`
--
ALTER TABLE `restaurante`
  ADD PRIMARY KEY (`restaurante_id`);

--
-- Indices de la tabla `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`id`),
  ADD KEY `moneda` (`moneda`),
  ADD KEY `unidad` (`unidad`),
  ADD KEY `restaurante_id` (`restaurante_id`),
  ADD KEY `elaborado_id` (`elaborado_id`),
  ADD KEY `ingrediente_id` (`ingrediente_id`);

--
-- Indices de la tabla `tipo_accion`
--
ALTER TABLE `tipo_accion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipo_moneda`
--
ALTER TABLE `tipo_moneda`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipo_tabla`
--
ALTER TABLE `tipo_tabla`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipo_unidad`
--
ALTER TABLE `tipo_unidad`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`usuario_id`),
  ADD KEY `restaurante_id` (`restaurante_id`),
  ADD KEY `tipo_usuario_id` (`tipo_usuario_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `elaborado`
--
ALTER TABLE `elaborado`
  MODIFY `elaborado_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=202;

--
-- AUTO_INCREMENT de la tabla `ingrediente`
--
ALTER TABLE `ingrediente`
  MODIFY `ingrediente_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=339;

--
-- AUTO_INCREMENT de la tabla `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `platos_ingrediente`
--
ALTER TABLE `platos_ingrediente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `platos_preelaborados`
--
ALTER TABLE `platos_preelaborados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `plato_restaurante`
--
ALTER TABLE `plato_restaurante`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `receta`
--
ALTER TABLE `receta`
  MODIFY `receta_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=202;

--
-- AUTO_INCREMENT de la tabla `restaurante`
--
ALTER TABLE `restaurante`
  MODIFY `restaurante_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `stock`
--
ALTER TABLE `stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT de la tabla `tipo_accion`
--
ALTER TABLE `tipo_accion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tipo_moneda`
--
ALTER TABLE `tipo_moneda`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tipo_tabla`
--
ALTER TABLE `tipo_tabla`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tipo_unidad`
--
ALTER TABLE `tipo_unidad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `usuario_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `logs`
--
ALTER TABLE `logs`
  ADD CONSTRAINT `logs_ibfk_1` FOREIGN KEY (`restaurante_id`) REFERENCES `restaurante` (`restaurante_id`),
  ADD CONSTRAINT `logs_ibfk_2` FOREIGN KEY (`tipo_accion`) REFERENCES `tipo_accion` (`id`),
  ADD CONSTRAINT `logs_ibfk_3` FOREIGN KEY (`tipo_tabla`) REFERENCES `tipo_tabla` (`id`);

--
-- Filtros para la tabla `platos_ingrediente`
--
ALTER TABLE `platos_ingrediente`
  ADD CONSTRAINT `platos_ingrediente_ibfk_1` FOREIGN KEY (`id_plato`) REFERENCES `platos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `platos_preelaborados`
--
ALTER TABLE `platos_preelaborados`
  ADD CONSTRAINT `platos_preelaborados_ibfk_1` FOREIGN KEY (`id_plato`) REFERENCES `platos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `plato_restaurante`
--
ALTER TABLE `plato_restaurante`
  ADD CONSTRAINT `plato_restaurante_ibfk_1` FOREIGN KEY (`id_plato`) REFERENCES `platos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `plato_restaurante_ibfk_2` FOREIGN KEY (`id_restaurante`) REFERENCES `restaurante` (`restaurante_id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `receta`
--
ALTER TABLE `receta`
  ADD CONSTRAINT `receta_ibfk_1` FOREIGN KEY (`cantidad_producida_unidad`) REFERENCES `tipo_unidad` (`id`),
  ADD CONSTRAINT `receta_ibfk_2` FOREIGN KEY (`restaurante_id`) REFERENCES `restaurante` (`restaurante_id`),
  ADD CONSTRAINT `receta_ibfk_3` FOREIGN KEY (`elaborado_id`) REFERENCES `elaborado` (`elaborado_id`);

--
-- Filtros para la tabla `receta_ingrediente`
--
ALTER TABLE `receta_ingrediente`
  ADD CONSTRAINT `receta_ingrediente_ibfk_1` FOREIGN KEY (`unidad`) REFERENCES `tipo_unidad` (`id`),
  ADD CONSTRAINT `receta_ingrediente_ibfk_2` FOREIGN KEY (`receta_id`) REFERENCES `receta` (`receta_id`),
  ADD CONSTRAINT `receta_ingrediente_ibfk_3` FOREIGN KEY (`ingrediente_id`) REFERENCES `ingrediente` (`ingrediente_id`);

--
-- Filtros para la tabla `stock`
--
ALTER TABLE `stock`
  ADD CONSTRAINT `stock_ibfk_1` FOREIGN KEY (`moneda`) REFERENCES `tipo_moneda` (`id`),
  ADD CONSTRAINT `stock_ibfk_2` FOREIGN KEY (`unidad`) REFERENCES `tipo_unidad` (`id`),
  ADD CONSTRAINT `stock_ibfk_3` FOREIGN KEY (`restaurante_id`) REFERENCES `restaurante` (`restaurante_id`),
  ADD CONSTRAINT `stock_ibfk_4` FOREIGN KEY (`elaborado_id`) REFERENCES `elaborado` (`elaborado_id`),
  ADD CONSTRAINT `stock_ibfk_5` FOREIGN KEY (`ingrediente_id`) REFERENCES `ingrediente` (`ingrediente_id`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`restaurante_id`) REFERENCES `restaurante` (`restaurante_id`),
  ADD CONSTRAINT `usuario_ibfk_2` FOREIGN KEY (`tipo_usuario_id`) REFERENCES `tipo_usuario` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

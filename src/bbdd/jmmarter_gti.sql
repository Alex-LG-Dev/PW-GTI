-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 30-05-2025 a las 02:23:17
-- Versión del servidor: 8.0.42-0ubuntu0.20.04.1
-- Versión de PHP: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `jmmarter_gti`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consultas_contacto`
--

CREATE TABLE `consultas_contacto` (
  `id` int NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `motivo` text COLLATE utf8mb4_general_ci NOT NULL,
  `producto` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `consultas_contacto`
--

INSERT INTO `consultas_contacto` (`id`, `nombre`, `email`, `motivo`, `producto`, `fecha`) VALUES
(20, 'soufiane belfquih', 'soufianebelfquih828@gmail.com', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', 'Modulo Tareas', '2025-05-29 17:06:24'),
(21, 'Jose Manuel Martin Terre', 'zamn@gmail.com', 'l.jbjbjbl', 'Modulo Tareas', '2025-05-29 22:58:58'),
(22, 'Jose Manuel Martin Terre', 'prueba1@gmail.es', 'fffffffffffffff', 'Modulo Calendario', '2025-05-29 23:00:22'),
(23, 'Jose Manuel Martin Terre', 'prueba1@gmail.es', 'fffffffffffffff', 'Modulo Calendario', '2025-05-29 23:01:29');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_registrados`
--

CREATE TABLE `usuarios_registrados` (
  `id` int NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `contrasena` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `estado` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `token` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `validez_token` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios_registrados`
--

INSERT INTO `usuarios_registrados` (`id`, `nombre`, `email`, `contrasena`, `estado`, `token`, `validez_token`) VALUES
(2, 'Daniel Palacio', 'dapasa@har.upv.es', '$2y$10$HbnThbwJ9MW.gPWWTaFI9.P7Q1ZBA3/ShkGhrPKm1z.tHUgBQquQi', 'activo', 'e21626e87362d36ad3fd9dd953f52728', NULL),
(3, 'Soufiane', 'jeronimosaurio@gmail.com', '$2y$10$n6.RXIOci78t3dRpJ9zK9OaRgvTYOr0uT4lP8FAkLQhsZ.lyizsse', 'pendiente', '3cbc9519cc754403a9f9303751dcbeca', NULL),
(4, 'soufiane', 'sofibell258@gmail.com', '$2y$10$1B9DIjPfWgEzkIicSS7vl.quk1zcJhbAAEp4KZrZr3AcdhqrmX1Cy', 'pendiente', 'b1f2307c70c7877e9d5a91c800a1833e', NULL),
(5, 'el pavo donald', 'correo2jero@gmail.com', '$2y$10$c0dlYAXKqAxy0K2UMDY.oO2/u7q2vCK.fgFT1x73r04z1plngblwK', 'pendiente', '069c871044b97590e9418d2c744880f6', NULL),
(6, 'José Luis Gimenez', 'jogilo@upvnet.upv.es', '$2y$10$mdXcB9w6X5ImeM6B1PYT2uapmkmz42e8rnMz1PPnb0PkE9.F2gg4i', 'activo', 'ef0a25fa4e628b543c6d3b642bb0982a', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `consultas_contacto`
--
ALTER TABLE `consultas_contacto`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios_registrados`
--
ALTER TABLE `usuarios_registrados`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `consultas_contacto`
--
ALTER TABLE `consultas_contacto`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `usuarios_registrados`
--
ALTER TABLE `usuarios_registrados`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

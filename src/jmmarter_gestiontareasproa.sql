-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 30-05-2025 a las 02:22:57
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
-- Base de datos: `jmmarter_gestiontareasproa`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignaturas`
--

CREATE TABLE `asignaturas` (
  `ID_asignatura` int NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `curso` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `asignaturas`
--

INSERT INTO `asignaturas` (`ID_asignatura`, `nombre`, `curso`) VALUES
(1, 'Matematicas', 1),
(2, 'Programación I', 2),
(3, 'Física', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `matriculas_alumnos`
--

CREATE TABLE `matriculas_alumnos` (
  `ID_asignatura` int NOT NULL,
  `DNI` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `matriculas_alumnos`
--

INSERT INTO `matriculas_alumnos` (`ID_asignatura`, `DNI`) VALUES
(1, '01-9218611'),
(2, '01-9218611'),
(3, '01-9218611'),
(1, '04-1320191'),
(2, '04-1320191'),
(1, '05-9971924'),
(3, '05-9971924');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `matriculas_profesor`
--

CREATE TABLE `matriculas_profesor` (
  `ID_asignatura` int NOT NULL,
  `DNI` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `matriculas_profesor`
--

INSERT INTO `matriculas_profesor` (`ID_asignatura`, `DNI`) VALUES
(1, '60-4525956'),
(2, '64-6055365'),
(3, '64-6738133');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuesta_tareas`
--

CREATE TABLE `respuesta_tareas` (
  `ID_tarea` int NOT NULL,
  `ID_alumno` varchar(20) NOT NULL,
  `texto_respuesta` text,
  `fecha_de_entrega` date DEFAULT NULL,
  `nota` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `respuesta_tareas`
--

INSERT INTO `respuesta_tareas` (`ID_tarea`, `ID_alumno`, `texto_respuesta`, `fecha_de_entrega`, `nota`) VALUES
(1, '01-9218611', 'Matrices completadas', '2025-06-01', 8.5),
(2, '04-1320191', 'Funciones cuadráticas', '2025-06-02', 6.9),
(3, '05-9971924', 'Trigonometría aplicada', '2025-06-10', 8),
(5, '01-9218611', 'Variables en Python', '2025-06-05', 7.8),
(9, '01-9218611', 'Velocidad constante', '2025-06-07', 9.2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tareas`
--

CREATE TABLE `tareas` (
  `ID_tarea` int NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `publicada` enum('Sí','No') DEFAULT NULL,
  `descripcion` text,
  `fecha_publicacion` datetime DEFAULT NULL,
  `fecha_entrega` datetime DEFAULT NULL,
  `ID_asignatura` int NOT NULL,
  `href` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `tareas`
--

INSERT INTO `tareas` (`ID_tarea`, `titulo`, `publicada`, `descripcion`, `fecha_publicacion`, `fecha_entrega`, `ID_asignatura`, `href`) VALUES
(1, 'Álgebra básica', 'Sí', 'Matrices y determinantes', '2025-05-30 02:18:24', '2025-06-15 23:59:59', 1, ''),
(2, 'Funciones', 'Sí', 'Estudio de funciones', '2025-05-30 02:18:24', NULL, 1, ''),
(3, 'Trigonometría', 'Sí', 'Ángulos y razones', '2025-05-30 02:18:24', '2025-06-20 20:00:00', 1, ''),
(4, 'Vectores', 'Sí', 'Producto escalar', '2025-05-30 02:18:24', '2025-06-30 20:00:00', 1, ''),
(5, 'Variables', 'Sí', 'Tipos de datos', '2025-05-30 02:18:24', '2025-06-15 20:00:00', 2, ''),
(6, 'Condicionales', 'Sí', 'if-else y switch', '2025-05-30 02:18:24', NULL, 2, ''),
(7, 'Bucles', 'Sí', 'for, while', '2025-05-30 02:18:24', '2025-06-22 20:00:00', 2, ''),
(8, 'Arrays', 'Sí', 'Declaración y uso', '2025-05-30 02:18:24', '2025-06-28 20:00:00', 2, ''),
(9, 'MRU', 'Sí', 'Movimiento rectilíneo', '2025-05-30 02:18:24', '2025-06-10 20:00:00', 3, ''),
(10, 'Leyes de Newton', 'Sí', '3 leyes fundamentales', '2025-05-30 02:18:24', NULL, 3, ''),
(11, 'Trabajo y energía', 'Sí', 'Cálculo energético', '2025-05-30 02:18:24', '2025-06-25 20:00:00', 3, ''),
(12, 'Gravitación', 'Sí', 'Ley universal', '2025-05-30 02:18:24', '2025-07-01 20:00:00', 3, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_registrados`
--

CREATE TABLE `usuarios_registrados` (
  `dni` varchar(20) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `apellido1` varchar(50) DEFAULT NULL,
  `apellido2` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `rol` enum('alumno','profesor') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `usuarios_registrados`
--

INSERT INTO `usuarios_registrados` (`dni`, `nombre`, `apellido1`, `apellido2`, `email`, `password`, `rol`) VALUES
('01-9218611', 'Lief', 'Simants', 'Dredge', 'l.simdre@epsg.upv.es', '9218611', 'alumno'),
('04-1320191', 'Merline', 'Kirsch', 'Kampshell', 'm.kirkam@epsg.upv.es', '1320191', 'alumno'),
('05-9971924', 'Debora', 'Rawstorne', 'Rawstorne', 'd.rawabc@epsg.upv.es', '9971924', 'alumno'),
('60-4525956', 'Kevan', 'Pounds', 'Mainston', 'k.poumai@upv.es', '4525956', 'profesor'),
('64-6055365', 'Luelle', 'Pridmore', 'Starsmeare', 'l.prista@upv.es', '6055365', 'profesor'),
('64-6738133', 'Eolande', 'Merriton', 'Mizzi', 'e.mermiz@upv.es', '6738133', 'profesor');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `asignaturas`
--
ALTER TABLE `asignaturas`
  ADD PRIMARY KEY (`ID_asignatura`);

--
-- Indices de la tabla `matriculas_alumnos`
--
ALTER TABLE `matriculas_alumnos`
  ADD PRIMARY KEY (`ID_asignatura`,`DNI`),
  ADD KEY `DNI` (`DNI`);

--
-- Indices de la tabla `matriculas_profesor`
--
ALTER TABLE `matriculas_profesor`
  ADD PRIMARY KEY (`ID_asignatura`,`DNI`),
  ADD KEY `DNI` (`DNI`);

--
-- Indices de la tabla `respuesta_tareas`
--
ALTER TABLE `respuesta_tareas`
  ADD PRIMARY KEY (`ID_tarea`,`ID_alumno`),
  ADD KEY `ID_alumno` (`ID_alumno`);

--
-- Indices de la tabla `tareas`
--
ALTER TABLE `tareas`
  ADD PRIMARY KEY (`ID_tarea`),
  ADD KEY `ID_asignatura` (`ID_asignatura`);

--
-- Indices de la tabla `usuarios_registrados`
--
ALTER TABLE `usuarios_registrados`
  ADD PRIMARY KEY (`dni`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `asignaturas`
--
ALTER TABLE `asignaturas`
  MODIFY `ID_asignatura` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tareas`
--
ALTER TABLE `tareas`
  MODIFY `ID_tarea` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `matriculas_alumnos`
--
ALTER TABLE `matriculas_alumnos`
  ADD CONSTRAINT `matriculas_alumnos_ibfk_1` FOREIGN KEY (`ID_asignatura`) REFERENCES `asignaturas` (`ID_asignatura`) ON DELETE CASCADE,
  ADD CONSTRAINT `matriculas_alumnos_ibfk_2` FOREIGN KEY (`DNI`) REFERENCES `usuarios_registrados` (`dni`) ON DELETE CASCADE;

--
-- Filtros para la tabla `matriculas_profesor`
--
ALTER TABLE `matriculas_profesor`
  ADD CONSTRAINT `matriculas_profesor_ibfk_1` FOREIGN KEY (`ID_asignatura`) REFERENCES `asignaturas` (`ID_asignatura`) ON DELETE CASCADE,
  ADD CONSTRAINT `matriculas_profesor_ibfk_2` FOREIGN KEY (`DNI`) REFERENCES `usuarios_registrados` (`dni`) ON DELETE CASCADE;

--
-- Filtros para la tabla `respuesta_tareas`
--
ALTER TABLE `respuesta_tareas`
  ADD CONSTRAINT `respuesta_tareas_ibfk_1` FOREIGN KEY (`ID_tarea`) REFERENCES `tareas` (`ID_tarea`) ON DELETE CASCADE,
  ADD CONSTRAINT `respuesta_tareas_ibfk_2` FOREIGN KEY (`ID_alumno`) REFERENCES `usuarios_registrados` (`dni`) ON DELETE CASCADE;

--
-- Filtros para la tabla `tareas`
--
ALTER TABLE `tareas`
  ADD CONSTRAINT `tareas_ibfk_1` FOREIGN KEY (`ID_asignatura`) REFERENCES `asignaturas` (`ID_asignatura`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

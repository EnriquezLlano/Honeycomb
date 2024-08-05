-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-06-2024 a las 23:15:11
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
-- Base de datos: `delectrico`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumnos`
--

CREATE TABLE `alumnos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `nivel` int(11) DEFAULT NULL,
  `institucion_id` int(11) DEFAULT NULL,
  `profesor_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `alumnos`
--

INSERT INTO `alumnos` (`id`, `nombre`, `email`, `nivel`, `institucion_id`, `profesor_id`) VALUES
(1, 'Carlos González', 'carlos@gmail.com', 1, 1, 1),
(2, 'Ana Fernández', 'ana@hotmail.com', 1, 2, 2),
(3, 'Pedro Gómez', 'pedro@yahoo.com', 1, 3, 3),
(4, 'Laura Díaz', 'laura@gmail.com', 1, 4, 4),
(5, 'Marta Pérez', 'marta@hotmail.com', 1, 5, 5),
(6, 'Javier Rodríguez', 'javier@gmail.com', 2, 6, 6),
(7, 'María Gutiérrez', 'maria@yahoo.com', 2, 7, 7),
(8, 'Lucía Martín', 'lucia@hotmail.com', 2, 8, 8),
(9, 'Carlos López', 'carlos@gmail.com', 2, 9, 9),
(10, 'Laura Sánchez', 'laura@yahoo.com', 2, 10, 10),
(11, 'Pedro Martínez', 'pedro@hotmail.com', 3, 11, 11),
(12, 'Ana García', 'ana@gmail.com', 3, 12, 12),
(13, 'Juan Jiménez', 'juan@hotmail.com', 3, 13, 13),
(14, 'María López', 'maria@yahoo.com', 3, 14, 14),
(15, 'Pablo Sánchez', 'pablo@gmail.com', 3, 15, 15);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `certamenes`
--

CREATE TABLE `certamenes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `certamenes`
--

INSERT INTO `certamenes` (`id`, `nombre`) VALUES
(1, 'Instancia Institucional');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `instancias`
--

CREATE TABLE `instancias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `certamen_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `instancias`
--

INSERT INTO `instancias` (`id`, `nombre`, `certamen_id`) VALUES
(1, '1', 1),
(2, '', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `instituciones`
--

CREATE TABLE `instituciones` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `logo_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `instituciones`
--

INSERT INTO `instituciones` (`id`, `nombre`, `logo_path`) VALUES
(1, 'Escuela Tecnica \"Carmen Molina de Llano\"', 'images/logoInstitucion/logo1.png'),
(2, 'Instituto Privado San José', 'images/logoInstitucion/logo2.png'),
(3, 'Colegio Nacional General San Martin', 'images/logoInstitucion/logo3.png'),
(4, 'Escuela de Comercio \"Manuel Belgrano\"', 'images/logoInstitucion/logo4.png'),
(5, 'Colegio Secundario B° Apipé', 'images/logoInstitucion/logo5.png'),
(6, 'Colegio Santa Ana', 'images/logoInstitucion/logo6.png'),
(7, 'Escuela Normal \"Bella Vista Corrientes\"', 'images/logoInstitucion/logo8.png'),
(8, 'Colegio Dr. Arturo Frondizi', 'images/logoInstitucion/logo9.png'),
(9, 'Escuela Hipolito', 'images/logoInstitucion/logo10.png'),
(10, 'Instituto Informático \"Juan de Vera\"', 'images/logoInstitucion/logo11.png'),
(11, 'Escuela Técnica \"Juana Manso\"', 'images/logoInstitucion/logo12.png'),
(12, 'Instituto Misericordia', 'images/logoInstitucion/logo13.png'),
(13, 'Escuela Normal \"Beron de Astrada\"', 'images/logoInstitucion/logo14.png'),
(14, 'Instituto Roubineau', 'images/logoInstitucion/logo15.png'),
(15, 'Colegio Salesiano', 'images/logoInstitucion/salesiano.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `performance`
--

CREATE TABLE `performance` (
  `id` int(11) NOT NULL,
  `alumno_id` int(11) DEFAULT NULL,
  `instancia_id` int(11) DEFAULT NULL,
  `tiempo` varchar(20) DEFAULT NULL,
  `penalizacion` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `performance`
--

INSERT INTO `performance` (`id`, `alumno_id`, `instancia_id`, `tiempo`, `penalizacion`) VALUES
(31, 1, 1, '00:30', 0),
(32, 2, 1, '00:23', 0),
(33, 3, 1, '00:17', 0),
(34, 4, 1, '01:27', 2),
(35, 5, 1, '00:36', 0),
(36, 6, 1, '00:12', 0),
(37, 7, 1, '00:46', 1),
(38, 8, 1, '00:00', 0),
(39, 9, 1, '00:00', 0),
(40, 10, 1, '00:00', 0),
(41, 11, 1, '00:00', 0),
(42, 12, 1, '00:00', 0),
(43, 13, 1, '00:00', 0),
(44, 14, 1, '00:00', 0),
(45, 15, 1, '00:00', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesores`
--

CREATE TABLE `profesores` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `apellido` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `profesores`
--

INSERT INTO `profesores` (`id`, `nombre`, `apellido`) VALUES
(1, 'Juan', 'Martínez'),
(2, 'María', 'Gómez'),
(3, 'Pedro', 'Rodríguez'),
(4, 'Laura', 'López'),
(5, 'Carlos', 'Hernández'),
(6, 'Ana', 'Pérez'),
(7, 'Diego', 'García'),
(8, 'Sofía', 'Díaz'),
(9, 'Luis', 'Martín'),
(10, 'Elena', 'Ruiz'),
(11, 'Pablo', 'Jiménez'),
(12, 'Andrea', 'Álvarez'),
(13, 'Javier', 'Moreno'),
(14, 'Lucía', 'Romero'),
(15, 'Daniel', 'Alonso');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alumnos`
--
ALTER TABLE `alumnos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `institucion_id` (`institucion_id`),
  ADD KEY `profesor_id` (`profesor_id`);

--
-- Indices de la tabla `certamenes`
--
ALTER TABLE `certamenes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `instancias`
--
ALTER TABLE `instancias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `certamen_id` (`certamen_id`);

--
-- Indices de la tabla `instituciones`
--
ALTER TABLE `instituciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `performance`
--
ALTER TABLE `performance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `alumno_id` (`alumno_id`),
  ADD KEY `instancia_id` (`instancia_id`);

--
-- Indices de la tabla `profesores`
--
ALTER TABLE `profesores`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alumnos`
--
ALTER TABLE `alumnos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `certamenes`
--
ALTER TABLE `certamenes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `instancias`
--
ALTER TABLE `instancias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `instituciones`
--
ALTER TABLE `instituciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `performance`
--
ALTER TABLE `performance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT de la tabla `profesores`
--
ALTER TABLE `profesores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `alumnos`
--
ALTER TABLE `alumnos`
  ADD CONSTRAINT `alumnos_ibfk_1` FOREIGN KEY (`institucion_id`) REFERENCES `instituciones` (`id`),
  ADD CONSTRAINT `alumnos_ibfk_2` FOREIGN KEY (`profesor_id`) REFERENCES `profesores` (`id`);

--
-- Filtros para la tabla `instancias`
--
ALTER TABLE `instancias`
  ADD CONSTRAINT `instancias_ibfk_1` FOREIGN KEY (`certamen_id`) REFERENCES `certamenes` (`id`);

--
-- Filtros para la tabla `performance`
--
ALTER TABLE `performance`
  ADD CONSTRAINT `performance_ibfk_1` FOREIGN KEY (`alumno_id`) REFERENCES `alumnos` (`id`),
  ADD CONSTRAINT `performance_ibfk_2` FOREIGN KEY (`instancia_id`) REFERENCES `instancias` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-08-2024 a las 19:39:51
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
  `institucion_id` int(11) DEFAULT NULL,
  `profesor_id` int(11) DEFAULT NULL,
  `nivel_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `alumnos`
--

INSERT INTO `alumnos` (`id`, `nombre`, `email`, `institucion_id`, `profesor_id`, `nivel_id`) VALUES
(45, 'Acosta Judith', NULL, 1, 1, 1),
(46, 'Rivero Lucas', NULL, 1, 1, 1),
(47, 'Alarcon Tomas', NULL, 1, 1, 1),
(48, 'Gonzales Santino', NULL, 1, 1, 1),
(49, 'Ramirez Ian', NULL, 1, 1, 1),
(50, 'Lazos Kiara', NULL, 1, 1, 1),
(51, 'Pared Garrido Octavio', NULL, 1, 1, 1),
(52, 'Britez Victoria', NULL, 1, 1, 1),
(53, 'Maidana Mauro', NULL, 1, 1, 1),
(54, 'Danieli Exequiel', NULL, 1, 21, 1),
(55, 'Maidana Hana Juliette', NULL, 1, 21, 1),
(56, 'Perez Alegra Bautista', NULL, 1, 20, 1),
(57, 'Vallejos Cesia Ester', NULL, 1, 20, 1),
(58, 'Monzon Jeremy', NULL, 1, 22, 2),
(59, 'Romero Uriel', NULL, 1, 22, 2),
(60, 'Suarez Dante', NULL, 1, 22, 2),
(61, 'Romero Antonella', NULL, 1, 19, 2),
(62, 'Vallejos Octavio', NULL, 1, 19, 2),
(63, 'Ledesma Franco', NULL, 1, 19, 2),
(64, 'Torres Ma. Victoria', NULL, 1, 19, 2),
(65, 'Leiva Ignacio', NULL, 1, 19, 3),
(66, 'Alegre Fiorella', NULL, 1, 19, 3),
(67, 'Fernandez Cristian', NULL, 1, 19, 3),
(68, 'Gomez Angel', NULL, 1, 19, 3),
(69, 'Domato Antonella', NULL, 1, 19, 3),
(70, 'Legal Brest Pia', NULL, 1, 20, 3),
(71, 'Romero Uriel', NULL, 1, 20, 3),
(72, 'Enriquez Santiago', NULL, 1, 20, 3);

--
-- Disparadores `alumnos`
--
DELIMITER $$
CREATE TRIGGER `performance_rows` AFTER INSERT ON `alumnos` FOR EACH ROW INSERT INTO performance (alumno_id, instancia_id, nivel_id) VALUES (NEW.id, 1, NEW.nivel_id)
$$
DELIMITER ;

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
  `cantidad_participantes` int(3) DEFAULT 5,
  `certamen_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `instancias`
--

INSERT INTO `instancias` (`id`, `cantidad_participantes`, `certamen_id`) VALUES
(1, 5, 1),
(2, 3, 1),
(3, 2, 1);

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
(1, 'Escuela Tecnica \"Carmen Molina de Llano\"', 'styles/images/logoInstitucion/Llano.png'),
(2, 'Instituto Privado San José', 'styles/images/logoInstitucion/SanJose.png'),
(3, 'Colegio Nacional General San Martin', 'styles/images/logoInstitucion/SanMartin.png'),
(4, 'Escuela de Comercio \"Manuel Belgrano\"', 'styles/images/logoInstitucion/ManuelBelgrano.png'),
(5, 'Colegio Secundario B° Apipé', 'styles/images/logoInstitucion/Apipe.png'),
(6, 'Colegio Santa Ana', 'styles/images/logoInstitucion/SantaAna.png'),
(7, 'Escuela Normal \"Bella Vista Corrientes\"', 'styles/images/logoInstitucion/BellaVista.png'),
(8, 'Colegio Dr. Arturo Frondizi', 'styles/images/logoInstitucion/ArturoFrondizi.png'),
(9, 'Escuela Hipolito', 'styles/images/logoInstitucion/Hipolito.png'),
(10, 'Instituto Informático \"Juan de Vera\"', 'styles/images/logoInstitucion/JuanDeVera.png'),
(11, 'Escuela Técnica \"Juana Manso\"', 'styles/images/logoInstitucion/JuanaManso.png'),
(12, 'Instituto Misericordia', 'styles/images/logoInstitucion/Misericordia.png'),
(13, 'Escuela Normal \"Beron de Astrada\"', 'styles/images/logoInstitucion/BeronDeAstrada.png'),
(14, 'Instituto Roubineau', 'styles/images/logoInstitucion/Roubineau.png'),
(15, 'Colegio Salesiano', 'styles/images/logoInstitucion/Salesiano.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `niveles`
--

CREATE TABLE `niveles` (
  `id` int(11) NOT NULL,
  `nivel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `niveles`
--

INSERT INTO `niveles` (`id`, `nivel`) VALUES
(1, 1),
(2, 2),
(3, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `palabras`
--

CREATE TABLE `palabras` (
  `ID` int(11) NOT NULL,
  `palabra` varchar(100) DEFAULT NULL,
  `nivel_palabra` int(1) NOT NULL,
  `instancia_palabra` int(1) DEFAULT NULL,
  `disponibilidad` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `palabras`
--

INSERT INTO `palabras` (`ID`, `palabra`, `nivel_palabra`, `instancia_palabra`, `disponibilidad`) VALUES
(1, 'Three', 3, NULL, 1),
(2, 'Four', 3, NULL, 1),
(3, 'Five', 3, NULL, 1),
(4, 'Seven', 3, NULL, 1),
(5, 'Eight', 3, NULL, 1),
(6, 'Nine', 3, NULL, 1),
(7, 'Eleven', 3, NULL, 1),
(8, 'Twelve', 3, NULL, 1),
(9, 'Thirteen', 3, NULL, 1),
(10, 'Fourteen', 3, NULL, 1),
(11, 'Fifteen', 3, NULL, 1),
(12, 'Sixteen', 3, NULL, 1),
(13, 'Seventeen', 3, NULL, 1),
(14, 'Eighteen', 3, NULL, 1),
(15, 'Nineteen', 3, NULL, 1),
(16, 'Twenty', 3, NULL, 1),
(17, 'Thirty', 3, NULL, 1),
(18, 'Forty', 3, NULL, 1),
(19, 'Fifty', 3, NULL, 1),
(20, 'Sixty', 3, NULL, 1),
(21, 'Seventy', 3, NULL, 1),
(22, 'Eighty', 3, NULL, 1),
(23, 'Ninety', 3, NULL, 1),
(24, 'A hundred', 3, NULL, 1),
(25, 'Two hundred', 3, NULL, 1),
(26, 'three hundred', 3, NULL, 1),
(27, 'Four hundred', 3, NULL, 1),
(28, 'Five hundred', 3, NULL, 1),
(29, 'Six hundred', 3, NULL, 1),
(30, 'Seven hundred', 3, NULL, 1),
(31, 'Eight hundred', 3, NULL, 1),
(32, 'Nine hundred', 3, NULL, 1),
(33, 'One thousand', 3, NULL, 1),
(34, 'Two thousand', 3, NULL, 1),
(35, 'Three thousand', 3, NULL, 1),
(36, 'Four thousand', 3, NULL, 1),
(37, 'Five thousand', 3, NULL, 1),
(38, 'Six thousand', 3, NULL, 1),
(39, 'Seven thousand', 3, NULL, 1),
(40, 'Eight thousand', 3, NULL, 1),
(41, 'Nine thousand', 3, NULL, 1),
(42, 'Ten thousand', 3, NULL, 1),
(43, 'Hello', 3, NULL, 1),
(44, 'Hi', 3, NULL, 1),
(45, 'Good Morning', 3, NULL, 1),
(46, 'Good Afternoon', 3, NULL, 1),
(47, 'Good Night', 3, NULL, 1),
(48, 'Good Evening', 3, NULL, 1),
(49, 'Goodbye', 3, NULL, 1),
(50, 'See You Later', 3, NULL, 1),
(51, 'Bye', 3, NULL, 1),
(52, 'Chips', 3, NULL, 1),
(53, 'Fries', 3, NULL, 1),
(54, 'Fish', 3, NULL, 1),
(55, 'Pizza', 3, NULL, 1),
(56, 'Hamburguer', 3, NULL, 1),
(57, 'Ice-cream', 3, NULL, 1),
(58, 'Spaghetti', 3, NULL, 1),
(59, 'Fruit', 3, NULL, 1),
(60, 'Vegetables', 3, NULL, 1),
(61, 'Meat', 3, NULL, 1),
(62, 'Eggs', 3, NULL, 1),
(63, 'Omelette', 3, NULL, 1),
(64, 'Sandwich', 3, NULL, 1),
(65, 'Milk', 3, NULL, 1),
(66, 'Yoghurt', 3, NULL, 1),
(67, 'Cheese', 3, NULL, 1),
(68, 'Beef', 3, NULL, 1),
(69, 'Chicken', 3, NULL, 1),
(70, 'Apple', 3, NULL, 1),
(71, 'Orange', 3, NULL, 1),
(72, 'Banana', 3, NULL, 1),
(73, 'Strawberries', 3, NULL, 1),
(74, 'Carrot', 3, NULL, 1),
(75, 'Lettuce', 3, NULL, 1),
(76, 'Tomato', 3, NULL, 1),
(77, 'Onion', 3, NULL, 1),
(78, 'Potato', 3, NULL, 1),
(79, 'Pasta', 3, NULL, 1),
(80, 'Bread', 3, NULL, 1),
(81, 'Rice', 3, NULL, 1),
(82, 'Stew', 3, NULL, 1),
(83, 'Acrobat', 3, NULL, 1),
(84, 'Musician', 3, NULL, 1),
(85, 'Magician', 3, NULL, 1),
(86, 'Dancer', 3, NULL, 1),
(87, 'Artist', 3, NULL, 1),
(88, 'Model', 3, NULL, 1),
(89, 'Photographer', 3, NULL, 1),
(90, 'Videographer', 3, NULL, 1),
(91, 'Entertainer', 3, NULL, 1),
(92, 'Fashion', 3, NULL, 1),
(93, 'Stylist', 3, NULL, 1),
(94, 'Always', 3, NULL, 1),
(95, 'Usually', 3, NULL, 1),
(96, 'Sometimes', 3, NULL, 1),
(97, 'Often', 3, NULL, 1),
(98, 'Never', 3, NULL, 1),
(99, 'Hardly ever', 3, NULL, 1),
(100, 'Frequently', 3, NULL, 1),
(101, 'Seldom', 3, NULL, 1),
(102, 'Good', 3, NULL, 1),
(103, 'Better', 3, NULL, 1),
(104, 'Best', 3, NULL, 1),
(105, 'Bad', 3, NULL, 1),
(106, 'Worse', 3, NULL, 1),
(107, 'Worst', 3, NULL, 1),
(108, 'Little', 3, NULL, 1),
(109, 'Less', 3, NULL, 1),
(110, 'Least', 3, NULL, 1),
(111, 'Many', 3, NULL, 1),
(112, 'More', 3, NULL, 1),
(113, 'Most', 3, NULL, 1),
(114, 'Tall', 3, NULL, 1),
(115, 'Taller', 3, NULL, 1),
(116, 'Tallest', 3, NULL, 1),
(117, 'Short', 3, NULL, 1),
(118, 'Shorter', 3, NULL, 1),
(119, 'Shortest', 3, NULL, 1),
(120, 'Cheap', 3, NULL, 1),
(121, 'Cheaper', 3, NULL, 1),
(122, 'Cheapest', 3, NULL, 1),
(123, 'Intelligent', 3, NULL, 1),
(124, 'More intelligent', 3, NULL, 1),
(125, 'Most intelligent', 3, NULL, 1),
(126, 'Expensive', 3, NULL, 1),
(127, 'More expensive', 3, NULL, 1),
(128, 'Most expensive', 3, NULL, 1),
(129, 'Head', 3, NULL, 1),
(130, 'Hands', 3, NULL, 1),
(131, 'Legs', 3, NULL, 1),
(132, 'Shoulders', 3, NULL, 1),
(133, 'Kness', 3, NULL, 1),
(134, 'Fingers', 3, NULL, 1),
(135, 'Toe', 3, NULL, 1),
(136, 'Mounth', 3, NULL, 1),
(137, 'Eyes', 3, NULL, 1),
(138, 'Nose', 3, NULL, 1),
(139, 'Ears', 3, NULL, 1),
(140, 'Tongue', 3, NULL, 1),
(141, 'Lungs', 3, NULL, 1),
(142, 'Stomach', 3, NULL, 1),
(143, 'Brain', 3, NULL, 1),
(144, 'Kidneys', 3, NULL, 1),
(145, 'Bones', 3, NULL, 1),
(146, 'Throat', 3, NULL, 1),
(147, 'Heart', 3, NULL, 1),
(148, 'Muscles', 3, NULL, 1),
(149, 'Funny', 3, NULL, 1),
(150, 'Sensitive', 3, NULL, 1),
(151, 'Sensible', 3, NULL, 1),
(152, 'Chatty', 3, NULL, 1),
(153, 'Cheerful', 3, NULL, 1),
(154, 'Competitive', 3, NULL, 1),
(155, 'Considerate', 3, NULL, 1),
(156, 'Hard-working', 3, NULL, 1),
(157, 'Idealistic', 3, NULL, 1),
(158, 'Impatient', 3, NULL, 1),
(159, 'Patient', 3, NULL, 1),
(160, 'Kind', 3, NULL, 1),
(161, 'Moody', 3, NULL, 1),
(162, 'Popular', 3, NULL, 1),
(163, 'Reliable', 3, NULL, 1),
(164, 'Romantic', 3, NULL, 1),
(165, 'Selfish', 3, NULL, 1),
(166, 'Shy', 3, NULL, 1),
(167, 'Emotional', 3, NULL, 1),
(168, 'Tolerant', 3, NULL, 1),
(169, 'Sociable', 3, NULL, 1),
(170, 'Polite', 3, NULL, 1),
(171, 'Liberal', 3, NULL, 1),
(172, 'Independent', 3, NULL, 1),
(173, 'Dependent', 3, NULL, 1),
(174, 'Creative', 3, NULL, 1),
(175, 'Decisive', 3, NULL, 1),
(176, 'Careless', 3, NULL, 1),
(177, 'Childish', 3, NULL, 1),
(178, 'Hospital', 3, NULL, 1),
(179, 'Petrol station', 3, NULL, 1),
(180, 'Hotel Factory', 3, NULL, 1),
(181, 'Car park', 3, NULL, 1),
(182, 'Bus stop', 3, NULL, 1),
(183, 'Church', 3, NULL, 1),
(184, 'Club', 3, NULL, 1),
(185, 'Cinema', 3, NULL, 1),
(186, 'Restaurant', 3, NULL, 1),
(187, 'School', 3, NULL, 1),
(188, 'Square', 3, NULL, 1),
(189, 'Park', 3, NULL, 1),
(190, 'Pool', 3, NULL, 1),
(191, 'Shopping Mall', 3, NULL, 1),
(192, 'Supermarket', 3, NULL, 1),
(193, 'Shops', 3, NULL, 1),
(194, 'Fire Station', 3, NULL, 1),
(195, 'Police Station', 3, NULL, 1),
(196, 'Museum', 3, NULL, 1),
(197, 'Bank', 3, NULL, 1),
(198, 'Stadium', 3, NULL, 1),
(199, 'House', 3, NULL, 1),
(200, 'Blok of flats', 3, NULL, 1),
(201, 'Bookshop', 3, NULL, 1),
(202, 'Library', 3, NULL, 1),
(203, 'Cycling', 3, NULL, 1),
(204, 'Aerobics', 3, NULL, 1),
(205, 'Football', 3, NULL, 1),
(206, 'Reading', 3, NULL, 1),
(207, 'Skateboarding', 3, NULL, 1),
(208, 'Swimming', 3, NULL, 1),
(209, 'Martial Arts', 3, NULL, 1),
(210, 'Taekwondo', 3, NULL, 1),
(211, 'Karate', 3, NULL, 1),
(212, 'Watching TV', 3, NULL, 1),
(213, 'Going Out', 3, NULL, 1),
(214, 'Hanging Out', 3, NULL, 1),
(215, 'Gymnastics', 3, NULL, 1),
(216, 'Photography', 3, NULL, 1),
(217, 'Tennis', 3, NULL, 1),
(218, 'Table Tennis', 3, NULL, 1),
(219, 'Chess', 3, NULL, 1),
(220, 'Athletics', 3, NULL, 1),
(221, 'Pottery', 3, NULL, 1),
(222, 'Skiing', 3, NULL, 1),
(223, 'Dancing', 3, NULL, 1),
(224, 'Bowling', 3, NULL, 1),
(225, 'Basketball', 3, NULL, 1),
(226, 'Painting', 3, NULL, 1),
(227, 'Singing', 3, NULL, 1),
(228, 'Riding', 3, NULL, 1),
(229, 'Jogging', 3, NULL, 1),
(230, 'Wake up', 3, NULL, 1),
(231, 'Get up', 3, NULL, 1),
(232, 'Brush my teeth', 3, NULL, 1),
(233, 'Have a shower', 3, NULL, 1),
(234, 'Have a bath', 3, NULL, 1),
(235, 'Have breakfast', 3, NULL, 1),
(236, 'Watch TV', 3, NULL, 1),
(237, 'Cook', 3, NULL, 1),
(238, 'Study', 3, NULL, 1),
(239, 'Read', 3, NULL, 1),
(240, 'Talk', 3, NULL, 1),
(241, 'Sleep', 3, NULL, 1),
(242, 'Walk', 3, NULL, 1),
(243, 'Write', 3, NULL, 1),
(244, 'Drive', 3, NULL, 1),
(245, 'Run', 3, NULL, 1),
(246, 'Play', 3, NULL, 1),
(247, 'Swim', 3, NULL, 1),
(248, 'Work', 3, NULL, 1),
(249, 'Go shopping', 3, NULL, 1),
(250, 'Clean', 3, NULL, 1),
(251, 'Wash', 3, NULL, 1),
(252, 'Exercise', 3, NULL, 1),
(253, 'Drink', 3, NULL, 1),
(254, 'Eat', 3, NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `performance`
--

CREATE TABLE `performance` (
  `id` int(11) NOT NULL,
  `alumno_id` int(11) NOT NULL,
  `instancia_id` int(11) NOT NULL DEFAULT 1,
  `tiempo_deletreo` varchar(10) NOT NULL DEFAULT '00:00',
  `tiempo_oracion` varchar(10) NOT NULL DEFAULT '00:00',
  `tiempo_final` varchar(10) NOT NULL DEFAULT '00:00',
  `penalizacion_deletreo` int(11) NOT NULL DEFAULT 0,
  `penalizacion_oracion` int(11) NOT NULL DEFAULT 0,
  `penalizaciones_totales` int(11) NOT NULL DEFAULT 0,
  `nivel_id` int(11) NOT NULL,
  `audio_deletreo` int(80) DEFAULT NULL,
  `audio_oracion` int(80) DEFAULT NULL,
  `descalificados` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `performance`
--

INSERT INTO `performance` (`id`, `alumno_id`, `instancia_id`, `tiempo_deletreo`, `tiempo_oracion`, `tiempo_final`, `penalizacion_deletreo`, `penalizacion_oracion`, `penalizaciones_totales`, `nivel_id`, `audio_deletreo`, `audio_oracion`, `descalificados`) VALUES
(116, 45, 1, '00:00', '00:00', '00:00', 0, 0, 0, 1, NULL, NULL, 0),
(117, 46, 1, '00:00', '00:00', '00:00', 0, 0, 0, 1, NULL, NULL, 0),
(118, 47, 1, '00:00', '00:00', '00:00', 0, 0, 0, 1, NULL, NULL, 0),
(119, 48, 1, '00:00', '00:00', '00:00', 0, 0, 0, 1, NULL, NULL, 0),
(120, 49, 1, '00:00', '00:00', '00:00', 0, 0, 0, 1, NULL, NULL, 0),
(121, 50, 1, '00:00', '00:00', '00:00', 0, 0, 0, 1, NULL, NULL, 0),
(122, 51, 1, '00:00', '00:00', '00:00', 0, 0, 0, 1, NULL, NULL, 0),
(123, 52, 1, '00:00', '00:00', '00:00', 0, 0, 0, 1, NULL, NULL, 0),
(124, 53, 1, '00:00', '00:00', '00:00', 0, 0, 0, 1, NULL, NULL, 0),
(125, 54, 1, '00:00', '00:00', '00:00', 0, 0, 0, 1, NULL, NULL, 0),
(126, 55, 1, '00:00', '00:00', '00:00', 0, 0, 0, 1, NULL, NULL, 0),
(127, 56, 1, '00:00', '00:00', '00:00', 0, 0, 0, 1, NULL, NULL, 0),
(128, 57, 1, '00:00', '00:00', '00:00', 0, 0, 0, 1, NULL, NULL, 0),
(129, 58, 1, '00:00', '00:00', '00:00', 0, 0, 0, 2, NULL, NULL, 0),
(130, 59, 1, '00:00', '00:00', '00:00', 0, 0, 0, 2, NULL, NULL, 0),
(131, 60, 1, '00:00', '00:00', '00:00', 0, 0, 0, 2, NULL, NULL, 0),
(132, 61, 1, '00:00', '00:00', '00:00', 0, 0, 0, 2, NULL, NULL, 0),
(133, 62, 1, '00:00', '00:00', '00:00', 0, 0, 0, 2, NULL, NULL, 0),
(134, 63, 1, '00:00', '00:00', '00:00', 0, 0, 0, 2, NULL, NULL, 0),
(135, 64, 1, '00:00', '00:00', '00:00', 0, 0, 0, 2, NULL, NULL, 0),
(136, 65, 1, '00:00', '00:00', '00:00', 0, 0, 0, 3, NULL, NULL, 0),
(137, 66, 1, '00:00', '00:00', '00:00', 0, 0, 0, 3, NULL, NULL, 0),
(138, 67, 1, '00:00', '00:00', '00:00', 0, 0, 0, 3, NULL, NULL, 0),
(139, 68, 1, '00:00', '00:00', '00:00', 0, 0, 0, 3, NULL, NULL, 0),
(140, 69, 1, '00:00', '00:00', '00:00', 0, 0, 0, 3, NULL, NULL, 0),
(141, 70, 1, '00:00', '00:00', '00:00', 0, 0, 0, 3, NULL, NULL, 0),
(142, 71, 1, '00:00', '00:00', '00:00', 0, 0, 0, 3, NULL, NULL, 0),
(143, 72, 1, '00:00', '00:00', '00:00', 0, 0, 0, 3, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesores`
--

CREATE TABLE `profesores` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `profesores`
--

INSERT INTO `profesores` (`id`, `nombre`) VALUES
(1, '-'),
(16, 'Yanina Meneses'),
(17, 'Marcelo Valenzuela'),
(18, 'Mariela Kohon'),
(19, 'Ramiro'),
(20, 'Milagros Benitez'),
(21, 'Laura Tur'),
(22, 'Milagros Vazquez');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seleccionados`
--

CREATE TABLE `seleccionados` (
  `id` int(11) NOT NULL,
  `performance_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `seleccionados`
--

INSERT INTO `seleccionados` (`id`, `performance_id`) VALUES
(1, 34),
(2, 35),
(3, 36),
(4, 37);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alumnos`
--
ALTER TABLE `alumnos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `institucion_id` (`institucion_id`),
  ADD KEY `profesor_id` (`profesor_id`),
  ADD KEY `nivel_id` (`nivel_id`);

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
-- Indices de la tabla `niveles`
--
ALTER TABLE `niveles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `palabras`
--
ALTER TABLE `palabras`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `performance`
--
ALTER TABLE `performance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `alumno_id` (`alumno_id`),
  ADD KEY `nivel_id` (`nivel_id`);

--
-- Indices de la tabla `profesores`
--
ALTER TABLE `profesores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `seleccionados`
--
ALTER TABLE `seleccionados`
  ADD PRIMARY KEY (`id`),
  ADD KEY `performance_id` (`performance_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alumnos`
--
ALTER TABLE `alumnos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT de la tabla `certamenes`
--
ALTER TABLE `certamenes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `instancias`
--
ALTER TABLE `instancias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `instituciones`
--
ALTER TABLE `instituciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `niveles`
--
ALTER TABLE `niveles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `palabras`
--
ALTER TABLE `palabras`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=255;

--
-- AUTO_INCREMENT de la tabla `performance`
--
ALTER TABLE `performance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=144;

--
-- AUTO_INCREMENT de la tabla `profesores`
--
ALTER TABLE `profesores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `seleccionados`
--
ALTER TABLE `seleccionados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
  ADD CONSTRAINT `alumno_id` FOREIGN KEY (`alumno_id`) REFERENCES `alumnos` (`id`),
  ADD CONSTRAINT `nivel_id` FOREIGN KEY (`nivel_id`) REFERENCES `alumnos` (`nivel_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

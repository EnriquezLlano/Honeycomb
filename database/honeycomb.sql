-- MySQL dump 10.13  Distrib 8.0.38, for Win64 (x86_64)
--
-- Host: localhost    Database: honeycomb
-- ------------------------------------------------------
-- Server version	8.0.39

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `alumnos`
--

DROP TABLE IF EXISTS `alumnos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `alumnos` (
  `id_alumno` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nivel` int DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `id_institucion` int DEFAULT NULL,
  `id_profesor` int DEFAULT NULL,
  `foto_perfil` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id_alumno`),
  KEY `id_institucion` (`id_institucion`),
  KEY `id_profesor` (`id_profesor`),
  CONSTRAINT `alumnos_ibfk_1` FOREIGN KEY (`id_institucion`) REFERENCES `instituciones` (`id_institucion`),
  CONSTRAINT `alumnos_ibfk_2` FOREIGN KEY (`id_profesor`) REFERENCES `profesores` (`id_profesor`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alumnos`
--

LOCK TABLES `alumnos` WRITE;
/*!40000 ALTER TABLE `alumnos` DISABLE KEYS */;
INSERT INTO `alumnos` VALUES (1,'Juan',1,'',1,1,'fotos/juan_lopez.jpg'),(2,'Sofía',1,'',2,2,'fotos/sofia_perez.jpg'),(3,'Martín',2,'',3,3,'fotos/martin_garcia.jpg'),(4,'Lucía',2,'',4,4,'fotos/lucia_rodriguez.jpg'),(5,'Andrés',3,'',5,5,'fotos/andres_sanchez.jpg'),(6,'Camila',3,'',6,6,'fotos/camila_torres.jpg'),(7,'Nicolás',1,'',7,7,'fotos/nicolas_gonzalez.jpg'),(8,'Valentina',1,'',8,8,'fotos/valentina_fernandez.jpg'),(9,'Lucas',2,'',9,9,'fotos/lucas_munoz.jpg'),(10,'María',2,'',10,10,'fotos/maria_morales.jpg'),(11,'Diego',3,'',11,11,'fotos/diego_navarro.jpg'),(12,'Julieta',3,'',12,12,'fotos/julieta_reyes.jpg'),(13,'Emiliano',1,'',13,13,'fotos/emiliano_ruiz.jpg'),(14,'Carolina',1,'',14,14,'fotos/carolina_arias.jpg'),(15,'Esteban',2,'',15,15,'fotos/esteban_molina.jpg'),(18,'Mateo Garcia',1,'mateo.garcia@example.com',17,1,NULL),(19,'Valentina Rojas',1,'mateo.garcia@example.com',17,1,NULL),(20,'Lucas Fernandez',1,'mateo.garcia@example.com',17,2,NULL),(21,'Sofia Perez',1,'correoGenerico123@example.com',17,2,NULL),(22,'Santiago Lopez',1,'correoGenerico123@example.com',18,3,NULL),(23,'Martina Gomez',1,'correoGenerico321@example.com',18,3,NULL),(24,'Nicolas Rodriguez',1,'correoGenerico321@example.com',18,4,NULL),(25,'Emma Martinez',1,'correoGenerico@example.com',18,4,NULL),(26,'Tomas Diaz',1,'correoGenerico@example.com',19,5,NULL),(27,'Isabella Torres',1,'correoGenerico@example.com',19,5,NULL),(28,'Thiago Sanchez',1,'correoGenericoAlumno@example.com',19,6,NULL),(29,'Olivia Romero',1,'correoGenericoAlumno@example.com',19,6,NULL),(30,'Joaquin Ruiz',1,'correoAunMasGenerico@example.com',20,7,NULL),(31,'Mia Molina',1,'correoAunMasGenerico@example.com',20,7,NULL),(32,'Benjamin Silva',1,'correoAunMasGenerico@example.com',20,7,NULL),(33,'Amelia Herrera',2,'correoSegundoNivel@example.com',20,8,NULL),(34,'Manuel Vargas',2,'correoSegundoNivel@example.com',21,8,NULL),(35,'Luna Castro',2,'correoSegundoNivel@example.com',21,8,NULL),(36,'Gabriel Reyes',2,'correoComunSegundoNivel@example.com',21,9,NULL),(37,'Valeria Ortiz',2,'correoComunSegundoNivel@example.com',21,9,NULL),(38,'David Morales',2,'correoComunSegundoNivel@example.com',21,9,NULL),(39,'David Morales',2,'SegundoCorreo@example.com',22,10,NULL),(40,'Camila Mendoza',2,'SegundoCorreo@example.com',22,10,NULL),(41,'Martin Suarez',2,'SegundoCorreo@example.com',22,10,NULL),(42,'Julia Florez',2,'SegundoNivelCorreo@example.com',22,11,NULL),(43,'Agustin Vera',2,'SegundoNivelCorreo@example.com',22,11,NULL),(44,'Clara Dominguez',2,'SegundoNivelCorreo@example.com',22,11,NULL),(45,'Juan Cruz Herrera',2,'SegundoNivelCorreo@example.com',22,11,NULL),(46,'Gabriela Fuentes',2,'OtroCorreo@example.com',23,12,NULL),(47,'Lorenzo Campos',2,'OtroCorreo@example.com',23,12,NULL),(48,'Elisa Carrasco',2,'OtroCorreo@example.com',23,12,NULL),(49,'Diego Aguilar',3,'TercerCorreo@example.com',23,13,NULL),(50,'Julieta Castro',3,'TercerCorreo@example.com',23,13,NULL),(51,'Sebastian Gomez',3,'TercerCorreo@example.com',23,13,NULL),(52,'Renata Paredez',3,'TercerCorreo@example.com',23,13,NULL),(53,'Matia Cortez',3,'TercerCorreo@example.com',23,13,NULL),(54,'Antonella Cabrera',3,'MasCorreos@gmail.com',24,14,NULL),(55,'Emiliano Navarro',3,'MasCorreos@gmail.com',24,14,NULL),(56,'Angela Peña',3,'MasCorreos@gmail.com',24,14,NULL),(57,'Franco Vargas',3,'MasCorreos@gmail.com',24,14,NULL),(58,'Paulina Rios',3,'MasCorreos@gmail.com',24,14,NULL),(59,'Ignacio Guzman',3,'UltimosCorreos@gmail.com',25,15,NULL),(60,'Catalina Alvarez',3,'UltimosCorreos@gmail.com',25,15,NULL),(61,'Valentin Morales',3,'UltimosCorreos@gmail.com',25,15,NULL),(62,'Francisca Blanco',3,'UltimosCorreos@gmail.com',25,15,NULL),(63,'Federico Nuñez',3,'UltimosCorreos@gmail.com',25,15,NULL),(64,'Luana Itatí Schaffer',1,'',26,26,NULL),(65,'Brisa Ariana Espinosa',1,'',27,27,NULL),(66,'Tiziano Miranda',1,'',28,28,NULL),(67,'Ian Jose Sarza',1,'',29,29,NULL),(68,'Benítez Lautaro Gabriel',1,'',30,30,NULL),(69,'Mateo Niño Eginini',1,'',32,33,NULL),(70,'Centurión Arturo Salvador',1,'',33,34,NULL),(71,'Figueredo Vivero Axel',1,'',34,35,NULL),(72,'Soto Uriel Leonardo',1,'',35,36,NULL),(73,'Quevedo Keila',1,'',36,37,NULL),(74,'Gavilán Lautaro Leonel',1,'',37,38,NULL),(75,'Vallejos Cesia',1,'',38,39,NULL),(76,'Barrios Enzo Valentino',2,'',26,26,NULL),(77,'Suarez Alexander Atilio',2,'',27,27,NULL),(78,'Portillo Brian',2,'',28,28,NULL),(79,'Proz Blanco Braian',2,'',29,29,NULL),(80,'García Marianella',2,'',30,30,NULL),(81,'Barrios Luisana',2,'',31,32,NULL),(82,'Gimenez Camila',2,'',32,33,NULL),(83,'Silba Omar Eduardo',2,'',33,34,NULL),(84,'Aranda Fabiana',2,'',34,35,NULL),(85,'Fontela Anabela Mariana de los Angeles',2,'',35,36,NULL),(86,'Alfonso Valentina',2,'',36,37,NULL),(87,'Benítez Leiva Gabriel Alejandro',2,'',37,38,NULL),(88,'Suarez Dante',2,'',38,39,NULL),(89,'Sánchez Guillermo Luis',3,'',26,26,NULL),(90,'Gómez Giuliano',3,'',27,27,NULL),(91,'Jara Arias Ana Paula',3,'',29,29,NULL),(92,'Soto Oscar Benito',3,'',30,31,NULL),(93,'Rebull Enrique Daniel',3,'',31,32,NULL),(94,'Marambio Tobias',3,'',32,33,NULL),(95,'Ramírez Lazos Cristian Jair',3,'',33,34,NULL),(96,'Romero Francisco',3,'',34,35,NULL),(97,'Benitez Rosario',3,'',35,36,NULL),(98,'Torres Pablo',3,'',36,37,NULL),(99,'Cristaldo Lautaro',3,'',37,38,NULL),(100,'Enriquez Santiago Emmanuel',3,'',38,40,NULL);
/*!40000 ALTER TABLE `alumnos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `eventos`
--

DROP TABLE IF EXISTS `eventos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `eventos` (
  `id_evento` int NOT NULL AUTO_INCREMENT,
  `nombre_evento` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_institucion` int DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  PRIMARY KEY (`id_evento`),
  KEY `id_institucion` (`id_institucion`),
  CONSTRAINT `eventos_ibfk_1` FOREIGN KEY (`id_institucion`) REFERENCES `instituciones` (`id_institucion`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `eventos`
--

LOCK TABLES `eventos` WRITE;
/*!40000 ALTER TABLE `eventos` DISABLE KEYS */;
INSERT INTO `eventos` VALUES (1,'Spelling Bee 2024',1,'2024-09-01'),(4,'Evento de Pruebas',NULL,NULL),(5,'Spelling Bee - Interescolar',NULL,NULL),(6,'Spelling Bee - Intercurso Amanecer',NULL,NULL);
/*!40000 ALTER TABLE `eventos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `instituciones`
--

DROP TABLE IF EXISTS `instituciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `instituciones` (
  `id_institucion` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'predeterminado.png',
  `id_evento` int NOT NULL,
  PRIMARY KEY (`id_institucion`),
  KEY `instituciones_ibfk_1` (`id_evento`),
  CONSTRAINT `instituciones_ibfk_1` FOREIGN KEY (`id_evento`) REFERENCES `eventos` (`id_evento`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `instituciones`
--

LOCK TABLES `instituciones` WRITE;
/*!40000 ALTER TABLE `instituciones` DISABLE KEYS */;
INSERT INTO `instituciones` VALUES (1,'Institución San Martín','SanMartin.png',1),(2,'Colegio Independencia','independencia.png',1),(3,'Escuela Belgrano','belgrano.png',1),(4,'Instituto Sarmiento','sarmiento.png',1),(5,'Colegio Nacional','nacional.png',1),(6,'Instituto Mariano Moreno','moreno.png',1),(7,'Escuela Mitre','mitre.png',1),(8,'Instituto Rosas','rosas.png',1),(9,'Colegio Patria','patria.png',1),(10,'Escuela República','republica.png',1),(11,'Colegio Libertad','libertad.png',1),(12,'Instituto San José','san_jose.png',1),(13,'Escuela 25 de Mayo','25_mayo.png',1),(14,'Colegio Unión','union.png',1),(15,'Instituto de Ciencias','ciencias.png',1),(17,'institucion de prueba 1','predeterminado.png',4),(18,'institucion de prueba 2','predeterminado.png',4),(19,'institucion de prueba 3','predeterminado.png',4),(20,'institucion de prueba 4','predeterminado.png',4),(21,'institucion de prueba 5','predeterminado.png',4),(22,'institucion de prueba 6','predeterminado.png',4),(23,'institucion de prueba 7','predeterminado.png',4),(24,'institucion de prueba 8','predeterminado.png',4),(25,'institucion de prueba 9','predeterminado.png',4),(26,'Escuela Normal \"José Manuel Estrada\"','EscuelaNormalJoseManuelEstrada.png',5),(27,'Escuela Normal \"Dr. Pedro Bonastre\"','EscuelaNormalDrPedroBonastre.png',5),(28,'Colegio Secundario \"Brigadier General Pedro Ferre\"','ColegioSecundarioBrigadierGeneralPedroFerre.png',5),(29,'Colegio Secundario \"Ramon M. Gomez\"','ColegioSecundarioProfesorRamonMGomez.png',5),(30,'Instituto Superior \"Nuestra Señora de la Misericordia\" I-29','InstitutoSuperiorNuestraSeñoraDeLaMisericordiaI-29.png',5),(31,'Escuela Normal “Dr. Juan Pujol”','EscuelaNormalDrJuanPujol.png',5),(32,'Colegio Secundario “Manuel Belgrano”','ColegioSecundarioManuelBelgrano.png',5),(33,'Esc. Tec. “Construcciones Portuarias y Vías Navegables”','EscuelaTecnicaConstruccionesPortuariasyViasNavegables.png',5),(34,'Colegio del Barrio “Dr. Fernando Piragine Niveyro”','ColegioSecundarioPiragineNiveyro.png',5),(35,'Colegio Secundario “Olga Cossettini”','ColegioSecundarioOlgaCossettini.png',5),(36,'Colegio Secundario del Paraje Ensenadita','ColegioSecundarioDelParajeDeEnsenadita.png',5),(37,'Escuela Técnica “Juana Manso”','EscuelaTecnicaJuanaManso.png',5),(38,'Esc. Técnica “Camen Molina de Llano”','EscuelaTecnicaCarmenMdeLlano.png',5);
/*!40000 ALTER TABLE `instituciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `participantes`
--

DROP TABLE IF EXISTS `participantes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `participantes` (
  `id_participante` int NOT NULL AUTO_INCREMENT,
  `id_alumno` int DEFAULT NULL,
  `id_evento` int DEFAULT NULL,
  `nivel` int DEFAULT NULL,
  `instancia_alcanzada` int NOT NULL DEFAULT '1',
  `tiempo_deletreo` varchar(10) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '00:00',
  `tiempo_oracion` varchar(10) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '00:00',
  `tiempo_total` varchar(10) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '00:00',
  `penalizacion_deletreo` int NOT NULL DEFAULT '0',
  `penalizacion_oracion` int NOT NULL DEFAULT '0',
  `fallo` tinyint(1) NOT NULL DEFAULT '0',
  `audio_deletro` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `audio_oracion` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id_participante`),
  KEY `id_alumno` (`id_alumno`),
  KEY `id_evento` (`id_evento`),
  CONSTRAINT `participantes_ibfk_1` FOREIGN KEY (`id_alumno`) REFERENCES `alumnos` (`id_alumno`),
  CONSTRAINT `participantes_ibfk_2` FOREIGN KEY (`id_evento`) REFERENCES `eventos` (`id_evento`)
) ENGINE=InnoDB AUTO_INCREMENT=226 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `participantes`
--

LOCK TABLES `participantes` WRITE;
/*!40000 ALTER TABLE `participantes` DISABLE KEYS */;
INSERT INTO `participantes` VALUES (1,1,1,1,1,'00:00','00:00','00:00',0,0,0,NULL,NULL),(2,2,1,1,1,'00:00','00:00','00:00',0,0,0,NULL,NULL),(3,3,1,2,1,'00:00','00:00','00:00',0,0,0,NULL,NULL),(4,4,1,2,1,'00:00','00:00','00:00',0,0,0,NULL,NULL),(5,5,1,3,1,'00:00','00:00','00:00',0,0,0,NULL,NULL),(6,6,1,3,1,'00:00','00:00','00:00',0,0,0,NULL,NULL),(7,7,1,1,1,'00:00','00:00','00:00',0,0,0,NULL,NULL),(8,8,1,1,1,'00:00','00:00','00:00',0,0,0,NULL,NULL),(9,9,1,2,1,'00:00','00:00','00:00',0,0,0,NULL,NULL),(10,10,1,2,1,'00:00','00:00','00:00',0,0,0,NULL,NULL),(11,11,1,3,1,'00:00','00:00','00:00',0,0,0,NULL,NULL),(12,12,1,3,1,'00:00','00:00','00:00',0,0,0,NULL,NULL),(13,13,1,1,1,'00:00','00:00','00:00',0,0,0,NULL,NULL),(14,14,1,1,1,'00:00','00:00','00:00',0,0,0,NULL,NULL),(15,15,1,2,1,'00:00','00:00','00:00',0,0,0,NULL,NULL),(18,19,4,1,1,'00:00','00:00','00:00',0,0,0,NULL,NULL),(19,20,4,1,1,'00:00','00:00','00:00',0,0,0,NULL,NULL),(20,21,4,1,1,'00:00','00:00','00:00',0,0,0,NULL,NULL),(21,22,4,1,1,'00:00','00:00','00:00',0,0,0,NULL,NULL),(22,23,4,1,1,'00:00','00:00','00:00',0,0,0,NULL,NULL),(23,24,4,1,1,'00:00','00:00','00:00',0,0,0,NULL,NULL),(24,25,4,1,1,'00:00','00:00','00:00',0,0,0,NULL,NULL),(25,26,4,1,1,'00:00','00:00','00:00',0,0,0,NULL,NULL),(26,27,4,1,1,'00:00','00:00','00:00',0,0,0,NULL,NULL),(27,28,4,1,1,'00:00','00:00','00:00',0,0,0,NULL,NULL),(28,29,4,1,1,'00:00','00:00','00:00',0,0,0,NULL,NULL),(29,30,4,1,1,'00:00','00:00','00:00',0,0,0,NULL,NULL),(30,31,4,1,1,'00:00','00:00','00:00',0,0,0,NULL,NULL),(31,32,4,1,1,'00:00','00:00','00:00',0,0,0,NULL,NULL),(32,33,4,2,1,'00:00','00:00','00:00',0,0,0,NULL,NULL),(33,34,4,2,1,'00:00','00:00','00:00',0,0,0,NULL,NULL),(34,35,4,2,1,'00:00','00:00','00:00',0,0,0,NULL,NULL),(35,36,4,2,1,'00:00','00:00','00:00',0,0,0,NULL,NULL),(36,37,4,2,1,'00:00','00:00','00:00',0,0,0,NULL,NULL),(37,38,4,2,1,'00:00','00:00','00:00',0,0,0,NULL,NULL),(38,39,4,2,1,'00:00','00:00','00:00',0,0,0,NULL,NULL),(39,40,4,2,1,'00:00','00:00','00:00',0,0,0,NULL,NULL),(40,41,4,2,1,'00:00','00:00','00:00',0,0,0,NULL,NULL),(41,42,4,2,1,'00:00','00:00','00:00',0,0,0,NULL,NULL),(42,43,4,2,1,'00:00','00:00','00:00',0,0,0,NULL,NULL),(43,44,4,2,1,'00:00','00:00','00:00',0,0,0,NULL,NULL),(44,45,4,2,1,'00:00','00:00','00:00',0,0,0,NULL,NULL),(45,46,4,2,1,'00:00','00:00','00:00',0,0,0,NULL,NULL),(46,47,4,2,1,'00:00','00:00','00:00',0,0,0,NULL,NULL),(47,48,4,2,1,'00:00','00:00','00:00',0,0,0,NULL,NULL),(48,49,4,3,1,'00:00','00:00','00:00',0,0,0,NULL,NULL),(49,50,4,3,1,'00:00','00:00','00:00',0,0,0,NULL,NULL),(50,51,4,3,1,'00:00','00:00','00:00',0,0,0,NULL,NULL),(51,52,4,3,1,'00:00','00:00','00:00',0,0,0,NULL,NULL),(52,53,4,3,1,'00:00','00:00','00:00',0,0,0,NULL,NULL),(53,54,4,3,1,'00:00','00:00','00:00',0,0,0,NULL,NULL),(54,55,4,3,1,'00:00','00:00','00:00',0,0,0,NULL,NULL),(55,56,4,3,1,'00:00','00:00','00:00',0,0,0,NULL,NULL),(56,57,4,3,1,'00:00','00:00','00:00',0,0,0,NULL,NULL),(57,58,4,3,1,'00:00','00:00','00:00',0,0,0,NULL,NULL),(58,59,4,3,1,'00:00','00:00','00:00',0,0,0,NULL,NULL),(59,60,4,3,1,'00:00','00:00','00:00',0,0,0,NULL,NULL),(60,61,4,3,1,'00:00','00:00','00:00',0,0,0,NULL,NULL),(61,62,4,3,1,'00:00','00:00','00:00',0,0,0,NULL,NULL),(62,63,4,3,1,'00:00','00:00','00:00',0,0,0,NULL,NULL),(71,29,4,1,3,'00:00','00:00','00:00',0,0,0,NULL,NULL),(72,29,4,1,4,'00:00','00:00','00:00',0,0,0,NULL,NULL),(73,31,4,1,3,'00:00','00:00','00:00',0,0,0,NULL,NULL),(74,31,4,1,4,'00:00','00:00','00:00',0,0,0,NULL,NULL),(75,64,5,1,1,'02:82','00:00','00:00',0,0,0,NULL,NULL),(76,65,5,1,1,'02:05','00:00','00:00',0,0,0,NULL,NULL),(77,66,5,1,1,'01:73','00:00','00:00',1,0,0,NULL,NULL),(78,67,5,1,1,'04:49','00:00','00:00',0,0,0,NULL,NULL),(79,68,5,1,1,'03:12','00:00','00:00',0,0,0,NULL,NULL),(80,69,5,1,1,'01:79','00:00','00:00',0,0,0,NULL,NULL),(81,70,5,1,1,'04:85','00:00','00:00',0,0,0,NULL,NULL),(82,71,5,1,1,'04:88','00:00','00:00',0,0,0,NULL,NULL),(83,72,5,1,1,'02:69','00:00','00:00',0,0,0,NULL,NULL),(84,73,5,1,1,'06:98','00:00','00:00',0,0,0,NULL,NULL),(85,74,5,1,1,'02:43','00:00','00:00',0,0,0,NULL,NULL),(86,75,5,1,1,'01:95','00:00','00:00',0,0,0,NULL,NULL),(87,76,5,2,1,'02:42','00:00','00:00',0,0,0,NULL,NULL),(88,77,5,2,1,'03:01','00:00','00:00',0,0,0,NULL,NULL),(89,78,5,2,1,'01:82','00:00','00:00',0,0,0,NULL,NULL),(90,79,5,2,1,'02:71','00:00','00:00',0,0,0,NULL,NULL),(91,80,5,2,1,'02:59','00:00','00:00',0,0,0,NULL,NULL),(92,81,5,2,1,'03:63','00:00','00:00',0,0,0,NULL,NULL),(93,82,5,2,1,'02:04','00:00','00:00',0,0,0,NULL,NULL),(94,83,5,2,1,'02:11','00:00','00:00',0,0,0,NULL,NULL),(95,84,5,2,1,'02:75','00:00','00:00',0,0,0,NULL,NULL),(96,85,5,2,1,'03:79','00:00','00:00',0,0,0,NULL,NULL),(97,86,5,2,1,'14:10','00:00','00:00',0,0,0,NULL,NULL),(98,87,5,2,1,'02:30','00:00','00:00',0,0,0,NULL,NULL),(99,88,5,2,1,'02:93','00:00','00:00',0,0,0,NULL,NULL),(100,89,5,3,1,'04:24','00:00','00:00',0,0,0,NULL,NULL),(101,90,5,3,1,'02:65','00:00','00:00',0,0,0,NULL,NULL),(102,91,5,3,1,'03:28','00:00','00:00',0,0,0,NULL,NULL),(103,92,5,3,1,'03:22','00:00','00:00',0,0,0,NULL,NULL),(104,93,5,3,1,'01:83','00:00','00:00',0,0,0,NULL,NULL),(105,94,5,3,1,'01:71','00:00','00:00',0,0,0,NULL,NULL),(106,95,5,3,1,'06:60','00:00','00:00',0,0,0,NULL,NULL),(107,96,5,3,1,'03:53','00:00','00:00',0,0,0,NULL,NULL),(108,97,5,3,1,'03:78','00:00','00:00',0,0,0,NULL,NULL),(109,98,5,3,1,'04:37','00:00','00:00',1,0,0,NULL,NULL),(110,99,5,3,1,'02:68','00:00','00:00',0,0,0,NULL,NULL),(111,100,5,3,1,'01:58','00:00','00:00',0,0,0,NULL,NULL),(156,49,4,3,2,'00:00','00:00','00:00',0,0,0,NULL,NULL),(157,62,4,3,2,'00:00','00:00','00:00',0,0,0,NULL,NULL),(158,61,4,3,2,'00:00','00:00','00:00',0,0,0,NULL,NULL),(159,60,4,3,2,'00:00','00:00','00:00',0,0,0,NULL,NULL),(160,59,4,3,2,'00:00','00:00','00:00',0,0,0,NULL,NULL),(161,58,4,3,2,'00:00','00:00','00:00',0,0,0,NULL,NULL),(162,57,4,3,2,'00:00','00:00','00:00',0,0,0,NULL,NULL),(163,56,4,3,2,'00:00','00:00','00:00',0,0,0,NULL,NULL),(164,55,4,3,2,'00:00','00:00','00:00',0,0,0,NULL,NULL),(165,19,4,1,2,'00:00','00:00','00:00',0,0,0,NULL,NULL),(166,31,4,1,2,'00:00','00:00','00:00',0,0,0,NULL,NULL),(167,30,4,1,2,'00:00','00:00','00:00',0,0,0,NULL,NULL),(168,29,4,1,2,'00:00','00:00','00:00',0,0,0,NULL,NULL),(169,28,4,1,2,'00:00','00:00','00:00',0,0,0,NULL,NULL),(170,27,4,1,2,'00:00','00:00','00:00',0,0,0,NULL,NULL),(171,26,4,1,2,'00:00','00:00','00:00',0,0,0,NULL,NULL),(172,25,4,1,2,'00:00','00:00','00:00',0,0,0,NULL,NULL),(173,66,5,1,2,'03:91','00:00','00:00',0,0,0,NULL,NULL),(174,69,5,1,2,'02:49','00:00','00:00',0,0,0,NULL,NULL),(175,74,5,1,2,'03:25','00:00','00:00',0,0,0,NULL,NULL),(176,72,5,1,2,'04:76','00:00','00:00',0,0,0,NULL,NULL),(177,64,5,1,2,'03:53','00:00','00:00',0,0,0,NULL,NULL),(178,65,5,1,2,'03:10','00:00','00:00',0,0,0,NULL,NULL),(179,68,5,1,2,'03:99','00:00','00:00',0,0,0,NULL,NULL),(180,71,5,1,2,'08:85','00:00','00:00',0,0,0,NULL,NULL),(181,67,5,1,2,'04:01','00:00','00:00',0,0,0,NULL,NULL),(182,78,5,2,2,'04:05','00:00','00:00',0,0,0,NULL,NULL),(183,76,5,2,2,'03:66','00:00','00:00',0,0,0,NULL,NULL),(184,87,5,2,2,'01:79','00:00','00:00',0,0,0,NULL,NULL),(185,84,5,2,2,'03:36','00:00','00:00',0,0,0,NULL,NULL),(186,83,5,2,2,'01:85','00:00','00:00',0,0,0,NULL,NULL),(187,82,5,2,2,'03:88','00:00','00:00',0,0,0,NULL,NULL),(188,80,5,2,2,'04:71','00:00','00:00',0,0,0,NULL,NULL),(189,79,5,2,2,'03:48','00:00','00:00',0,0,0,NULL,NULL),(190,88,5,2,2,'08:10','00:00','00:00',0,0,0,NULL,NULL),(191,77,5,2,2,'01:88','00:00','00:00',0,0,0,NULL,NULL),(192,100,5,3,2,'02:53','00:85','00:00',0,0,0,NULL,NULL),(193,93,5,3,2,'01:87','01:97','00:00',0,0,0,NULL,NULL),(194,94,5,3,2,'01:84','01:52','00:00',0,0,0,NULL,NULL),(195,90,5,3,2,'03:92','03:95','00:00',0,0,0,NULL,NULL),(196,99,5,3,2,'04:80','01:81','00:00',0,0,0,NULL,NULL),(197,91,5,3,2,'04:07','01:98','00:00',0,0,0,NULL,NULL),(198,96,5,3,2,'05:65','02:07','00:00',0,0,0,NULL,NULL),(199,97,5,3,2,'06:97','02:61','00:00',0,0,0,NULL,NULL),(200,89,5,3,2,'07:07','01:35','00:00',0,0,0,NULL,NULL),(201,95,5,3,2,'02:23','00:92','00:00',0,0,0,NULL,NULL),(202,69,5,1,3,'04:57','00:00','00:00',0,0,0,NULL,NULL),(203,74,5,1,3,'07:18','00:00','00:00',0,0,0,NULL,NULL),(204,64,5,1,3,'16:08','00:00','00:00',0,0,0,NULL,NULL),(205,68,5,1,3,'04:26','00:00','00:00',0,0,0,NULL,NULL),(206,67,5,1,3,'08:35','00:00','00:00',0,0,0,NULL,NULL),(207,77,5,2,3,'03:44','00:00','00:00',0,0,0,NULL,NULL),(208,87,5,2,3,'12:44','00:00','00:00',0,0,0,NULL,NULL),(209,83,5,2,3,'03:14','00:00','00:00',0,0,0,NULL,NULL),(210,82,5,2,3,'03:85','00:00','00:00',0,0,0,NULL,NULL),(211,78,5,2,3,'06:55','00:00','00:00',0,0,0,NULL,NULL),(212,93,5,3,3,'02:99','00:30','00:00',0,0,0,NULL,NULL),(213,94,5,3,3,'03:87','01:81','00:00',0,0,0,NULL,NULL),(214,100,5,3,3,'03:93','01:40','00:00',0,0,0,NULL,NULL),(215,99,5,3,3,'00:00','00:00','00:00',0,1,0,NULL,NULL),(216,91,5,3,3,'07:43','02:96','00:00',0,0,0,NULL,NULL),(217,69,5,1,4,'00:00','00:00','00:00',0,0,0,NULL,NULL),(218,68,5,1,4,'00:00','00:00','00:00',0,0,0,NULL,NULL),(219,67,5,1,4,'00:00','00:00','00:00',0,0,0,NULL,NULL),(220,77,5,2,4,'00:00','00:00','00:00',0,0,0,NULL,NULL),(221,83,5,2,4,'00:00','00:00','00:00',0,0,0,NULL,NULL),(222,82,5,2,4,'00:00','00:00','00:00',0,0,0,NULL,NULL),(223,93,5,3,4,'00:00','00:00','00:00',0,0,0,NULL,NULL),(224,94,5,3,4,'00:00','00:00','00:00',0,0,0,NULL,NULL),(225,91,5,3,4,'00:00','00:00','00:00',0,0,0,NULL,NULL);
/*!40000 ALTER TABLE `participantes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `performance`
--

DROP TABLE IF EXISTS `performance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `performance` (
  `id_performance` int NOT NULL AUTO_INCREMENT,
  `id_participante` int DEFAULT NULL,
  `nivel` int DEFAULT NULL,
  `instancia` int DEFAULT NULL,
  `tiempo_deletreo` time DEFAULT NULL,
  `penalizacion_deletreo` int DEFAULT NULL,
  `tiempo_oracion` time DEFAULT NULL,
  `penalizacion_oracion` int DEFAULT NULL,
  `fallo` tinyint(1) DEFAULT NULL,
  `audio_deletreo` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `audio_oracion` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_evento` int NOT NULL,
  PRIMARY KEY (`id_performance`),
  KEY `id_participante` (`id_participante`),
  KEY `performance_ibfk_2` (`id_evento`),
  CONSTRAINT `performance_ibfk_1` FOREIGN KEY (`id_participante`) REFERENCES `participantes` (`id_participante`),
  CONSTRAINT `performance_ibfk_2` FOREIGN KEY (`id_evento`) REFERENCES `eventos` (`id_evento`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `performance`
--

LOCK TABLES `performance` WRITE;
/*!40000 ALTER TABLE `performance` DISABLE KEYS */;
INSERT INTO `performance` VALUES (1,1,1,1,'00:02:30',1,'00:01:45',0,0,'audios/juan_deletreo.mp3','audios/juan_oracion.mp3',1),(2,2,1,1,'00:03:15',2,'00:02:05',1,0,'audios/sofia_deletreo.mp3','audios/sofia_oracion.mp3',1),(3,3,2,1,'00:04:10',0,'00:03:55',2,1,'audios/martin_deletreo.mp3','audios/martin_oracion.mp3',1),(4,4,2,1,'00:03:45',1,'00:02:50',0,0,'audios/lucia_deletreo.mp3','audios/lucia_oracion.mp3',1),(5,5,3,1,'00:05:20',2,'00:04:10',1,1,'audios/andres_deletreo.mp3','audios/andres_oracion.mp3',1),(6,6,3,1,'00:05:50',3,'00:04:45',0,0,'audios/camila_deletreo.mp3','audios/camila_oracion.mp3',1),(7,7,1,1,'00:02:55',1,'00:01:50',1,0,'audios/nicolas_deletreo.mp3','audios/nicolas_oracion.mp3',1),(8,8,1,1,'00:03:30',0,'00:02:20',0,0,'audios/valentina_deletreo.mp3','audios/valentina_oracion.mp3',1),(9,9,2,1,'00:04:00',2,'00:03:15',1,1,'audios/lucas_deletreo.mp3','audios/lucas_oracion.mp3',1),(10,10,2,1,'00:04:30',1,'00:03:00',0,0,'audios/maria_deletreo.mp3','audios/maria_oracion.mp3',1),(11,11,3,1,'00:05:15',2,'00:04:05',2,1,'audios/diego_deletreo.mp3','audios/diego_oracion.mp3',1),(12,12,3,1,'00:05:45',1,'00:04:50',1,0,'audios/julieta_deletreo.mp3','audios/julieta_oracion.mp3',1),(13,13,1,1,'00:03:10',0,'00:02:00',0,0,'audios/emiliano_deletreo.mp3','audios/emiliano_oracion.mp3',1),(14,14,1,1,'00:02:45',1,'00:01:55',1,0,'audios/carolina_deletreo.mp3','audios/carolina_oracion.mp3',1),(15,15,2,1,'00:03:55',1,'00:03:05',0,1,'audios/esteban_deletreo.mp3','audios/esteban_oracion.mp3',1);
/*!40000 ALTER TABLE `performance` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `profesores`
--

DROP TABLE IF EXISTS `profesores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `profesores` (
  `id_profesor` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `id_institucion` int DEFAULT NULL,
  PRIMARY KEY (`id_profesor`),
  KEY `id_institucion` (`id_institucion`),
  CONSTRAINT `profesores_ibfk_1` FOREIGN KEY (`id_institucion`) REFERENCES `instituciones` (`id_institucion`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profesores`
--

LOCK TABLES `profesores` WRITE;
/*!40000 ALTER TABLE `profesores` DISABLE KEYS */;
INSERT INTO `profesores` VALUES (1,'María','',1),(2,'Jorge','',2),(3,'Luisa','',3),(4,'Carlos','',4),(5,'Ana','',5),(6,'José','',6),(7,'Laura','',7),(8,'Roberto','',8),(9,'Marta','',9),(10,'Pablo','',10),(11,'Silvia','',11),(12,'Oscar','',12),(13,'Claudia','',13),(14,'Federico','',14),(15,'Natalia','',15),(17,'Alejandro Medina','1Profesor@gmail.com',17),(18,'Daniela Vargas','2Profesor@gmail.com',17),(19,'Pedro Acosta','profesor3@gmail.com',19),(20,'Carla Vega','Profesor4@gmail.com',20),(21,'Andres Ramirez','Profesor5@gmail.com',21),(22,'Natalia Salinas','Profesor6@gmail.com',22),(23,'Ricardo Benitez','Profesor7@gmail.com',23),(24,'Mariela Ferrer','Profesor8@gmail.com',24),(25,'Felipe Araya','Profesor9@gmail.com',25),(26,'Mariana Gebhard','',26),(27,'Etel Itatí Aguirre','',27),(28,'Nicolás Marano','',28),(29,'Maria Belén Romero','',29),(30,'Karina Speranza','',30),(31,'Silvina Lodoli','',30),(32,'Sosa Correa Carla Jimena','',31),(33,'Belén Alejandra Mierez','',32),(34,'Sotelo María Cristina','',33),(35,'Lidia Estela Daniel','',34),(36,'Blanco Cinthia Fabiana','',35),(37,'Carolina Marzoratti','',36),(38,'Ortiz Silvia Anahí','',37),(39,'Vásquez Milagros','',38),(40,'Benítez Milagros','',38);
/*!40000 ALTER TABLE `profesores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `setup`
--

DROP TABLE IF EXISTS `setup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `setup` (
  `id_setup` int NOT NULL AUTO_INCREMENT,
  `id_evento` int DEFAULT NULL,
  `nivel` int DEFAULT NULL,
  `numero_instancia` int DEFAULT NULL,
  `tiempo_maximo` varchar(10) COLLATE utf8mb4_general_ci DEFAULT '60:00',
  `cronometrar_oracion` tinyint(1) DEFAULT NULL,
  `cronometrar_deletreo` tinyint(1) DEFAULT NULL,
  `max_alumnos_instancia` int DEFAULT NULL,
  PRIMARY KEY (`id_setup`),
  KEY `id_evento` (`id_evento`),
  CONSTRAINT `setup_ibfk_1` FOREIGN KEY (`id_evento`) REFERENCES `eventos` (`id_evento`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `setup`
--

LOCK TABLES `setup` WRITE;
/*!40000 ALTER TABLE `setup` DISABLE KEYS */;
INSERT INTO `setup` VALUES (1,1,1,1,'00:05:00',1,1,15),(2,1,1,2,'00:03:00',1,1,10),(3,1,2,1,'00:05:00',1,1,15),(4,1,2,2,'00:04:00',1,1,10),(5,1,3,1,'00:06:00',1,1,15),(6,1,3,2,'00:05:00',1,1,10),(7,4,3,3,'60:00',1,1,15);
/*!40000 ALTER TABLE `setup` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-10-02 19:34:02

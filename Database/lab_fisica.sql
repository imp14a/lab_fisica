-- MySQL dump 10.13  Distrib 5.5.31, for Linux (x86_64)
--
-- Host: localhost    Database: lab_fisica
-- ------------------------------------------------------
-- Server version	5.5.31

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `Activity`
--

DROP TABLE IF EXISTS `Activity`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Activity` (
  `activity_id` int(11) NOT NULL AUTO_INCREMENT,
  `activity_prefix` varchar(20) DEFAULT NULL,
  `title` varchar(180) NOT NULL,
  `description` text,
  `steps` text,
  `observations` text,
  PRIMARY KEY (`activity_id`),
  UNIQUE KEY `activity_prefix` (`activity_prefix`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Activity`
--

LOCK TABLES `Activity` WRITE;
/*!40000 ALTER TABLE `Activity` DISABLE KEYS */;
INSERT INTO `Activity` VALUES (1,'caidalibre','Caida libre','El comportamiento de un péndulo depende principalmente de la longitud de la Cuerda, la Fuerza de Gravedad y la Masa del cuerpo.\r\n\r\nUn péndulo es un sistema físico ideal constituido por un hilo inextensible y de Masa despreciable, sostenido por su extremo superior de un punto Fijo, con una Masa puntual en su extremo inferior que oscila libremente en el vacío. Si el movimiento de la Masa se mantiene en un plano, se dice que es un péndulo plano; en caso contrario, se dice que es un péndulo esférico.\r\nAlgunas aplicaciones del péndulo son la medición del tiempo, el metrónomo y la plomada. Otra aplicación se conoce como Péndulo de Foucault, el cual se emplea para evidenciar la rotación de la Tierra. Se llama así en honor del físico francés León Foucault y está formado por una gran Masa suspendida de un cable muy largo.\r\n \r\nPéndulo plano \r\n\r\nDiagrama de las fuerzas que actúan en un péndulo simple.\r\nAl separar la Masa de su punto de equilibrio, oscila a ambos lados de dicha posición, realizando un movimiento armónico simple. En la posición de uno de los extremos, se produce un equilibrio de fuerzas. Para derivar las ecuaciones pertenecientes a un péndulo gravitacional se deben hacer las siguientes hipótesis:\r\n·	Hilo inextensible y sin peso \r\n·	Movimiento sin rozamiento del aire \r\nLa flecha azul representa la Fuerza debido a la Gravedad actuando Sobre la Masa. Las flechas violetas son la misma Fuerza descompuesta en sus componentes paralelos y perpendiculares al movimiento instantáneo de la Masa. La segunda ley de Newton\r\n\r\nF = ma\r\ndonde F es la Fuerza actuando Sobre la Masa m, haciendo que acelere a metros por segundo cuadrado. Ya que la Masa está obligada a mover en un trazo circular verde, no hay necesidad de considerar ninguna otra Fuerza que la responsable de aceleración instantánea paralelo al movimiento instantánea de la Masa, la flecha violeta corta:\r\n\r\nF =  mgsin (ángulo)= ma\r\nLa Fuerza perpendicular, que mantiene la Masa en estado de equilibrio con la tensión del hilo es\r\nF (perpendicular) = mg cos(ángulo)\r\n\r\nAceleración lineal a por el eje rojo está relacionado con el cambio en el ángulo ? por la fórmula para encontrar la longitud de arco:\r\n\r\nDe donde se deduce que la Velocidad y la aceleración vienen dadas por:\r\n\r\n\r\nEsta aceleración no toma en cuenta que el ángulo ? está disminuyendo. La ecuación de movimiento teniendo en cuenta que la aceleración a tiene que llevar un signo negativo viene dada por:','Modificar la Masa del cuerpo. Para ello, deberá entrar al menú del \"Propiedades iniciales\" y cambiar los valores por:\r\nMasa = 2\r\nMasa = 8\r\nMasa = 20\r\nMasa = 30\r\nSacar sus conclusiones\r\n\r\nTambién puede cambiar la longitud de la Cuerda\r\n\r\nCambiar la Fuerza de Gravedad para observavar el comportamiento del péndulo.\r\nLa Gravedad de la Tierra es de -9.81, \r\nLa Gravedad de la Luna es de -1.62\r\nLa Gravedad de Mercurio es de -2.78\r\nLa Gravedad de Venus es de -8.87\r\nLa Gravedad de Marte es de -3.71\r\nLa Gravedad de Júpiter es de -23.12\r\nLa Gravedad de Urano es de -8.69\r\nLa Gravedad de Neptuno es de -11\r\n\r\nSacar sus conclusiones cuando se hace el experimento en orto planeta','¿Cuál es el impacto de la masa para un  péndulo?\r\n\r\n\r\n¿Qué sucede al aumentar la longitud de la cuerda?\r\n\r\n\r\n¿Es proporcional el efecto en el objeto al aumentar la longitud de la cuerda?\r\n\r\n\r\n¿Qué sucede si le damos un impulso al objeto con coordenadas negativas?\r\n\r\n\r\n¿Cuál es la diferencia entre un objeto en estado estático al cual se le aplica un impulso y uno que está en la posición del péndulo?');
/*!40000 ALTER TABLE `Activity` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `World`
--

DROP TABLE IF EXISTS `World`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `World` (
  `world_id` int(11) NOT NULL AUTO_INCREMENT,
  `activity_id` int(11) DEFAULT NULL,
  `gravity` float DEFAULT NULL,
  `density` float DEFAULT NULL,
  `creation_script` text,
  PRIMARY KEY (`world_id`),
  KEY `activity_id` (`activity_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `World`
--

LOCK TABLES `World` WRITE;
/*!40000 ALTER TABLE `World` DISABLE KEYS */;
/*!40000 ALTER TABLE `World` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `WorldElement`
--

DROP TABLE IF EXISTS `WorldElement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `WorldElement` (
  `world_element_id` int(11) NOT NULL AUTO_INCREMENT,
  `world_id` int(11) DEFAULT NULL,
  `elastisty` float DEFAULT NULL,
  `friction` float DEFAULT NULL,
  `mass` float DEFAULT NULL,
  `color` varchar(30) DEFAULT NULL,
  `velocity_x` float DEFAULT NULL,
  `velocity_y` float DEFAULT NULL,
  `postion_x` float DEFAULT NULL,
  `position_y` float DEFAULT NULL,
  `rotation_x` float DEFAULT NULL,
  `rotation_y` float DEFAULT NULL,
  `momentum_x` float DEFAULT NULL,
  `momentum_y` float DEFAULT NULL,
  `force_x` float DEFAULT NULL,
  `force_y` float DEFAULT NULL,
  `creation_script` text,
  PRIMARY KEY (`world_element_id`),
  KEY `world_id` (`world_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `WorldElement`
--

LOCK TABLES `WorldElement` WRITE;
/*!40000 ALTER TABLE `WorldElement` DISABLE KEYS */;
/*!40000 ALTER TABLE `WorldElement` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-05-31 16:25:26

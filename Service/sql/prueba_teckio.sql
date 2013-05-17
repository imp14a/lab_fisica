-- phpMyAdmin SQL Dump
-- version 3.4.9
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 14-01-2013 a las 17:41:27
-- Versión del servidor: 5.5.19
-- Versión de PHP: 5.3.15

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `prueba_teckio`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ARTICULO`
--

CREATE TABLE IF NOT EXISTS `ARTICULO` (
  `articulo_id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(120) NOT NULL,
  `texto` text NOT NULL,
  `autor` varchar(120) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`articulo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ARTICULO_CATEGORIA`
--

CREATE TABLE IF NOT EXISTS `ARTICULO_CATEGORIA` (
  `id_articulo` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  KEY `id_articulo` (`id_articulo`),
  KEY `id_categoria` (`id_categoria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `CATEGORIA`
--

CREATE TABLE IF NOT EXISTS `CATEGORIA` (
  `categoria_id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_categoria` varchar(80) NOT NULL,
  PRIMARY KEY (`categoria_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `CATEGORIA`
--

INSERT INTO `CATEGORIA` (`categoria_id`, `nombre_categoria`) VALUES
(1, 'Default');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `COMENTARIO`
--

CREATE TABLE IF NOT EXISTS `COMENTARIO` (
  `comentario_id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(120) NOT NULL,
  `texto` text NOT NULL,
  `autor` varchar(120) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `articulo_id` int(11) NOT NULL,
  PRIMARY KEY (`comentario_id`),
  KEY `articulo_id` (`articulo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `ARTICULO_CATEGORIA`
--
ALTER TABLE `ARTICULO_CATEGORIA`
  ADD CONSTRAINT `articulo_categoria_ibfk_2` FOREIGN KEY (`id_categoria`) REFERENCES `CATEGORIA` (`categoria_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `articulo_categoria_ibfk_1` FOREIGN KEY (`id_articulo`) REFERENCES `ARTICULO` (`articulo_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `COMENTARIO`
--
ALTER TABLE `COMENTARIO`
  ADD CONSTRAINT `comentario_ibfk_1` FOREIGN KEY (`articulo_id`) REFERENCES `ARTICULO` (`articulo_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

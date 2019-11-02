-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 31-07-2019 a las 19:20:23
-- Versión del servidor: 10.3.16-MariaDB
-- Versión de PHP: 7.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `personas2`
--
CREATE DATABASE IF NOT EXISTS `personas2` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `personas2`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuentas`
--

DROP TABLE IF EXISTS `cuentas`;
CREATE TABLE `cuentas` (
  `idcuentas` int(11) NOT NULL,
  `entidad` char(4) NOT NULL,
  `oficina` char(4) NOT NULL,
  `dc` char(2) NOT NULL,
  `numcuenta` char(10) NOT NULL,
  `saldo` decimal(11,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='cuentas';

--
-- Volcado de datos para la tabla `cuentas`
--

INSERT INTO `cuentas` (`idcuentas`, `entidad`, `oficina`, `dc`, `numcuenta`, `saldo`) VALUES
(6, '2100', '8888', '33', '4009925560', '206.00'),
(11, '2100', '8888', '33', '4009963931', '4000.00'),
(12, '2100', '1455', '33', '4009984433', '400.00'),
(13, '2100', '5555', '11', '4009923314', '990.00'),
(15, '2100', '5555', '11', '4009989912', '3000.00'),
(16, '2100', '5555', '11', '4009972450', '3001.00'),
(20, '2200', '1234', '56', '4009958797', '7996.00'),
(22, '2200', '1234', '56', '4009948336', '229.00'),
(23, '2200', '1234', '56', '4009905112', '2345.00'),
(25, '2200', '1234', '56', '4009953541', '338.00'),
(26, '9669', '8999', '10', '4009995640', '100000000.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personas`
--

DROP TABLE IF EXISTS `personas`;
CREATE TABLE `personas` (
  `pk_personas` int(11) NOT NULL COMMENT 'pk personas',
  `nif` char(9) NOT NULL COMMENT 'NIF',
  `nombre` varchar(100) NOT NULL COMMENT 'Nombre',
  `apellidos` varchar(150) NOT NULL COMMENT 'Apellidos',
  `direccion` varchar(200) DEFAULT NULL COMMENT 'dirección',
  `telefono` varchar(15) DEFAULT NULL COMMENT 'telefono',
  `email` varchar(100) DEFAULT NULL COMMENT 'Email'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `personas`
--

INSERT INTO `personas` (`pk_personas`, `nif`, `nombre`, `apellidos`, `direccion`, `telefono`, `email`) VALUES
(1, '38424012M', 'juan carlos ', 'moreno', 'carrer pere sala, 97----', '6218163381', 'jucamova@gmail.com'),
(2, '63503122F', 'ramonet', 'quintero,33', 'c. atras,22', '1234567890', 'quintero@gmail.com'),
(4, '43113054Z', 'esperanza', 'aguirre', 'sucasa, 99', '', ''),
(8, '47475261H', 'donald', 'trump', 'casablanca,s/n', '9969696969', 'donald@trump.com'),
(9, '49574089G', 'ana', 'miralles', 'c.alba,18', '633000555', 'miralles@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personascuentas`
--

DROP TABLE IF EXISTS `personascuentas`;
CREATE TABLE `personascuentas` (
  `pk_personas` int(11) NOT NULL,
  `idcuentas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `personascuentas`
--

INSERT INTO `personascuentas` (`pk_personas`, `idcuentas`) VALUES
(1, 20),
(1, 22),
(1, 23),
(1, 25),
(2, 6),
(2, 11),
(2, 12),
(4, 13),
(4, 15),
(4, 16),
(8, 26);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cuentas`
--
ALTER TABLE `cuentas`
  ADD PRIMARY KEY (`idcuentas`) USING BTREE,
  ADD UNIQUE KEY `ccc` (`entidad`,`oficina`,`dc`,`numcuenta`);

--
-- Indices de la tabla `personas`
--
ALTER TABLE `personas`
  ADD PRIMARY KEY (`pk_personas`) USING BTREE,
  ADD UNIQUE KEY `nif` (`nif`);

--
-- Indices de la tabla `personascuentas`
--
ALTER TABLE `personascuentas`
  ADD PRIMARY KEY (`pk_personas`,`idcuentas`) USING BTREE,
  ADD KEY `idcuentas` (`idcuentas`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cuentas`
--
ALTER TABLE `cuentas`
  MODIFY `idcuentas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `personas`
--
ALTER TABLE `personas`
  MODIFY `pk_personas` int(11) NOT NULL AUTO_INCREMENT COMMENT 'pk personas', AUTO_INCREMENT=10;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `personascuentas`
--
ALTER TABLE `personascuentas`
  ADD CONSTRAINT `personascuentas_ibfk_1` FOREIGN KEY (`pk_personas`) REFERENCES `personas` (`pk_personas`),
  ADD CONSTRAINT `personascuentas_ibfk_2` FOREIGN KEY (`idcuentas`) REFERENCES `cuentas` (`idcuentas`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

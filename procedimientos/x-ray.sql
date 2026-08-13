-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 31-05-2025 a las 01:53:43
-- Versión del servidor: 10.4.25-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `x-ray`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `Id_categoria` int(10) NOT NULL,
  `Nombre_categoria` varchar(50) NOT NULL,
  `Descripcion_categoria` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `Id_cliente` int(10) NOT NULL,
  `Nombre` varchar(50) NOT NULL,
  `Direccion` varchar(100) NOT NULL,
  `Razon_social` varchar(50) NOT NULL,
  `NIT` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Celular` varchar(10) NOT NULL,
  `Id_empleado` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `diagnostico`
--

CREATE TABLE `diagnostico` (
  `Id_diagnostico` int(10) NOT NULL,
  `Descripcion` varchar(50) NOT NULL,
  `Nivel_gravedad` varchar(50) NOT NULL,
  `Porcentaje_confianza_IA` varchar(50) NOT NULL,
  `Tipo_Fractura_IA` varchar(50) NOT NULL,
  `Fecha_hora` varchar(20) NOT NULL,
  `Id_radiografia` varchar(10) NOT NULL,
  `Id_patologia` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado`
--

CREATE TABLE `empleado` (
  `Cedula` int(50) NOT NULL,
  `Nombre` varchar(20) NOT NULL,
  `Apellido` varchar(20) NOT NULL,
  `Direccion` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Celular` varchar(10) NOT NULL,
  `Especialidad` varchar(50) DEFAULT NULL,
  `Contraseña` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paciente`
--

CREATE TABLE `paciente` (
  `Id_paciente` int(50) NOT NULL,
  `Nombres` varchar(50) NOT NULL,
  `Apellidos` varchar(50) NOT NULL,
  `Direccion` varchar(100) NOT NULL,
  `Fecha_nacimiento` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Celular` varchar(10) NOT NULL,
  `Genero` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `patologia`
--

CREATE TABLE `patologia` (
  `Id_patologia` int(10) NOT NULL,
  `Nombre_patologia` varchar(50) NOT NULL,
  `Tipo_patologia` varchar(50) NOT NULL,
  `Descripcion_patologia` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `radiografia`
--

CREATE TABLE `radiografia` (
  `Id_radiografia` int(10) NOT NULL,
  `Fecha_hora` varchar(20) NOT NULL,
  `Archivo_radiografia` varchar(100) NOT NULL,
  `Id_zona` int(10) NOT NULL,
  `Id_categoria` int(10) NOT NULL,
  `Id_empleado` int(10) NOT NULL,
  `Id_paciente` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `zona`
--

CREATE TABLE `zona` (
  `Id_zona` int(10) NOT NULL,
  `Nombre_zona` varchar(50) NOT NULL,
  `Descripcion_zona` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`Id_categoria`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`Id_cliente`);

--
-- Indices de la tabla `diagnostico`
--
ALTER TABLE `diagnostico`
  ADD PRIMARY KEY (`Id_diagnostico`);

--
-- Indices de la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD PRIMARY KEY (`Cedula`);

--
-- Indices de la tabla `paciente`
--
ALTER TABLE `paciente`
  ADD PRIMARY KEY (`Id_paciente`);

--
-- Indices de la tabla `patologia`
--
ALTER TABLE `patologia`
  ADD PRIMARY KEY (`Id_patologia`);

--
-- Indices de la tabla `radiografia`
--
ALTER TABLE `radiografia`
  ADD PRIMARY KEY (`Id_radiografia`);

--
-- Indices de la tabla `zona`
--
ALTER TABLE `zona`
  ADD PRIMARY KEY (`Id_zona`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

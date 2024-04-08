-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-03-2024 a las 22:38:17
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `2melody`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--
DROP TABLE IF EXISTS `usuario`;
CREATE TABLE `usuario` (
  `id_user` varchar(63) NOT NULL,
  `nickname` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `descripcion` tinytext DEFAULT NULL,
  `karma` int(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `correo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Estructura de tabla para la tabla `ajustes`
--
DROP TABLE IF EXISTS `ajustes`;
CREATE TABLE `ajustes` (
  `id_user` varchar(63) NOT NULL,
  `fuente` varchar(255) DEFAULT NULL,
  `fontSize` int(11) DEFAULT NULL,
  `temas` varchar(255) DEFAULT NULL,
  `paginaPrincipal` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `artista`
--
DROP TABLE IF EXISTS `artista`;
CREATE TABLE `artista` (
  `id_artista` varchar(63) NOT NULL,
  `integrantes` tinytext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


--
-- Estructura de tabla para la tabla `evento`
--
DROP TABLE IF EXISTS `evento`;
CREATE TABLE `evento` (
  `id_evento` int(11) NOT NULL,
  `id_artista` varchar(63) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `descripcion` tinytext DEFAULT NULL,
  `fecha` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `evento_prod`;
CREATE TABLE `evento_prod` (
  `id_evento` int(11) NOT NULL,
  `id_prod` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `post`
--
DROP TABLE IF EXISTS `post`;

CREATE TABLE `post` (
  `id_post` int(11) NOT NULL,
  `id_user` varchar(63) NOT NULL,
  `texto` text DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `likes` int(11) DEFAULT NULL,
  `origen` int(11) DEFAULT NULL,
  `tags` text DEFAULT NULL,
  `fecha` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `postfav`
--
DROP TABLE IF EXISTS `postfav`;
CREATE TABLE `postfav` (
  `id_post` int(11) NOT NULL,
  `id_user` varchar(63) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------


DROP TABLE IF EXISTS `seguidores`;
CREATE TABLE `seguidores` (
  `id_user` varchar(63) NOT NULL,
  `id_seguidor` varchar(63) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos y productos`
--

DROP TABLE IF EXISTS `pedido`;
CREATE TABLE `pedido` (
  `id_pedido` int(11) NOT NULL,
  `id_user` varchar(63) NOT NULL,
  `estado` varchar(255) DEFAULT NULL,
  `total` float DEFAULT NULL,
  `fecha` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `producto`;
CREATE TABLE `producto` (
  `id_prod` int(11) NOT NULL,
  `id_artista` varchar(63) NOT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `descripcion` tinytext DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `precio` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `pedido_prod`;
CREATE TABLE `pedido_prod` (
  `id_pedido` int(11) NOT NULL,
  `id_prod` int(11) NOT NULL,
  `cantidad` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `ajustes`
--
ALTER TABLE `ajustes`
  ADD PRIMARY KEY (`id_user`);

--
-- Indices de la tabla `artista`
--
ALTER TABLE `artista`
  ADD PRIMARY KEY (`id_artista`);
--
-- Indices de la tabla `evento`
--
ALTER TABLE `evento`
  ADD PRIMARY KEY (`id_evento`),
  MODIFY `id_evento` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `evento_prod`
  ADD PRIMARY KEY (`id_evento`,`id_prod`),
  ADD KEY `id_prod` (`id_prod`),
  ADD KEY `id_evento` (`id_evento`);

--
-- Indices de la tabla `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id_post`),
  ADD KEY `id_user` (`id_user`);

--
-- Indices de la tabla `postfav`
--
ALTER TABLE `postfav`
  ADD PRIMARY KEY (`id_user`,`id_post`),
  ADD KEY `id_post` (`id_post`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `correo` (`correo`);


ALTER TABLE `producto`
  ADD PRIMARY KEY (`id_prod`),
  ADD KEY `id_artista` (`id_artista`);

ALTER TABLE `producto`
  MODIFY `id_prod` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `pedido_prod`
  ADD PRIMARY KEY (`id_pedido`,`id_prod`),
  ADD KEY `id_prod` (`id_prod`),
  ADD KEY `id_pedido` (`id_pedido`);


ALTER TABLE `pedido`
  ADD PRIMARY KEY (`id_pedido`),
  ADD KEY `id_user` (`id_user`);

ALTER TABLE `pedido`
  MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `seguidores`
  ADD PRIMARY KEY (`id_user`,`id_seguidor`),
  ADD KEY `id_seguidor` (`id_seguidor`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `post`
--
ALTER TABLE `post`
  MODIFY `id_post` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `ajustes`
--
ALTER TABLE `ajustes`
  ADD CONSTRAINT `ajustes_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `usuario` (`id_user`) ON DELETE CASCADE;

--
-- Filtros para la tabla `artista`
--
ALTER TABLE `artista`
  ADD CONSTRAINT `artista_ibfk_1` FOREIGN KEY (`id_artista`) REFERENCES `usuario` (`id_user`) ON DELETE CASCADE;

--
-- Filtros para la tabla `evento`
--
ALTER TABLE `evento`
  ADD CONSTRAINT `evento_ibfk_1` FOREIGN KEY (`id_artista`) REFERENCES `artista` (`id_artista`) ON DELETE CASCADE;

ALTER TABLE `evento_prod`
  ADD CONSTRAINT `evento_prod_ibfk_1` FOREIGN KEY (`id_evento`) REFERENCES `evento` (`id_evento`) ON DELETE CASCADE,
  ADD CONSTRAINT `evento_prod_ibfk_2` FOREIGN KEY (`id_prod`) REFERENCES `producto` (`id_prod`) ON DELETE CASCADE;

--
-- Filtros para la tabla `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `usuario` (`id_user`) ON DELETE CASCADE;

ALTER TABLE `pedido`
  ADD CONSTRAINT `pedido_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `usuario` (`id_user`) ON DELETE CASCADE;

ALTER TABLE `producto`
  ADD CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`id_artista`) REFERENCES `artista` (`id_artista`) ON DELETE CASCADE;

ALTER TABLE `pedido_prod`
  ADD CONSTRAINT `pedido_prod_ibfk_1` FOREIGN KEY (`id_pedido`) REFERENCES `pedido` (`id_pedido`) ON DELETE CASCADE,
  ADD CONSTRAINT `pedido_prod_ibfk_2` FOREIGN KEY (`id_prod`) REFERENCES `producto` (`id_prod`) ON DELETE CASCADE;

ALTER TABLE `seguidores`
  ADD CONSTRAINT `seguidores_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `usuario` (`id_user`) ON DELETE CASCADE,
  ADD CONSTRAINT `seguidores_ibfk_2` FOREIGN KEY (`id_seguidor`) REFERENCES `usuario` (`id_user`) ON DELETE CASCADE;

--
-- Filtros para la tabla `postfav`
--
ALTER TABLE `postfav`
  ADD CONSTRAINT `postfav_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `usuario` (`id_user`) ON DELETE CASCADE,
  ADD CONSTRAINT `postfav_ibfk_2` FOREIGN KEY (`id_post`) REFERENCES `post` (`id_post`) ON DELETE CASCADE;



SET FOREIGN_KEY_CHECKS=0;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

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
  `correo` varchar(255) NOT NULL,
  `admin` int(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Estructura de tabla para la tabla `artista`
--
DROP TABLE IF EXISTS `artista`;
CREATE TABLE `artista` (
  `id_artista` varchar(63) NOT NULL,
  `archivado` int(1) DEFAULT 0
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

DROP TABLE IF EXISTS `producto_post`;
CREATE TABLE `producto_post` (
  `id_prod` int(11) NOT NULL,
  `id_post` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


--
-- Estructura de tabla para la tabla `cancion y playlist`
--

DROP TABLE IF EXISTS `cancion`;
CREATE TABLE `cancion` (
  `id_cancion` int(11) NOT NULL,
  `titulo` varchar(255) DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `id_artista` varchar(63) DEFAULT NULL,
  `likes` int(11) DEFAULT NULL,
  `ruta` varchar(255) DEFAULT NULL,
  `tags` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `cancion_post`;
CREATE TABLE `cancion_post` (
  `id_cancion` int(11) NOT NULL,
  `id_post` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `postfav`
--
DROP TABLE IF EXISTS `cancionfav`;
CREATE TABLE `cancionfav` (
  `id_cancion` int(11) NOT NULL,
  `id_user` varchar(63) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------


DROP TABLE IF EXISTS `playlist`;
CREATE TABLE `playlist` (
  `id_playlist` int(11) NOT NULL,
  `id_user` varchar(63) DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `fecha` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `play_cancion`;
CREATE TABLE `play_cancion` (
  `id_playlist` int(11) NOT NULL,
  `id_cancion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


--
-- Estructura de tabla para la tabla `suscripciones`
--

DROP TABLE IF EXISTS `suscripcion`;
CREATE TABLE `suscripcion` (
  `id_user` varchar(63) NOT NULL,
  `tipo` varchar(63) DEFAULT NULL,
  `fecha_fin` datetime NOT NULL,
  `archivado` tinytext DEFAULT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


--
-- Índices para tablas volcadas
--

--

--
-- Indices de la tabla `artista`
--
ALTER TABLE `artista`
  ADD PRIMARY KEY (`id_artista`);
--

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


ALTER TABLE `cancion`
  ADD PRIMARY KEY (`id_cancion`),
  ADD KEY `id_artista` (`id_artista`);

ALTER TABLE `cancion_post` 
  ADD PRIMARY KEY (`id_cancion`,`id_post`),
  ADD KEY `id_post` (`id_post`),
  ADD KEY `id_cancion` (`id_cancion`);

ALTER TABLE `producto_post`
  ADD PRIMARY KEY (`id_prod`,`id_post`),
  ADD KEY `id_post` (`id_post`),
  ADD KEY `id_prod` (`id_prod`);

ALTER TABLE `playlist`
  ADD PRIMARY KEY (`id_playlist`),
  ADD KEY `id_user` (`id_user`);

ALTER TABLE `play_cancion`
  ADD PRIMARY KEY (`id_playlist`,`id_cancion`),
  ADD KEY `id_playlist` (`id_playlist`),
  ADD KEY `id_cancion` (`id_cancion`);

ALTER TABLE `suscripcion`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `id_user` (`id_user`);
;

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `post`
--
ALTER TABLE `post`
  MODIFY `id_post` int(11) NOT NULL AUTO_INCREMENT;


  ALTER TABLE `cancion`
  MODIFY `id_cancion` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `playlist`
  MODIFY `id_playlist` int(11) NOT NULL AUTO_INCREMENT;


--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `artista`
--
ALTER TABLE `artista`
  ADD CONSTRAINT `artista_ibfk_1` FOREIGN KEY (`id_artista`) REFERENCES `usuario` (`id_user`);

--
-- Filtros para la tabla `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `usuario` (`id_user`) ON DELETE CASCADE,
  ADD CONSTRAINT `post_ibfk_2` FOREIGN KEY (`origen`) REFERENCES `post` (`id_post`) ON DELETE CASCADE;

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

--
-- Filtros para la tabla `cancion y playlist`
--
  ALTER TABLE `cancion`
  ADD CONSTRAINT `cancion_ibfk_1` FOREIGN KEY (`id_artista`) REFERENCES `artista` (`id_artista`) ON DELETE CASCADE;

ALTER TABLE `cancion_post`
  ADD CONSTRAINT `cancion_post_ibfk_1` FOREIGN KEY (`id_cancion`) REFERENCES `cancion` (`id_cancion`) ON DELETE CASCADE,
  ADD CONSTRAINT `cancion_post_ibfk_2` FOREIGN KEY (`id_post`) REFERENCES `post` (`id_post`) ON DELETE CASCADE;

ALTER TABLE `producto_post`
  ADD CONSTRAINT `producto_post_ibfk_1` FOREIGN KEY (`id_prod`) REFERENCES `producto` (`id_prod`) ON DELETE CASCADE,
  ADD CONSTRAINT `producto_post_ibfk_2` FOREIGN KEY (`id_post`) REFERENCES `post` (`id_post`) ON DELETE CASCADE;

  ALTER TABLE `cancionfav`
  ADD CONSTRAINT `cancionfav_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `usuario` (`id_user`) ON DELETE CASCADE,
  ADD CONSTRAINT `cancionfav_ibfk_2` FOREIGN KEY (`id_cancion`) REFERENCES `cancion` (`id_cancion`) ON DELETE CASCADE;



ALTER TABLE `playlist`
  ADD CONSTRAINT `playlist_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `usuario` (`id_user`) ON DELETE CASCADE;

ALTER TABLE `play_cancion`
  ADD CONSTRAINT `play_cancion_ibfk_1` FOREIGN KEY (`id_playlist`) REFERENCES `playlist` (`id_playlist`)  ON DELETE CASCADE,
  ADD CONSTRAINT `play_cancion_ibfk_2` FOREIGN KEY (`id_cancion`) REFERENCES `cancion` (`id_cancion`) ON DELETE CASCADE;

--
-- Filtros para la tabla `suscripcion`
--
ALTER TABLE `suscripcion`
  ADD CONSTRAINT `suscripcion_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `usuario` (`id_user`);

SET FOREIGN_KEY_CHECKS=1;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

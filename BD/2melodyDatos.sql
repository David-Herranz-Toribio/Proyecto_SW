-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-03-2024 a las 22:38:01
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

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_user`, `nickname`, `password`, `foto`, `descripcion`, `karma`, `fecha`, `correo`) VALUES
('user1', 'User Uno', '$2y$10$O3c1kBFa2yDK5F47IUqusOJmIANjHP6EiPyke5dD18ldJEow.e0eS', 'Perfil2.jpg', '¡Hola! Soy User Uno.', 100, '2001-03-09', 'user1@gmail.com'),
('user2', 'User Dos', '$2y$10$O3c1kBFa2yDK5F47IUqusOJmIANjHP6EiPyke5dD18ldJEow.e0eS', 'Perfil1.jpg', 'Bienvenido a mi perfil.', 80, '2003-03-09', 'user2@gmail.com'),
('user3', 'User Tres', '$2y$10$O3c1kBFa2yDK5F47IUqusOJmIANjHP6EiPyke5dD18ldJEow.e0eS', NULL, 'Descubre mi mundo.', 120, '2000-03-09', 'user3@gmail.com'),
('user4', 'User Cuatro', '$2y$10$O3c1kBFa2yDK5F47IUqusOJmIANjHP6EiPyke5dD18ldJEow.e0eS', 'Perfil2.jpg', '¡Hola! Soy User Cuatro.', 90, '2002-03-09', 'user4@gmail.com'),
('user5', 'User Cinco', '$2y$10$O3c1kBFa2yDK5F47IUqusOJmIANjHP6EiPyke5dD18ldJEow.e0eS', 'Perfil1.jpg', '¡Hola! Soy User Cinco.', 110, '2004-03-09', 'user5@gmail.com'),
('user6', 'User Seis', '$2y$10$O3c1kBFa2yDK5F47IUqusOJmIANjHP6EiPyke5dD18ldJEow.e0eS', NULL, '¡Hola! Soy User Seis.', 70, '2005-03-09', 'user6@gmail.com');


--
-- Volcado de datos para la tabla `ajustes`
--


TRUNCATE TABLE `ajustes`;
INSERT INTO `ajustes` ( `id_user`, `fuente`, `fontSize`, `temas`, `paginaPrincipal`) VALUES
('user1', 'Arial', 12, 'Claro', 'Inicio'),
('user2', 'Times New Roman', 14, 'Oscuro', 'Foro.php'),
('user3', 'Verdana', 16, 'Neón', 'Merch.php');
--
-- Volcado de datos para la tabla `artista`
--
TRUNCATE TABLE `artista`;
INSERT INTO `artista` (`id_artista`, `integrantes`) VALUES
('user2', 'John Doe, Jane Smith');


TRUNCATE TABLE `seguidores`;

-- Ejemplo de inserción de datos en la tabla seguidores
INSERT INTO `seguidores` (`id_user`, `id_seguidor`) VALUES
('user1', 'user2'),
('user2', 'user3'),
('user3', 'user1');


--
-- Volcado de datos para la tabla `producto`
--

TRUNCATE TABLE `producto`;
INSERT INTO `producto` (`id_artista`, `imagen`, `nombre`, `descripcion`, `stock`, `precio`) VALUES
('user2', 'FotoEntrada.png', 'Entrada Artista 1', 'Entrada para John Doe y Jane Smith', 150, 10.99),
('user2', 'FotoMerch.png', 'Camiseta Artista 1', 'Camiseta con diseño exclusivo del artista 1', 50, 20.99),
('user2', 'FotoMerch.png', 'Póster Firmado', 'Póster firmado por el artista 2', 30, 15.5),
('user2', 'FotoMerch.png', 'Álbum en Vinilo', 'Edición especial en vinilo del álbum del artista 3', 10, 35.75),
('user2', 'FotoMerch.png', 'Camiseta Artista 1', 'Camiseta con diseño exclusivo del artista 2', 50, 20.99),
('user2', 'FotoMerch.png', 'Taza de Colección', 'Taza de colección con el arte del usuario 2', 0, 8.5),
('user2', 'FotoMerch.png', 'Póster Artista 1', 'Póster con ilustraciones del artista 1', 40, 12.75),
('user2', 'FotoMerch.png', 'Edición Limitada en Vinilo', 'Edición limitada en vinilo de las canciones del artista 2', 10, 45.99);

--
-- Volcado de datos para la tabla `pedido`
--

TRUNCATE TABLE `pedido`;
INSERT INTO `pedido` (`id_user`, `estado`, `total`, `fecha`)VALUES
('user1', 'En proceso', 50, '2024-03-08'),
('user1', 'Entregado', 75.5, '2024-03-09'),
('user1', 'Pendiente', 30.2, '2024-03-10'),
('user1', 'Entregado', 62.25, '2024-03-11');
--
-- Volcado de datos para la tabla `pedido_prod`
--

TRUNCATE TABLE `pedido_prod`;
INSERT INTO `pedido_prod` (`id_pedido`, `id_prod`, `cantidad`)VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 1),
(4, 4, 1),
(4, 5, 2),
(4, 6, 4);

TRUNCATE TABLE `evento`;
INSERT INTO `evento` (`id_artista`, `nombre`, `descripcion`, `fecha`) VALUES
('user2', 'Concierto en vivo', '¡Únete a nosotros para una experiencia musical increíble!', '2024-04-15');

TRUNCATE TABLE `evento_prod`;
INSERT INTO `evento_prod` (`id_evento`, `id_prod`) VALUES
(1, 1);
--
-- Volcado de datos para la tabla `post`
--

TRUNCATE TABLE `post`;
INSERT INTO `post` ( `id_user`, `texto`, `imagen`, `likes`, `origen`, `tags`, `fecha`) VALUES
('user3', '¡Hola mundo!', 'Image1.jpg', 1, NULL, 'saludo, inicio', '2024-03-08'),
('user1', 'Una foto increíble', NULL, 1, NULL, 'foto, arte', '2024-03-09'),
('user1', 'Nuevo descubrimiento musical', 'Image2.jpg', 1, 1, 'música, recomendación', '2024-03-10'),
('user2', '¡Hola a todos!', NULL, 1, NULL, 'saludo, comunidad', '2024-03-11'),
('user2', 'Compartiendo mi último trabajo', 'Image1.jpg', 1, NULL, 'arte, diseño', '2024-03-12'),
('user2', '¡Feliz fin de semana!', 'Image2.jpg', 2, NULL, 'fin de semana, diversión', '2024-03-13'),
('user2', 'Gracias por la recomendación', NULL, 3, 3, 'agradecimiento, música', '2024-03-14'),
('user2', 'Qué buena foto, me encanta', 'Image1.jpg', 2, 2, 'apreciación, arte', '2024-03-15'),
('user2', 'Totalmente de acuerdo contigo', 'Image2.jpg', 1, 4, 'concordancia, comunidad', '2024-03-16');
--
-- Volcado de datos para la tabla `postfav`
--
TRUNCATE TABLE `postfav`;
INSERT INTO `postfav` (`id_post`, `id_user`) VALUES
(1, 'user1'),
(2, 'user1'),
(3, 'user1'),
(4, 'user1'),
(5, 'user1'),
(6, 'user1'),
(6, 'user2'),
(7, 'user3'),
(7, 'user2'),
(7, 'user1'),
(8, 'user3'),
(8, 'user2'),
(9, 'user3');


SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

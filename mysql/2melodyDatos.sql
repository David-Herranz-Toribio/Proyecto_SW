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
INSERT INTO `usuario` (`id_user`, `nickname`, `password`, `foto`, `descripcion`, `karma`, `fecha`, `correo`, `admin`) VALUES
('user1', 'User Uno', '$2y$10$O3c1kBFa2yDK5F47IUqusOJmIANjHP6EiPyke5dD18ldJEow.e0eS', 'Perfil1.jpg', '¡Hola! Soy User Uno.', 100, '2001-03-09', 'user1@gmail.com', 1),
('user2', 'User Dos', '$2y$10$O3c1kBFa2yDK5F47IUqusOJmIANjHP6EiPyke5dD18ldJEow.e0eS', 'Perfil2.jpg', 'Bienvenido a mi perfil.', 80, '2003-03-09', 'user2@gmail.com', 0),
('user3', 'User Tres', '$2y$10$O3c1kBFa2yDK5F47IUqusOJmIANjHP6EiPyke5dD18ldJEow.e0eS', 'Perfil3.jpg', 'Descubre mi mundo.', 120, '2000-03-09', 'user3@gmail.com', 0),
('user4', 'User Cuatro', '$2y$10$O3c1kBFa2yDK5F47IUqusOJmIANjHP6EiPyke5dD18ldJEow.e0eS', 'Perfil2.jpg', '¡Hola! Soy User Cuatro.', 90, '2002-03-09', 'user4@gmail.com', 0),
('user5', 'User Cinco', '$2y$10$O3c1kBFa2yDK5F47IUqusOJmIANjHP6EiPyke5dD18ldJEow.e0eS', 'Perfil1.jpg', '¡Hola! Soy User Cinco.', 110, '2004-03-09', 'user5@gmail.com', 0),
('user6', 'User Seis', '$2y$10$O3c1kBFa2yDK5F47IUqusOJmIANjHP6EiPyke5dD18ldJEow.e0eS', 'Perfil3.jpg', '¡Hola! Soy User Seis.', 70, '2005-03-09', 'user6@gmail.com', 0);


--
-- Volcado de datos para la tabla `artista`
--
TRUNCATE TABLE `artista`;
INSERT INTO `artista` (`id_artista`, `integrantes`) VALUES
('user2', 'John Doe, Jane Smith'),
('user7', 'Usuario Borrado y Billy Jean is not My Lover');



TRUNCATE TABLE `seguidores`;

-- Ejemplo de inserción de datos en la tabla seguidores
INSERT INTO `seguidores` (`id_user`, `id_seguidor`) VALUES
('user1', 'user3'),
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
('user2', 'En proceso', 75.5, '2024-03-09'),
('user1', 'Procesado', 30.2, '2024-03-10');
--
-- Volcado de datos para la tabla `pedido_prod`
--

TRUNCATE TABLE `pedido_prod`;
INSERT INTO `pedido_prod` (`id_pedido`, `id_prod`, `cantidad`)VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 1),
(2, 4, 1),
(3, 5, 2),
(2, 6, 4);

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
('user2', 'Totalmente de acuerdo contigo', 'Image2.jpg', 1, 4, 'concordancia, comunidad', '2024-03-16'),
('user5', 'Bonita Camiseta', 'Image1.jpg', 1, NULL, 'ropa, moda', '2024-03-17'),
('user4', 'Las zapatillas modelo X son muy cómodas y tienen un diseño moderno.', 'Image8.jpg', 2, NULL, 'zapatillas, moda, reseña', '2024-03-23'),
('user6', 'El libro "El gran viaje" es una lectura fascinante, muy recomendado.', 'Image9.jpg', 3, NULL, 'libros, lectura, reseña', '2024-03-24'),
('user4', 'Los ingredientes frescos de nuestra tienda son perfectos para tus recetas.', 'Image10.jpg', 5, NULL, 'ingredientes, cocina, reseña', '2024-03-25'),
('user3', 'Nuestros productos para mascotas son de alta calidad y a tu mascota le encantarán.', 'Image11.jpg', 4, NULL, 'mascotas, cuidado, reseña', '2024-03-26'),
('user4', 'La colección de verano 2024 tiene diseños vibrantes y tejidos frescos.', 'Image12.jpg', 6, NULL, 'ropa, verano, reseña', '2024-03-27'),
('user5', 'La canción tiene una melodía increíble y letras profundas.', 'Image13.jpg', 2, NULL, 'música, canción, reseña', '2024-03-28'),
('user5', 'Es una balada conmovedora que te llegará al corazón.', 'Image14.jpg', 3, NULL, 'música, canción, reseña', '2024-03-29'),
('user6', 'El ritmo te hará mover los pies. ¡No puedes dejar de bailar!', 'Image15.jpg', 5, NULL, 'música, canción, reseña', '2024-03-30'),
('user4', 'Es una canción relajante perfecta para una noche tranquila.', 'Image16.jpg', 4, NULL, 'música, canción, reseña', '2024-03-31'),
('user3', 'La canción te llenará de energía y positividad para empezar el día.', 'Image17.jpg', 6, NULL, 'música, canción, reseña', '2024-04-01');
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

--
-- Volcado de datos para la tabla `canciones y playlist`
--
TRUNCATE TABLE `cancion`;
INSERT INTO `cancion` (`id_cancion`, `titulo`, `imagen`, `fecha`, `id_artista`, `likes`, `ruta`, `duracion`, `tags`) VALUES
(1, 'Canción 1', 'imagen1.jpg', '2024-03-08', 'user2', 100, 'Cancion1.mp3', 240, 'pop, dance'),
(2, 'Canción 2', 'imagen2.jpg', '2024-03-09', 'user2', 85, 'Cancion2.mp3', 180, 'rock'),
(3, 'Canción 3', 'imagen3.jpg', '2024-03-10', 'user2', 120, 'Cancion3.mp3', 300, 'electrónica');


TRUNCATE TABLE `playlist`;-- la duracion esta en segundos
INSERT INTO `playlist` (`id_playlist`, `id_user`, `duracion_total`, `imagen`, `nombre`, `fecha`) VALUES
(10, 'user1', 0, 'playlist_fav.png', 'Favoritos', '2024-03-07'),
(2, 'user2', 200, 'playlist1.jpg', 'Mi Playlist', '2024-03-08'),
(30, 'user2', 0, 'playlist_fav.png', 'Favoritos', '2024-03-08'),
(40, 'user3', 0, 'playlist_fav.png', 'Favoritos', '2024-03-09');

TRUNCATE TABLE `play_cancion`;
INSERT INTO `play_cancion` (`id_playlist`, `id_cancion`) VALUES
(1, 1),
(1, 2),
(1, 3),
(2, 1),
(2, 3),
(3, 2),
(3, 3);

TRUNCATE TABLE `producto_post`;
INSERT INTO `producto_post` (`id_prod`, `id_post`) VALUES
(1, 10),
(6, 11),
(2, 12),
(3, 13),
(4, 14),
(5, 15);

TRUNCATE TABLE `cancion_post`;
INSERT INTO `cancion_post` (`id_cancion`, `id_post`) VALUES
(1, 16),
(2, 17),
(3, 18),
(1, 19),
(1, 20);
--
-- Volcado de datos para la tabla `subs`
--
INSERT INTO `suscripcion` (`id_user`, `tipo`, `fecha_fin`, `archivado` ) VALUES
('user1', 'Mensual', '2024-12-31','0'),
('user2', 'Anual', '2025-06-15','0'),
('user3', 'Diario', '2024-03-20','1');

SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
